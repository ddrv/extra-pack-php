<?php

$srcDir = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'src');
require_once ($srcDir.DIRECTORY_SEPARATOR.'Pack.php');

/*
 * fix for using PHPUnit as composer package and PEAR extension
 */
$composerClassName = '\PHPUnit\Framework\TestCase';
$pearClassName = '\PHPUnit_Framework_TestCase';
if (!class_exists($composerClassName) && class_exists($pearClassName)) {
    class_alias($pearClassName, $composerClassName);
}