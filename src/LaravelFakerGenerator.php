<?php

namespace Iqmal\LaravelFakerGenerator;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Iqmal\LaravelFakerGenerator\Generators\Builder;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;

class LaravelFakerGenerator
{
    /**
     * @var PhpFile
     */
    protected $file;

    /**
     * LaravelFakerGenerator constructor.
     */
    public function __construct()
    {
        $this->file = new PhpFile();
    }

    /**
     * Generate a complete faker file
     *
     * @param array $data
     *
     * @return string
     */
    public static function generate(array $data)
    {
        $table      = $data['table'];
        $truncation = $data['truncate'] ?? false;
        $rows       = $data['row'] ?? 100;
        $self       = new static;

        $className = ucwords($table) . 'Faker';
        $file      = new PhpFile;

        //Create name space
        $namespace = $file->addNamespace('App\Faker')
            ->addUse(DB::class)
            ->addUse(Factory::class)
            ->addUse(Str::class)
            ->addUse(Seeder::class);

        //Construct Class
        $class = $namespace->addClass($className);
        $class->setExtends(Seeder::class);

        //Add Method
        $runMethod = $class->addMethod('run')
            ->addComment('Seed the application\'s database. ' . PHP_EOL)
            ->addComment('@return void');

        //Check if need to truncate the data or not
        if ($truncation) {
            $runMethod->addBody('DB::table("' . $table . '")->truncate();');
        }

        //Create array for build data
        $field = Builder::build($data, $rows);

        //Adding Body for the class object
        $runMethod->addBody('$faker = Factory::create();' . PHP_EOL);
        $runMethod->addBody('$entries = [];' . PHP_EOL);
        $runMethod->addBody('$now = now();' . PHP_EOL);
        $runMethod->addBody('$prefixUnique = Str::random(4);' . PHP_EOL);
        $runMethod->addBody('$password = bcrypt("password");' . PHP_EOL);
        $runMethod->addBody($field . PHP_EOL);
        $runMethod->addBody($self->insertionCode($table));

        // or use PsrPrinter for output compatible with PSR-2 / PSR-12
        $content = (new PsrPrinter)->printFile($file);

        //Make Directory if it doesnt exist
        $self->createFile($className, $content);

        return $className;
    }

    /**
     * Create chunking to prevent error overload on insertion
     *
     * @param $table
     *
     * @return string
     */
    private function insertionCode($table)
    {
        $str = 'foreach(array_chunk($entries, 5000) as $arr) {' . PHP_EOL;
        $str .= '   DB::table("' . $table . '")->insert($arr);' . PHP_EOL;
        $str .= '}' . PHP_EOL;

        return $str;
    }

    /**
     * Create Directory if it doesnt exist
     *
     * @return void
     */
    private function createDirectory(): void
    {
        if (!File::isDirectory(config('laravel-faker-generator.faker_path'))) {
            File::makeDirectory(config('laravel-faker-generator.faker_path'));
        }
    }

    /**
     * Generate file for faker
     *
     * @param $className
     * @param $content
     */
    private function createFile($className, $content): void
    {
        $this->createDirectory();

        File::put(config('laravel-faker-generator.faker_path') . '/' . $className . '.php', $content);
    }
}
