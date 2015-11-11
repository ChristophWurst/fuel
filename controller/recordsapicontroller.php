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
use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\ApiController;
use OCA\Fuel\Service\RecordService;

class RecordsApiController extends ApiController {

	private $service;
	private $userId;

	use Errors;

	public function __construct($appName, IRequest $request,
		RecordService $service, $UserId) {
		parent::__construct($appName, $request);
		$this->service = $service;
		$this->userId = $UserId;
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * 
	 * @param int vehicleId
	 * 
	 * @return DataResponse
	 */
	public function index($vehicleId) {
		return new DataResponse($this->service->findAll($vehicleId, $this->userId));
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * 
	 * @param int vehicleId
	 * @param int id
	 * 
	 * @return DataResponse
	 */
	public function show($vehicleId, $id) {
		return $this->handleNotFound(function() use ($vehicleId, $id) {
				return $this->service->find($id, $vehicleId, $this->userId);
			});
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * @ValidateRecord
	 * 
	 * @param int odo
	 * @param float fuel
	 * @param float price
	 * @param Date date
	 * @param int vehicleId
	 * 
	 * @return DataResponse
	 */
	public function create($odo, $fuel, $price, $date, $vehicleId) {
		return $this->service->create($odo, $fuel, $price, $date, $vehicleId,
				$this->userId);
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * @ValidateRecord
	 * 
	 * @param int id
	 * @param int odo
	 * @param float fuel
	 * @param float price
	 * @param Date date
	 * @param int vehicleId
	 * 
	 * @return DataResponse
	 */
	public function update($id, $odo, $fuel, $price, $date, $vehicleId) {
		return $this->handleNotFound(function() use ($id, $odo, $fuel,
				$price, $date, $vehicleId) {
				return $this->service->update($id, $odo, $fuel, $price, $date, $vehicleId,
						$this->userId);
			});
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 * 
	 * @param int id
	 * @param int vehicleId
	 * 
	 * @return DataResponse
	 */
	public function destroy($vehicleId, $id) {
		return $this->handleNotFound(function() use ($vehicleId, $id) {
				return $this->service->delete($id, $vehicleId, $this->userId);
			});
	}

}
