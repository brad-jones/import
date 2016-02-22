<?php namespace Brads;

// Original idea came from:
// https://gist.github.com/Eraknelo/6795b983825fc6a720ef

class Importer
{
    /**
     * Includes a file with an empty variable scope.
     *
     * @param  string     $file    The path to the file to import.
     * @param  array|null $scope   A custom scope to give to the file.
     * @param  boolean    $require Whether to use require() or include().
     * @return mixed               Anything the file returns.
     */
    public static function import($file, $scope = null, $require = true)
    {
        unset($file, $scope, $require);

        if (count(func_get_args()) >= 2 && func_get_arg(1) !== null)
        {
            extract(func_get_arg(1));
        }

        if (count(func_get_args()) < 3 || func_get_arg(2) === true)
        {
            $exports = require func_get_arg(0);
        }
        else
        {
            $exports = include func_get_arg(0);
        }

        return $exports;
    }

    /**
     * Imports a global version of the ```import()``` function.
     *
     * @return void
     */
    public static function globalise()
    {
        Importer::import(__DIR__.'/function.php');
    }
}

/**
 * Includes a file with an empty variable scope.
 *
 * You can "use" this function with PHP 5.6 if you like.
 * ```php
 * use function Brads\import;
 * ```
 *
 * @param  string     $file    The path to the file to import.
 * @param  array|null $scope   A custom scope to give to the file.
 * @param  boolean    $require Whether to use require() or include().
 * @return mixed               Anything the file returns.
 */
function import($file, $scope = null, $require = true)
{
    return Importer::import($file, $scope, $require);
}
