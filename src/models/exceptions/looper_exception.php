<?php

class LooperException extends Exception
{
	private int $httpReturnCode = 0;
	private string $httpErrorMessage = '';

	public function __construct(int $httpReturnCode, string $httpErrorMessage, $message = '', $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->httpReturnCode = $httpReturnCode;
		$this->httpErrorMessage = $httpErrorMessage;
	}

	public function getReturnCode(): int
	{
		return $this->httpReturnCode;
	}

	public function getErrorMessage(): string
	{
		return $this->httpErrorMessage;
	}
}
