<?php

namespace Iqmal\LaravelFakerGenerator\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Iqmal\LaravelFakerGenerator\Db\FakerGeneratorDBAccess;
use Iqmal\LaravelFakerGenerator\Http\Requests\GenerateFileRequest;
use Iqmal\LaravelFakerGenerator\LaravelFakerGenerator;

class FakerGeneratorController extends Controller
{
    /**
     * Listing all faker files
     *
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
        return view('laravel-faker-generator::show', [
            'tables' => FakerGeneratorDBAccess::getDBTableList()
        ]);
    }

    /**
     * Run artisan to seed faker data
     *
     * @param $class
     *
     * @return RedirectResponse
     */
    public function run($class): RedirectResponse
    {
        $fullClassName = (new LaravelFakerGenerator())->getFullClassNamespace($class);

        Artisan::call('db:seed --class=' . $fullClassName);

        Session::flash('alert-success', Artisan::output());

        return redirect()->back();
    }

    /**
     * Delete faker class file
     *
     * @param $class
     *
     * @return RedirectResponse
     */
    public function destroy($class)
    {
        unlink(config('laravel-faker-generator.faker_path') . '/' . $class . '.php');

        Session::flash('alert-danger', 'Successfully unlink file ' . $class . '.php');

        return redirect()->back();
    }

    /**
     * @param $table
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($table)
    {
//        dd(Session::all());
        return view('laravel-faker-generator::create', [
            'table'   => $table,
            'columns' => FakerGeneratorDBAccess::getTableDetails($table),
            'tables'  => FakerGeneratorDBAccess::getDBTableList()
        ]);
    }

    /**
     * Generate faker file
     *
     * @param GenerateFileRequest $request
     * @param $table
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generate(GenerateFileRequest $request, $table)
    {
        $request->request->add(['table' => $table]);

        LaravelFakerGenerator::generate($request->all());

        Session::flash('alert-success', 'Successfully Generate Faker for table ' . $table);

        return redirect()->route('laravel-faker-generator.index');
    }

    /**
     * Get all files list from faker directory
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
