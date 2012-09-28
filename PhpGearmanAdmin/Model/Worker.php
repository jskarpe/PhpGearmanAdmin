<?php
class PhpGearmanAdmin_Model_Worker
{
	protected $_fileDescriptor;
	protected $_host;
	protected $_jobHandle;
	protected $_commands;

	protected $_server;

	public function __construct(array $data = null)
	{
		if (null !== $data) {
			$this->fromArray($data);
		}
	}

	public function fromArray(array $data)
	{
		foreach ($data as $key => $value) {
			switch ($key) {
				case 'file_descriptor':
					$this->setFileDescriptor($value);
					break;
				case 'host':
					$this->setHost($value);
					break;
				case 'job_handle':
					$this->setJobHandle($value);
					break;
				case 'commands':
					$this->setCommands($value);
					break;
				default:
			}
		}
		return $this;
	}

	public function toArray()
	{
		$a = array();
		if (null !== $this->getFileDescriptor()) {
			$a['file_descriptor'] = $this->getFileDescriptor();
		}
		if (null !== $this->getHost()) {
			$a['host'] = $this->getHost();
		}
		if (null !== $this->getJobHandle()) {
			$a['job_handle'] = $this->getJobHandle();
		}
		if (null !== $this->getCommands()) {
			$a['commands'] = $this->getCommands();
		}
		return $a;
	}

	/**
	 * 
	 * @return string
	 */
	public function getFileDescriptor()
	{
		return $this->_fileDescriptor;
	}

	/**
	 * 
	 * @param string $fileDescriptor
	 */
	public function setFileDescriptor($fileDescriptor)
	{
		$this->_fileDescriptor = $fileDescriptor;
		return $this;
	}

	/**
	 * 
	 * @return string
	 */
	public function getHost()
	{
		return $this->_host;
	}

	/**
	 * 
	 * @param string $host
	 */
	public function setHost($host)
	{
		$this->_host = $host;
		return $this;
	}

	/**
	 * 
	 * @return string
	 */
	public function getJobHandle()
	{
		return $this->_jobHandle;
	}

	/**
	 * 
	 * @param string $jobHandle
	 */
	public function setJobHandle($jobHandle)
	{
		$this->_jobHandle = $jobHandle;
		return $this;
	}

	/**
	 * 
	 * @return array of string
	 */
	public function getCommands()
	{
		return $this->_commands;
	}

	/**
	 * 
	 * @param array|string $commands
	 */
	public function setCommands($commands = null)
	{
		if (!is_array($commands)) {
			$commands = (strpos($commands, ' ') !== false) ? explode(' ', $commands) : $commands;
		}
		$this->_commands = $commands;
		return $this;
	}

	/**
	 * 
	 * @return PhpGearmanAdmin_Model_Server
	 */
	public function getServer()
	{
		return $this->_server;
	}

	/**
	 * 
	 * @param $server
	 */
	public function setServer(PhpGearmanAdmin_Model_Server $server = null)
	{
		$this->_server = $server;
		return $this;
	}
}
