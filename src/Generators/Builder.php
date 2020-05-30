<?php

namespace Iqmal\LaravelFakerGenerator\Generators;

use Illuminate\Support\Str;
use Iqmal\LaravelFakerGenerator\Db\FakerGeneratorDBAccess;

class Builder
{
    /**
     * @var string
     */
    protected $table;

    /**
     * Builder constructor.
     */
    public function __construct()
    {

    }

    /**
     * Build the faker field
     *
     * @param $field
     * @param int $rows
     *
     * @return string
     */
    public static function build($field, $rows = 1)
    {
        $self        = new static;
        $self->table = $field['table'];

        return $self->constructArrayAsString($field, $rows);

    }

    /**
     * Print array string too loop and constructing field
     *
     * @param array $fields
     * @param $rows
     *
     * @return string
     */
    private function constructArrayAsString(array $fields, $rows): string
    {
        $string = 'for ($x = 0; $x <= ' . $rows . '; $x++) { ' . PHP_EOL;
        $string .= '    $entries[] = [' . PHP_EOL;

        $fields = $this->removeUnnecessaryKey($fields);

        foreach ($fields as $key => $value) {
            echo $key . PHP_EOL;
            if ($value !== 'increment') {
                $string .= '        "' . $key . '" => ' . $this->{$value}($key) . PHP_EOL;
            }

        }

        $string .= '    ];' . PHP_EOL;
        $string .= '}';

        return $string;
    }

    /**
     * Print code to generate name
     *
     * @param string|null $column
     *
     * @return string
     */
    protected function name(?string $column): string
    {
        return '$faker->name,';
    }

    /**
     * Print code for unique email
     *
     * @param string|null $column
     *
     * @return string
     */
    protected function email(?string $column): string
    {
        return '$prefixUnique . ++$x . $faker->unique()->safeEmail,';
    }

    /**
     * Print code for hashed password
     *
     * @param string|null $column
     *
     * @return string
     */
    protected function password(?string $column): string
    {
        return '$password,';
    }

    /**
     * print code for $now time
     *
     * @param string|null $column
     *
     * @return string
     */
    protected function now(?string $column): string
    {
        return '$now,';
    }

    /**
     * Print code for a random string generator
     *
     * @param string|null $column
     *
     * @return string
     */
    protected function string_random(?string $column): string
    {
        $length = FakerGeneratorDBAccess::describeColumn($this->table, $column);
        return "Str::random($length)";
    }

    /**
     * Remove Unnecessary Key From Data Array
     *
     * @param array $data
     *
     * @return array
     */
    private function removeUnnecessaryKey(array $data): array
    {
        unset($data['table'], $data['_token'], $data['truncate'], $data['rows']);

        return $data;
    }
}
