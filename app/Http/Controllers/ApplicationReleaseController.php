<?php

namespace App\Http\Controllers;

use App\Services\ApplicationRelease;

class ApplicationReleaseController extends Controller
{
    public function __invoke(ApplicationRelease $release)
    {
        return response()->json(['version' => $release->version()])
            ->header('Cache-Control', 'no-store, private');
    }
}
