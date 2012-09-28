<?php
abstract class PhpGearmanAdmin_Model_Server_Mapper_Adapter_AdapterAbstract
{
	protected $_options;
	
	public function __construct(array $options = null)
	{
		if (null !== $options) {
			$this->setOptions($options);
		}
	}
	
	public function setOptions(array $options = null)
	{
		$this->_options = $options;
		return $this;
	}
	
	public function getOptions()
	{
		return $this->_options;
	}
	
	abstract function status($hostname = 'localhost', $port = 4730);

}