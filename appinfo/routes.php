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
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\Fuel\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
	'resources' => [
		'vehicles' => [
			'url' => '/vehicles',
		],
		'records' => [
			'url' => '/vehicles/{vehicleId}/records'
		],
		/**
		 * REST API v0.1
		 */
		'vehicles_api' => [
			'url' => '/api/0.1/vehicles'
		],
		'records_api' => [
			'url' => '/api/0.1/vehicles/{vehicleId}/records'
		],
	],
	'routes' => [
		[
			'name' => 'page#index',
			'url' => '/',
			'verb' => 'GET'
		],
		[
			'name' => 'vehicles#importLocal',
			'url' => '/vehicles/import-local',
			'verb' => 'POST'
		],
		[
			'name' => 'vehicles#importOc',
			'url' => '/vehicles/import-oc',
			'verb' => 'POST'
		],
	]
];
