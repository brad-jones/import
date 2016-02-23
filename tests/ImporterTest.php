<?php

class ImporterTest extends PHPUnit_Framework_TestCase
{
    public function testImportViaInstance()
    {
        $this->assertEquals(array(), (new Brads\Importer())->newImport(__DIR__.'/import-test-file.php'));
    }

    public function testImportViaStatic()
    {
        $this->assertEquals(array(), Brads\Importer::import(__DIR__.'/import-test-file.php'));
    }

    public function testImportViaNamespacedFunction()
    {
        $this->assertEquals(array(), Brads\import(__DIR__.'/import-test-file.php'));
    }

    public function testImportGlobalise()
    {
        $this->assertFalse(function_exists('import'));
        Brads\Importer::globalise();
        $this->assertTrue(function_exists('import'));
    }

    // NOTE: Remaining tests make use of the global function.

    public function testImportWithoutScope()
    {
        $this->assertEquals(array(), import(__DIR__.'/import-test-file.php'));
    }

    public function testImportWithScope()
    {
        $scope = array('foo' => 'bar');
        $this->assertEquals($scope, import(__DIR__.'/import-test-file.php', $scope));
    }

    public function testImportInclude()
    {
        $this->setExpectedExceptionRegExp
        (
            'PHPUnit_Framework_Error_Warning',
            '/^include\(not_existing_file\.php\)/'
        );

        import('not_existing_file.php', null, false);
    }
}
