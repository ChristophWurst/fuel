<?php

namespace OCA\Fuel\AppInfo;

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */
use OCP\AppFramework\App;
use OCA\Fuel\Middleware\VehicleValidationMiddleware;
use OCA\Fuel\Middleware\RecordValidationMiddleware;
use OCA\Fuel\Validation\IValidator;
use OCA\Fuel\Validation\Validator;

class Application extends App {

	public function __construct($urlParams = []) {
		parent::__construct('fuel', $urlParams);

		$container = $this->getContainer();

		/**
		 * Inject 'UserFolder' parameter
		 */
		$userFolder = $container->query('ServerContainer')->getUserFolder();
		$container->registerParameter('UserFolder', $userFolder);

		/**
		 * Inject L10n
		 */
		$L10n = $container->getServer()->getL10N('fuel');
		$container->registerParameter('L10n', $L10n);

		/**
		 * Register which validator to inject
		 */
		$container->registerService(IValidator::class, function($c) {
			return $c->query(Validator::class);
		}, false);

		/**
		 * Middleware
		 */
		$container->registerAlias('VehicleValidationMiddleware',
			VehicleValidationMiddleware::class);
		$container->registerAlias("RecordValidatonMiddleware",
			RecordValidationMiddleware::class);

		$container->registerMiddleWare('VehicleValidationMiddleware');
		$container->registerMiddleWare("RecordValidatonMiddleware");
	}

}
