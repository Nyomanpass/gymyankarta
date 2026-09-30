<?php

use App\Http\Middleware\PreventHtmlCaching;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

it('replaces stale HTML cache policies and validators', function () {
    $response = new Response('<html>Updated</html>', 200, [
        'Content-Type' => 'text/html; charset=UTF-8',
        'Cache-Control' => 'public, max-age=86400, immutable',
        'ETag' => '"old-release"',
        'Last-Modified' => 'Wed, 30 Sep 2026 00:00:00 GMT',
    ]);

    $result = (new PreventHtmlCaching)->handle(Request::create('/'), fn () => $response);

    expect($result->headers->hasCacheControlDirective('no-store'))->toBeTrue()
        ->and($result->headers->hasCacheControlDirective('private'))->toBeTrue()
        ->and($result->headers->hasCacheControlDirective('immutable'))->toBeFalse()
        ->and($result->headers->hasCacheControlDirective('public'))->toBeFalse()
        ->and($result->headers->has('ETag'))->toBeFalse()
        ->and($result->headers->has('Last-Modified'))->toBeFalse()
        ->and($result->getContent())->toBe('<html>Updated</html>');
});

it('preserves cache policies for non HTML responses', function (string $type) {
    $response = new Response('content', 200, [
        'Content-Type' => $type,
        'Cache-Control' => 'public, max-age=31536000, immutable',
        'ETag' => '"asset-version"',
    ]);
    $headers = $response->headers->all();

    $result = (new PreventHtmlCaching)->handle(Request::create('/asset'), fn () => $response);

    expect($result->headers->all())->toBe($headers);
})->with(['text/css', 'application/javascript', 'application/json', 'image/png']);
