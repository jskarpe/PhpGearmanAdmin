<?php
class PhpGearmanAdmin_Model_Server
{
	protected $_hostname;
	protected $_port;
	protected $_threads;
	protected $_workers;

	/**
	 * 
	 * @return 
	 */
	public function getHostname()
	{
		return $this->_hostname;
	}

	/**
	 * 
	 * @param $hostname
	 */
	public function setHostname($hostname)
	{
		$this->_hostname = $hostname;
		return $this;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPort()
	{
		return $this->_port;
	}

	/**
	 * 
	 * @param $port
	 */
	public function setPort($port)
	{
		$this->_port = $port;
		return $this;
	}

	/**
	 * 
	 * @return array
	 */
	public function getWorkers($fetch = null)
	{
		if (null === $this->_workers && false !== $fetch) {
			$this->_workers = $this->getMapper()->findWorkers($this);
		}
		return $this->_workers;
	}

	/**
	 * 
	 * @param $workers
	 */
	public function setWorkers(array $workers)
	{
		$this->_workers = $workers;
		return $this;
	}

	/**
	 *
	 * @return array
	 */
	public function getThreads($fetch = null)
	{
		if (null === $this->_threads && false !== $fetch) {
			$this->_threads = $this->getMapper()->findStatus($this);
		}
		return $this->_threads;
	}

	/**
	 *
	 * @param $threads
	 */
	public function setThreads(array $threads)
	{
		$this->_threads = $threads;
		return $this;
	}

	public function getMapper()
	{
		return $this->_mapper;
	}

	public function setMapper(PhpGearmanAdmin_Model_Server_Mapper $mapper)
	{
		$this->_mapper = $mapper;
		return $this;
	}
}
