<?php

namespace Iqmal\LaravelFakerGenerator\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use File;
use Iqmal\LaravelFakerGenerator\Db\FakerGeneratorDBAccess;
use Iqmal\LaravelFakerGenerator\Http\Requests\GenerateFileRequest;
use Iqmal\LaravelFakerGenerator\LaravelFakerGenerator;

class FakerGeneratorController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $files = $this->getFilesList();

        return view('laravel-faker-generator::index', [
            'files' => $files
        ]);
    }

    /**
     * Show Create Page to pick table
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('laravel-faker-generator::create', [
            'tables' => FakerGeneratorDBAccess::getDBTableList()
        ]);
    }

    public function show($table)
    {
        return view('laravel-faker-generator::show', [
            'table'   => $table,
            'columns' => FakerGeneratorDBAccess::getTableDetails($table),
            'tables'  => FakerGeneratorDBAccess::getDBTableList()
        ]);
    }

    public function generate(GenerateFileRequest $request, $table)
    {
        $request->request->add(['table' => $table]);

        LaravelFakerGenerator::generate($request->all());

        toastr()->success('Successfully Generate Faker for table . ' . $table);

        return redirect()->route('laravel-faker-generator.create');
    }

    /**
     * Get all files list from faker directory3
     *
     * @return array
     */
    protected function getFilesList(): array
    {
        $files = [];

        $filesInFolder = File::files(config('laravel-faker-generator.faker_path'));
        foreach ($filesInFolder as $path) {
            $file = pathinfo($path);

            $files[] = $file['basename'];
        }

        return $files;
    }
}
