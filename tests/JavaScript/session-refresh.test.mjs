import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { runInNewContext } from 'node:vm';

const source = readFileSync(new URL('../../resources/js/app.js', import.meta.url), 'utf8');
function browser() {
    const events = {};
    const state = { reloads: 0, fetches: 0, notice: null, tick: null, hook: null };
    const element = () => ({
        children: [], setAttribute() {}, addEventListener(name, fn) { this[name] = fn; },
        append(child) { this.children.push(child); }, get firstElementChild() { return this.children[0]; },
    });
    const document = {
        hidden: false,
        querySelector(selector) {
            if (selector.includes('app-release-url')) return { content: '/app-release' };
            if (selector.includes('app-release')) return { content: 'old' };
            return null;
        },
        addEventListener(name, fn) { events[name] = fn; },
        getElementById() { return state.notice; }, createElement: element,
        body: { append(node) { state.notice = node; } },
    };
    const window = {
        location: { reload() { state.reloads++; } },
        addEventListener(name, fn) { events[name] = fn; },
        Livewire: { hook(name, fn) { state.hook = fn; } },
    };
    runInNewContext(source, {
        document, window, Date,
        setInterval(fn) { state.tick = fn; },
        async fetch(url, options) {
            assert.equal(url, '/app-release');
            assert.equal(options.cache, 'no-store');
            state.fetches++;
            return { ok: true, json: async () => ({ version: 'new' }) };
        },
    });
    return { events, state };
}

test('new release refreshes an idle page', async () => {
    const { state } = browser();
    await state.tick();
    assert.equal(state.reloads, 1);
});

test('new release preserves unsaved input until user chooses reload', async () => {
    const { events, state } = browser();
    events.input();
    await state.tick();
    assert.equal(state.reloads, 0);
    assert.match(state.notice.firstElementChild.textContent, /belum disimpan/);
    state.notice.children[1].click();
    assert.equal(state.reloads, 1);
});

test('new release cannot interrupt a pending Livewire request', async () => {
    const { state } = browser();
    state.hook({ succeed() {}, fail() {} });
    await state.tick();
    assert.equal(state.reloads, 0);
    assert.ok(state.notice);
});

test('expired session offers recovery without replaying a submission', () => {
    const { state } = browser();
    let onFailure;
    let prevented = false;
    state.hook({ succeed() {}, fail(callback) { onFailure = callback; } });
    onFailure({ status: 419, preventDefault() { prevented = true; } });
    assert.equal(prevented, true);
    assert.equal(state.fetches, 0);
    assert.equal(state.reloads, 0);
    assert.match(state.notice.firstElementChild.textContent, /kedaluwarsa/);
});

test('restoring browser history refreshes a clean page', () => {
    const { events, state } = browser();
    events.pageshow({ persisted: true });
    assert.equal(state.reloads, 1);
});
