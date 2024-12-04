<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  Looper exception class
 */

/**
 * This class represents an exception thrown by the looper
 */
class LooperException extends Exception
{
	private int $httpReturnCode = 0;
	private string $httpErrorMessage = '';

	/**
	 * The constructor of the looper exception
	 *
	 * @param  int $httpReturnCode http error code
	 * @param  string $httpErrorMessage http error message
	 * @param  string $message error message
	 * @param  int $code erro code
	 * @param  Exception $previous last exception throwed
	 * @return void
	 */
	public function __construct(int $httpReturnCode, string $httpErrorMessage, $message = '', $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->httpReturnCode = $httpReturnCode;
		$this->httpErrorMessage = $httpErrorMessage;
	}

	/**
	 * get http return code
	 *
	 * @return int http return code
	 */
	public function getReturnCode(): int
	{
		return $this->httpReturnCode;
	}

	/**
	 * get http error message
	 *
	 * @return string http error message
	 */
	public function getErrorMessage(): string
	{
		return $this->httpErrorMessage;
	}
}
