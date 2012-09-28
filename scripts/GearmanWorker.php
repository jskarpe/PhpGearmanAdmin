<?php
/**
 *
 * Gearman thread nagios plugin
 *
 * Usage: script.php WorkerName $HOSTNAME$ $GEARMANPORT$
 * where $HOSTNAME$ and $GEARMANPORT$ defaults to: localhost:4730 and thus
 * optional.
 */

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

/**
Nagios exit codes:
0 OK The plugin was able to check the service and it appeared to be functioning properly
1 Warning The plugin was able to check the service, but it appeared to be above some "warning" threshold or did not appear to be working properly
2 Critical The plugin detected that either the service was not running or it was above some "critical" threshold
3 Unknown Invalid command line arguments were supplied to the plugin or low-level failures internal to the plugin (such as unable to fork, or open a tcp socket) that prevent it from performing the specified operation. Higher-level errors (such as name resolution errors, socket timeouts, etc) are outside of the control of plugins and should generally NOT be reported as UNKNOWN states.
 */
if (PHP_SAPI === 'cli') {
	if (!isset($argv[1])) {
		echo "UNKOWN No arguments found - aborting..\n";
		exit(3);
	}

	$workerName = $argv[1];
	$hostname = isset($argv[2]) ? $argv[2] : 'localhost';
	$port = isset($argv[3]) ? $argv[3] : 4730;

	$monitor = new PhpGearmanAdmin_Monitor();
	try {
		$result = $monitor->isThreadRunning($workerName, $hostname, $port);
	} catch (Exception $e) {
		echo "UNKNOWN " . $e->getMessage() . "\n";
		exit(3);
	}
	if (true === $result) {
		echo "OK Command named: $workerName is running on host: $hostname:$port\n";
		exit(0);
	} else {
		echo "CRITICAL Command named: $workerName is not running on host $hostname:$port\n";
		exit(2);
	}
}
