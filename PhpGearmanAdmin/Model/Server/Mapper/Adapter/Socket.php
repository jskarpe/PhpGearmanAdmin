<?php
class PhpGearmanAdmin_Model_Server_Mapper_Adapter_Socket extends
		PhpGearmanAdmin_Model_Server_Mapper_Adapter_AdapterAbstract
{
	protected $_socket;

	public function status($hostname = 'localhost', $port = 4730)
	{
		$result = $this->_sendCommand('status', $hostname, $port);
		$status = array();
		if ('.' == $result) {
			return $status;
		}
		foreach ($result as $t) {
			list($function, $inQueue, $jobsRunning, $capable) = explode("\t", $t);
			$status[$function] = array(
				'in_queue' => $inQueue, 'jobs_running' => $jobsRunning, 'capable_workers' => $capable
			);
		}
		return $status;
	}

	public function workers($hostname = 'localhost', $port = 4730)
	{
		$result = $this->_sendCommand('workers', $hostname, $port);
		$workers = array();
		foreach ($result as $t) {
			// FD IP-ADDRESS CLIENT-ID : FUNCTION
			if (preg_match("~^(\d+)[ \t](.*?)[ \t](.*?) : ?(.*)~", $t, $matches)) {
				$fd = $matches[1];
				$workers[] = array(
						'file_descriptor' => $fd,
						'host' => $matches[2],
						'job_handle' => $matches[3],
						'commands' => $matches[4],
				);
			}

			// 			list($function, $inQueue, $jobsRunning, $capable) = explode("\t", $t);
			// 			$status[$function] = array(
			// 					'in_queue' => $inQueue,
			// 					'jobs_running' => $jobsRunning,
			// 					'capable_workers' => $capable
			// 			);
		}
		return $workers;
	}

	public function getJobStatus($hostname = 'localhost', $port = 4730)
	{
		define('GRAB_JOB', 0x0009);

		// "\0REQ"
		$req = pack('a', 'REQ'); // NUL padded string

		$command = $req . GRAB_JOB . 0x0000;

		var_dump($command);

		// Connect to server
		$errno = null;
		$errstr = null;
		$options = $this->getOptions();
		$requestTimeout = isset($options['request_timeout']) ? $options['request_timeout'] : null;
		$socket = fsockopen('tcp://' . $hostname, $port, $errno, $errstr, $requestTimeout);
		if (!is_resource($socket) || feof($socket)) {
			throw new PhpGearmanAdmin_Exception(
					__METHOD__ . ' Failed to obtain connection to ' . $hostname . ':' . $port . ' ' . $errstr,
					PhpGearmanAdmin_Exception::CONNECT_FAILED);
		}

		// Send request
		if (false === fwrite($socket, $command)) {
			require_once 'PhpGearmanAdmin/Exception.php';
			throw new PhpGearmanAdmin_Exception(__METHOD__ . ' Writing request to socket failed',
					PhpGearmanAdmin_Exception::REQUEST_FAILED);
		}

		// Read response
		$response = fread($socket, 64);
		var_dump(bin2hex($response));

		// 		$firstLine = fgets($socket);
		// 		if ($firstLine === false) {
		// 			require_once 'PhpGearmanAdmin/Exception.php';
		// 			throw new PhpGearmanAdmin_Exception(__METHOD__ . ' Reading of socket failed',
		// 					PhpGearmanAdmin_Exception::READ_FAILED);
		// 		}

	}

	/**
	 *  This sets the maximum queue size for a function. If no size is
	given, the default is used. If the size is negative, then the queue
	is set to be unlimited. This sends back a single line with "OK".
	
	Arguments:
	- Function name.
	- Optional maximum queue size.
	 */
	public function setMaxQueue($hostname = 'localhost', $port = 4730, $worker, $size)
	{
		return $this->_sendCommand('maxqueue', $hostname, $port);
	}

	public function version($hostname = 'localhost', $port = 4730)
	{
		return $this->_sendCommand('version', $hostname, $port);
	}

	protected function _sendCommand($command, $hostname = 'localhost', $port = 4730)
	{
		// Connect to server
		$errno = null;
		$errstr = null;
		$options = $this->getOptions();
		$requestTimeout = isset($options['request_timeout']) ? $options['request_timeout'] : 1;
		$socket = @fsockopen('tcp://' . $hostname, $port, $errno, $errstr, $requestTimeout);
		if (!is_resource($socket) || feof($socket)) {
			throw new PhpGearmanAdmin_Exception(
					__METHOD__ . ' Failed to obtain connection in ' . $requestTimeout . 's to host: ' . $hostname . ':'
							. $port . ' ' . $errstr, PhpGearmanAdmin_Exception::CONNECT_FAILED);
		}

		// Send request
		if (false === fwrite($socket, $command . "\n")) {
			require_once 'PhpGearmanAdmin/Exception.php';
			throw new PhpGearmanAdmin_Exception(__METHOD__ . ' Writing request to socket failed',
					PhpGearmanAdmin_Exception::REQUEST_FAILED);
		}

		// Read response
		$firstLine = fgets($socket);
		if ($firstLine === false) {
			require_once 'PhpGearmanAdmin/Exception.php';
			throw new PhpGearmanAdmin_Exception(__METHOD__ . ' Reading of socket failed',
					PhpGearmanAdmin_Exception::READ_FAILED);
		}

		// Validate
		$firstLine = trim($firstLine);
		if (preg_match('/^ERR/', $firstLine)) {
			list(, $errcode, $errstr) = explode(' ', $firstLine);
			throw new PhpGearmanAdmin_Exception(__METHOD__ . ' ' . $errcode . ': ' . urldecode($errstr),
					PhpGearmanAdmin_Exception::SERVER_RETURNED_ERROR);
		}
		if ('.' == $firstLine) {
			return array();
		}

		// Read the rest and return
		$data[] = $firstLine;
		while ($line = trim(fgets($socket, 1024))) {
			if ($line == '.') {
				break;
			}
			$data[] = $line;
		}
		fclose($socket);
		return $data;
	}
}
