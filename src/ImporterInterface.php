<?php namespace Brads;

/**
 * You can use this interface with an IoC Container,
 * allowing you to inject the Importer as a service.
 */
interface ImporterInterface
{
    /**
     * Includes a file with an empty variable scope.
     *
     * @param  string     $file    The path to the file to import.
     * @param  array|null $scope   A custom scope to give to the file.
     * @param  boolean    $require Whether to use require() or include().
     * @return mixed               Anything the file returns.
     */
    public function newImport($file, $scope = null, $require = true);
}
