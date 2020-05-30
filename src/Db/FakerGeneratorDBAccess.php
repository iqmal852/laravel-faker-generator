<?php

namespace Iqmal\LaravelFakerGenerator\Db;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;

class FakerGeneratorDBAccess
{
    /**
     * This table will be ignore from reading
     *
     * @var array
     */
    protected $ignoreTableList = [
        'migrations',
        'password_resets',
        'failed_jobs',
        'jobs'
    ];

    /**
     * Get table list from a table
     *
     * @return array
     */
    public static function getDBTableList(): array
    {
        $names        = [];
        $tables       = DB::select('SHOW TABLES');
        $getObjDBName = 'Tables_in_' . DB::connection()->getDatabaseName();

        foreach ($tables as $table) {
            $name = $table->{$getObjDBName};
            if (!in_array($name, (new static)->ignoreTableList, true)) {
                $names[] = $name;
            }
        }

        return $names;
    }

    /**
     * Pull columns and type information from a table
     *
     * @param $table
     *
     * @return array
     */
    public static function getTableDetails(string $table) : array
    {
        $stack = [];
        $columns = Schema::getColumnListing($table);

        foreach($columns as $column) {
            $type = Schema::getColumnType($table, $column);

            $stack[$column] = $type;
        }

        return $stack;
    }

    /**
     * @param $table
     *
     * @return mixed
     */
    public static function describeColumn($table, $column)
    {
        $dbName = DB::connection()->getDatabaseName();
        $statement = "SELECT CHARACTER_MAXIMUM_LENGTH as length FROM information_schema.columns WHERE TABLE_SCHEMA = '" . $dbName . "' AND TABLE_NAME = '" . $table . "' AND COLUMN_NAME = '". $column ."'";

        $columns = DB::select(DB::connection()->raw($statement));

        return $columns[0];
    }
}
