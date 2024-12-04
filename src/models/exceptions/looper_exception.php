<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  Looper exception class
 */

/**
 * This class represents all exception thrown by our app
 */
class LooperException extends Exception
{
	private int $httpReturnCode = 0;
	private string $httpErrorMessage = '';

	/**
     * Constructor for LooperException
     *
     * Initializes a new instance of the `LooperException` class, extending the standard `Exception`
     * class to include HTTP-specific error information.
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
     * Get the HTTP return code.
     *
     * This method returns the HTTP status code that represents the type of error encountered.
     *
     * @return int The HTTP error return code.
	 */
	public function getReturnCode(): int
	{
		return $this->httpReturnCode;
	}

	/**
     * Get the HTTP error message.
     *
     * This method returns the HTTP error message, which can provide a more detailed explanation
     * of the error that occurred, suitable for logging or debugging.
     *
     * @return string The HTTP error message.
	 */
	public function getErrorMessage(): string
	{
		return $this->httpErrorMessage;
	}
}
