<?php

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */

namespace OCA\Fuel\Service;

use Exception;
use OCP\ILogger;

class Logger {

	private $logger;
	private $context;

	public function __construct(ILogger $logger, $appName) {
		$this->logger = $logger;
		$this->context = [
			'app' => $appName,
		];
	}

	public function alert($message, array $context = []) {
		$c = array_merge($this->context, $context);
		$this->logger->alert($message, $c);
	}

	public function critical($message, array $context = []) {
		$c = array_merge($this->context, $context);
		$this->logger->critical($message, $c);
	}

	public function debug($message, array $context = []) {
		$c = array_merge($this->context, $context);
		$this->logger->debug($message, $c);
	}

	public function emergency($message, array $context = []) {
		$c = array_merge($this->context, $context);
		$this->logger->emergency($message, $c);
	}

	public function error($message, array $context = []) {
		$c = array_merge($this->context, $context);
		$this->logger->error($message, $c);
	}

	public function info($message, array $context = []) {
		$c = array_merge($this->context, $context);
		$this->logger->info($message, $c);
	}

	public function log($level, $message, array $context = []) {
		$c = array_merge($this->context, $context);
		$this->logger->log($message, $c);
	}

	public function notice($message, array $context = []) {
		$c = array_merge($this->context, $context);
		$this->logger->notice($message, $c);
	}

	public function warning($message, array $context = []) {
		$c = array_merge($this->context, $context);
		$this->logger->warning($message, $c);
	}

	public function logException(Exception $exception, array $context = []) {
		$c = array_merge($this->context, $context);
		$this->logger->logException($exception, $c);
	}

}
