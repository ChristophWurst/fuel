<?php

namespace OCA\Fuel\Controller;

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;
use OCA\Fuel\Service\VehicleService;

class VehicleController extends Controller {

	use Errors;

	private $service;
	private $userId;

	public function __construct($appName, IRequest $request, VehicleService $service, $UserId) {
		parent::__construct($appName, $request);
		$this->service = $service;
		$this->userId = $UserId;
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @return DataResponse
	 */
	public function index() {
		return new DataResponse($this->service->findAll($this->userId));
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @param int $id
	 * @return DataResponse
	 */
	public function show($id) {
		return $this->handleNotFound(function() use ($id) {
				return $this->service->find($id, $this->userId);
			});
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @param string $name
	 * @return DataResponse
	 */
	public function create($name) {
		return $this->service->create($name, $this->userId);
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @param int $id
	 * @param string $name
	 * @return DataResponse
	 */
	public function update($id, $name) {
		return $this->handleNotFound(function() use ($id, $name) {
				return $this->service->update($id, $name, $this->userId);
			});
	}

	/**
	 * 
	 * @param int $id
	 * @return DataResponse
	 */
	public function destroy($id) {
		return $this->handleNotFound(function() use ($id) {
				return $this->service->delete($id, $this->userId);
			});
	}

}
