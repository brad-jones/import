<?php

if (!function_exists('import'))
{
    /**
     * Includes a file with an empty variable scope.
     *
     * @param  string     $file    The path to the file to import.
     * @param  array|null $scope   A custom scope to give to the file.
     * @param  boolean    $require Whether to use require() or include().
     * @return mixed               Anything the file returns.
     */
    function import($file, $scope = null, $require = true)
    {
        return Brads\Importer::import($file, $scope, $require);
    }
}
