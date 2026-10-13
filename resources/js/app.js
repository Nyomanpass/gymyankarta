// Fetch fresh HTML after releases / expired sessions without replaying a mutation.
const version = document.querySelector('meta[name="app-release"]')?.content;
const versionUrl = document.querySelector('meta[name="app-release-url"]')?.content;
let dirty = false;
let pending = 0;
let checking = false;
let lastCheck = 0;

function reloadFresh() {
    window.location.reload();
}

function offerReload(message) {
    let banner = document.getElementById('application-refresh-notice');
    if (!banner) {
        banner = document.createElement('div');
        banner.id = 'application-refresh-notice';
        banner.setAttribute('role', 'alert');
        banner.className = 'fixed bottom-4 left-4 right-4 z-[100] mx-auto max-w-xl rounded-2xl border border-orange-200 bg-white p-4 shadow-xl flex flex-wrap items-center justify-between gap-3 text-sm text-warna-300';
        const text = document.createElement('p');
        text.className = 'flex-1 min-w-0';
        banner.append(text);
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'rounded-xl bg-warna-400 text-white px-4 py-2 font-semibold';
        button.textContent = 'Muat ulang';
        button.addEventListener('click', reloadFresh);
        banner.append(button);
        document.body.append(banner);
    }
    banner.firstElementChild.textContent = message;
}

// Conservatively protect unsaved form fields, carts, and camera workflows.
document.addEventListener('input', () => { dirty = true; }, true);
document.addEventListener('change', () => { dirty = true; }, true);
document.addEventListener('click', (event) => {
    if (event.target.closest('[wire\\:click], [role="option"]')) dirty = true;
}, true);

function refreshForUpdate() {
    if (dirty || pending || document.querySelector('#qr-reader')) {
        offerReload('Versi aplikasi baru tersedia. Selesaikan pekerjaan Anda sebelum memuat ulang; isian yang belum disimpan akan hilang.');
    } else {
        reloadFresh();
    }
}

async function checkRelease() {
    if (!version || !versionUrl || checking || document.hidden || Date.now() - lastCheck < 15000) return;
    checking = true;
    lastCheck = Date.now();
    try {
        const response = await fetch(versionUrl, { cache: 'no-store', credentials: 'same-origin', headers: { Accept: 'application/json' } });
        if (!response.ok) return;
        const data = await response.json();
        if (typeof data.version === 'string' && data.version !== version) refreshForUpdate();
    } catch {
        // Offline: leave the current page intact and check on reconnection.
    } finally {
        checking = false;
    }
}

window.addEventListener('pageshow', (event) => {
    if (event.persisted) {
        if (dirty) offerReload('Halaman dipulihkan dari riwayat browser. Muat ulang untuk menyegarkan sesi; isian yang belum disimpan akan hilang.');
        else reloadFresh();
    }
});
document.addEventListener('visibilitychange', () => { if (!document.hidden) checkRelease(); });
window.addEventListener('online', checkRelease);
if (version && versionUrl) setInterval(checkRelease, 60000);

let hooksInstalled = false;
function installLivewireHooks() {
    if (hooksInstalled || !window.Livewire) return;
    hooksInstalled = true;
    window.Livewire.hook('request', ({ succeed, fail }) => {
        pending++;
        succeed(() => { pending = Math.max(0, pending - 1); });
        fail(({ status, preventDefault }) => {
            pending = Math.max(0, pending - 1);
            if (status === 419) {
                preventDefault();
                offerReload('Sesi halaman sudah kedaluwarsa. Muat ulang, lalu masuk atau kirim kembali formulir. Isian yang belum disimpan akan hilang.');
            }
        });
    });
}
document.addEventListener('livewire:init', installLivewireHooks);
installLivewireHooks();
