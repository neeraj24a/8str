<?php
use PayPal\Log\PayPalLogFactory;
use Psr\Log\LoggerInterface;

class MonologLogFactory implements PayPalLogFactory
{

	/**
	 * Returns logger instance implementing LoggerInterface.
	 *
	 * @param string $className
	 * @return LoggerInterface instance of logger object implementing LoggerInterface
	 */
	public function getLogger($className)
	{
		$logger = new Monolog\Logger($className);
		$logger->pushHandler(new Monolog\Handler\StreamHandler("mail.log"));

		return $logger;
	}
}