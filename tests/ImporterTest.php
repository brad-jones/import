<?php

Brads\Importer::globalise();

class ImporterTest extends PHPUnit_Framework_TestCase
{
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
