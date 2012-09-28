<?php
// Ensure library is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
	realpath('./../'), get_include_path(),
)));

// Register autoloader
function test_autoloader($class)
{
	include str_replace('_', '/', $class) . '.php';
}
spl_autoload_register('test_autoloader');
