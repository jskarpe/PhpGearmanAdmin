<?php
class PhpGearmanAdmin_Exception extends Exception
{
	const EMPTY_ARGUMENT = 100;
	const INVALID_ARGUMENT = 101;
	
	const CONNECT_FAILED = 200;
	const REQUEST_FAILED = 201;
	const READ_FAILED = 202;
	const SERVER_RETURNED_ERROR = 203;
}