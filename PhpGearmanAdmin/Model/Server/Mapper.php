<?php
class PhpGearmanAdmin_Model_Server_Mapper
{
	protected $_adapter;
	protected $_options;
	protected $_threadMapper;
	
	public function setOptions(array $options = null)
	{
		$this->_options = $options;
		return $this;
	}
	
	public function getOptions()
	{
		return $this->_options;
	}
	
	public function find($hostname = 'localhost', $port = 4730)
	{
		$server = new PhpGearmanAdmin_Model_Server();
		$server->setMapper($this);
		$server->setHostname($hostname);
		$server->setPort($port);
		return $server;
	}
	
	public function findStatus(PhpGearmanAdmin_Model_Server $server)
	{
		$adapter = $this->getAdapter();
		$result = $adapter->status($server->getHostname(), $server->getPort());
		$threads = array();
		foreach ($result as $name => $threadArray) {
			$threadArray['name'] = $name;
			$threads[] = new PhpGearmanAdmin_Model_Thread($threadArray);
		}
		return $threads;
	}
	
	public function findWorkers(PhpGearmanAdmin_Model_Server $server)
	{
		$adapter = $this->getAdapter();
		$result = $adapter->workers($server->getHostname(), $server->getPort());
		$workers = array();
		foreach ($result as $w) {
			 $worker = new PhpGearmanAdmin_Model_Worker($w);
			 $worker->setServer($server);
			 $workers[] = $worker;
		}
		return $workers;
	}
	
	public function getAdapter()
	{
		if (null === $this->_adapter) {
			$options = $this->getOptions();
			$config = isset($options['adapter']) ? $options['adapter'] : null;
			$this->_adapter = new PhpGearmanAdmin_Model_Server_Mapper_Adapter_Socket($config);
		}
		return $this->_adapter;
	}
	
	public function setAdapter(PhpGearmanAdmin_Model_Server_Mapper_Adapter_AdapterAbstract $adapter)
	{
		$this->_adapter = $adapter;
		return $this;
	}
	
	public function getThreadMapper()
	{
		if (null === $this->_threadMapper) {
			$this->_threadMapper = new PhpGearmanAdmin_Model_Thread_Mapper();
		}
		return $this->_threadMapper;
	}
	
	public function setThreadMapper(PhpGearmanAdmin_Model_Thread_Mapper $mapper)
	{
		$this->_threadMapper = $mapper;
		return $this;
	}
}