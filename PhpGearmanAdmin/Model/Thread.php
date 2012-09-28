<?php
class PhpGearmanAdmin_Model_Thread
{
	protected $name;
	protected $inQueue;
	protected $jobsRunning;
	protected $capableWorkers;

	protected $server;

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
				case 'name':
					$this->setName($value);
					break;
				case 'in_queue':
					$this->setInQueue($value);
					break;
				case 'jobs_running':
					$this->setJobsRunning($value);
					break;
				case 'capable_workers':
					$this->setCapableWorkers($value);
					break;
			}
		}
		return $this;
	}

	public function toArray()
	{
		$a = array();
		if (null !== $this->getName()) {
			$a['name'] = $this->getName();
		}
		if (null !== $this->getInQueue()) {
			$a['in_queue'] = $this->getInQueue();
		}
		if (null !== $this->getJobsRunning()) {
			$a['jobs_running'] = $this->getJobsRunning();
		}
		if (null !== $this->getCapableWorkers()) {
			$a['capable_workers'] = $this->getCapableWorkers();
		}
		return $a;
	}

	/**
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}

	/**
	 * 
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->_name = $name;
		return $this;
	}

	/**
	 * 
	 * @return numeric
	 */
	public function getInQueue()
	{
		return $this->_inQueue;
	}

	/**
	 * 
	 * @param numeric $inQueue
	 */
	public function setInQueue($inQueue)
	{
		$this->_inQueue = $inQueue;
		return $this;
	}

	/**
	 * 
	 * @return numeric
	 */
	public function getJobsRunning()
	{
		return $this->_jobsRunning;
	}

	/**
	 * 
	 * @param numeric $jobsRunning
	 */
	public function setJobsRunning($jobsRunning)
	{
		$this->_jobsRunning = $jobsRunning;
		return $this;
	}

	/**
	 * 
	 * @return numeric
	 */
	public function getCapableWorkers()
	{
		return $this->_capableWorkers;
	}

	/**
	 * 
	 * @param numeric $capableWorkers
	 */
	public function setCapableWorkers($capableWorkers)
	{
		$this->_capableWorkers = $capableWorkers;
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
