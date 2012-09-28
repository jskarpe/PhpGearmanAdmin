<?php
class PhpGearmanAdmin_Monitor
{
	protected $_options;
	protected $_serverMapper;
	
	public function __construct(array $options = null)
	{
		if (null !== $options) {
			$this->setOptions($options);
		}
	}
	
	public function setOptions(array $options)
	{
		$this->_options = $options;
		return $this;
	}
	
	public function getOptions()
	{
		return $this->_options;
	}
	
	public function isThreadRunning($name, $hostname = 'localhost', $port = 4730)
	{
		$server = $this->getServerMapper()->find($hostname, $port);
		$threads = $server->getThreads();
		foreach ($threads as $thread) {
			if ($name == $thread->getName() && $thread->getJobsRunning() > 0) {
				return true;
			}
		}
		return false;
	}
	
	public function getServerMapper()
	{
		if (null === $this->_serverMapper) {
			$options = $this->getOptions();
			$config = (isset($options['server_mapper'])) ? $options['server_mapper'] : null;
			$this->_serverMapper = new PhpGearmanAdmin_Model_Server_Mapper($config);
		}
		return $this->_serverMapper;
	}
	
	public function setServerMapper(PhpGearmanAdmin_Model_Server_Mapper $mapper)
	{
		$this->_serverMapper = $mapper;
		return $this;
	}
}