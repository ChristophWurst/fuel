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
use OCA\Fuel\Service\RecordService;

class VehiclesController extends Controller {

	use Errors;

	private $vehicleService;
	private $recordService;
	private $userId;

	public function __construct($appName, IRequest $request,
		VehicleService $vehcleService, RecordService $recordService, $UserId) {
		parent::__construct($appName, $request);
		$this->vehicleService = $vehcleService;
		$this->recordService = $recordService;
		$this->userId = $UserId;
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @return DataResponse
	 */
	public function index() {
		return new DataResponse($this->vehicleService->findAll($this->userId));
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @param int $id
	 * @return DataResponse
	 */
	public function show($id) {
		return $this->handleNotFound(function() use ($id) {
				return $this->vehicleService->find($id, $this->userId);
			});
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @param string $name
	 * @return DataResponse
	 */
	public function create($name) {
		return $this->vehicleService->create($name, $this->userId);
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
				return $this->vehicleService->update($id, $name, $this->userId);
			});
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @todo use transaction
	 * 
	 * @param string content
	 */
	public function importCsv($content) {
		$lines = explode(PHP_EOL, $content);

		$header = array_slice($lines, 0, 5);
		$recordRows = array_slice($lines, 5);

		// Get vehicle name
		$name = str_getcsv($header[2])[0];

		$vehicle = $this->vehicleService->create($name, $this->userId);

		foreach ($recordRows as $row) {
			if ($row === '') {
				// Skip empty lines
				continue;
			}
			
			$data = str_getcsv($row);
			$date = $data[0];
			$odo = $data[1];
			$fuel = $data[2];
			$price = $data[4];
			$this->recordService->create($odo, $fuel, $price, $date, $vehicle->getId(),
				$this->userId);
		}
		
		return new DataResponse([
			'name' => $name,
			'id' => $vehicle->getId(),
		]);
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @param int $id
	 * @return DataResponse
	 */
	public function destroy($id) {
		return $this->handleNotFound(function() use ($id) {
				return $this->vehicleService->delete($id, $this->userId);
			});
	}

}
