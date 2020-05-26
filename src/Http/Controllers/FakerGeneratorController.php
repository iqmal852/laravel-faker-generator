<?php

namespace Iqmal\LaravelFakerGenerator\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use File;

class FakerGeneratorController extends Controller
{
    public function index()
    {
        $files = [];

        $filesInFolder = File::files(config('laravel-faker-generator.faker_path'));
        foreach($filesInFolder as $path) {
            $file = pathinfo($path);

            $files[] = $file['basename'];
        }

        return view('laravel-faker-generator::index', [
            'files' => $files
        ]);
    }
}
