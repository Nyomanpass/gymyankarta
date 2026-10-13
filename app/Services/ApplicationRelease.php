<?php

namespace App\Services;

class ApplicationRelease
{
    public function version(): string
    {
        $file = public_path('build/release.json');
        if (is_file($file)) {
            return (string) (json_decode(file_get_contents($file), true)['version'] ?? 'development');
        }

        $manifest = public_path('build/manifest.json');

        return is_file($manifest) ? hash_file('sha256', $manifest) : 'development';
    }
}
