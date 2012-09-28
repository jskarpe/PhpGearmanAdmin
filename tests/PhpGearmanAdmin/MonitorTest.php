<?php
class MonitorTest extends PHPUnit_Framework_TestCase
{
	public function testIsRunning()
	{
		$adapterOptions['request_timeout'] = 2;
		$mapperOptions['adapter'] = $adapterOptions;
		$monitorOptions['server_mapper'] = $mapperOptions;
		
		$monitor = new PhpGearmanAdmin_Monitor($monitorOptions);
		$result = $monitor->isThreadRunning('testThread', 'localhost');
		
		
		
		var_dump($result);
	}
}