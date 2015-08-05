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
use OCA\Fuel\Service\Logger;
use OCA\Fuel\Service\RecordService;

class RecordsController extends Controller {

	use Errors;

	private $service;
	private $logger;
	private $userId;

	public function __construct($appName, IRequest $request, RecordService $service, Logger $logger, $userId) {
		parent::__construct($appName, $request);
		$this->service = $service;
		$this->logger = $logger;
		$this->userId = $userId;
	}

	/**
	 * 
	 * @NoAdminRequired
	 * 
	 * @param int $vehicleId
	 * @return DataResponse
	 */
	public function index($vehicleId) {
		$this->logger->debug("loading all records for vehicle <$vehicleId>");
		return new DataResponse($this->service->findAll($vehicleId, $this->userId));
	}

	/**
	 * 
	 * @NoAdminRequired
	 * 
	 * @param int $id
	 * @param int $vehicleId
	 * @return DataResponse
	 */
	public function show($id, $vehicleId) {
		$this->logger->debug("loading record <$id> for vehicle <$vehicleId>");
		return $this->handleNotFound(function() use ($id, $vehicleId) {
				return $this->service->find($id, $vehicleId, $this->userId);
			});
	}

	/**
	 * 
	 * @NoAdminRequired
	 * 
	 * @param int $odo
	 * @param float $fuel
	 * @param float $price
	 * @param string $date
	 * @param int $vehicleId
	 * @return DataResponse
	 */
	public function create($odo, $fuel, $price, $date, $vehicleId) {
		//TODO: check if user owns vehicle
		return $this->handleNotFound(function() use ($odo, $fuel, $price, $date, $vehicleId) {
				$this->service->create($odo, $fuel, $price, $date, $vehicleId, $this->userId);
			});
	}

	/**
	 * 
	 * @NoAdminRequired
	 * 
	 * @param int id
	 * @param int $odo
	 * @param float $fuel
	 * @param float $price
	 * @param string $date
	 * @param int $vehicleId
	 * @return DataResponse
	 */
	public function update($id, $odo, $fuel, $price, $date, $vehicleId) {
		//TODO: check if user owns vehicle
		return $this->handleNotFound(function() use ($id, $odo, $fuel, $price, $date, $vehicleId) {
				$this->service->update($id, $odo, $fuel, $price, $date, $vehicleId, $this->userId);
			});
	}

	/**
	 * 
	 * @NoAdminRequired
	 * 
	 * @param int $id
	 * @param int $vehicleId
	 * @return DataResponse
	 */
	public function destroy($id, $vehicleId) {
		return $this->handleNotFound(function() use ($id, $vehicleId) {
				return $this->service->delete($id, $vehicleId, $this->userId);
			});
	}

}
