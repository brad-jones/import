Brads PHP File Importer
================================================================================
[![Build Status](https://travis-ci.org/brad-jones/import.svg)](https://travis-ci.org/brad-jones/import)
[![Latest Stable Version](https://poser.pugx.org/brad-jones/import/v/stable.svg)](https://packagist.org/packages/brad-jones/import)
[![Total Downloads](https://poser.pugx.org/brad-jones/import/downloads.svg)](https://packagist.org/packages/brad-jones/import)
[![License](https://poser.pugx.org/brad-jones/import/license.svg)](https://packagist.org/packages/brad-jones/import)
[![HHVM Tested](http://hhvm.h4cc.de/badge/brad-jones/import.svg?style=flat)](http://hhvm.h4cc.de/package/brad-jones/import)

Includes a PHP file in such a way as to isolate it from where it was included.
This package provides a new pseudo language construct, you will be familiar with
how ```include``` and ```require``` work, well we have now added ```import```.

Credit: https://gist.github.com/Eraknelo/6795b983825fc6a720ef

Installation:
--------------------------------------------------------------------------------
```
composer require brad-jones/import
```

Getting access to the import function:
--------------------------------------------------------------------------------
There are various ways you can access the import function.

* If using PHP 5.6 or greater, you can import the import function.
  ```php
  use function Brads\import;
  import(...args...);
  ```

* Or you can call the static method on the Importer class.
  ```php
  use Brads\Importer;
  Importer::import(...args...);
  ```

* Or you can create an instance of the Importer.
  ```php
  use Brads\Importer;
  $importer = new Importer;
  $importer->newImport(...args...);
  ```

* Or if you would rather install the import function globally.
  ```php
  Brads\Importer::globalise();
  import(...args...);
  ```

Dependency Injection:
--------------------------------------------------------------------------------
The importer is Di & Test friendly, it implements the ImporterInterface.

A simple contrived [php-di](http://php-di.org/) example:

```php
use Brads\Importer;
use Brads\ImporterInterface;

$builder = new DI\ContainerBuilder();
$builder->addDefinitions
([
    ImporterInterface::class => DI\object(Importer::class)
]);
$container = $builder->build();

$container->get(ImporterInterface::class)->newImport(...args...);
```

Example Usage:
--------------------------------------------------------------------------------
Firstly for these examples assume the contents of ```foo.php``` is:

```php
<?php return get_defined_vars(); ?>
```

Secondly assume we are just using the globalised import function.
Regardless of how you access it the result is the same.

### Exported Value:
The import function will return any value that is returned by the imported file.
Just the same as ```include``` or ```require```. When combined with closures and
a di container, you can end up with something akin to the node.js CommonJs
module system.

```php
$exported = import('foo.php');
```

### Isolated Import:
The whole point of this project is to ensure the imported file does not have
access to any variables from the parent file. So with a normal ```include```
or ```require``` you would have something like this:

```php
$abc = '123';
$exported = include('foo.php');
var_dump($exported == ['abc' => '123']); // true
```

With our import function this is what happens:

```php
$abc = '123';
$exported = include('foo.php');
var_dump($exported == []); // true
```

### Providing a Custom Scope:
Sometimes we might want the imported file to have access to some specific data.

```php
$abc = '123';
$scope = ['bar' => 'baz'];
$exported = include('foo.php', $scope);
var_dump($exported == $scope); // true
```

### Include or Require:
Under the hood import does use the normal ```include``` or ```require```.  
By default we use ```require``` but you can changes this easily.

```php
import('foo.php', null, true);  // requires foo.php
import('foo.php', null, false); // includes foo.php
```
