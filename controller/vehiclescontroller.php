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
use Exception;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http;
use OCP\Files\File;
use OCP\Files\Folder;
use OCP\Files\NotFoundException;
use OCP\IRequest;
use OCA\Fuel\Service\Logger;
use OCA\Fuel\Service\RecordService;
use OCA\Fuel\Service\VehicleService;

class VehiclesController extends Controller {

	use Errors;

	/**
	 *
	 * @var VehicleService
	 */
	private $vehicleService;

	/**
	 *
	 * @var RecordService
	 */
	private $recordService;

	/**
	 *
	 * @var string
	 */
	private $userId;

	/**
	 *
	 * @var Folder
	 */
	private $userFolder;

	/**
	 *
	 * @var \OC\L10N
	 */
	private $l10n;

	/**
	 *
	 * @var Logger
	 */
	private $logger;

	public function __construct($appName, IRequest $request,
		VehicleService $vehcleService, RecordService $recordService, $UserFolder,
		$UserId, $L10n, Logger $logger) {
		parent::__construct($appName, $request);
		$this->vehicleService = $vehcleService;
		$this->recordService = $recordService;
		$this->userFolder = $UserFolder;
		$this->userId = $UserId;
		$this->l10n = $L10n;
		$this->logger = $logger;
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
	 * Import Fuelio CSV backup file
	 * 
	 * @param string $content
	 * @return Vehicle
	 */
	private function importCsv($content) {
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
		return $vehicle;
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @todo use transaction
	 * 
	 * @param string content
	 * @return DataResponse
	 */
	public function importLocal($content) {
		$vehicle = $this->importCsv($content);

		return new DataResponse([
			'name' => $vehicle->getName(),
			'id' => $vehicle->getId(),
		]);
	}

	/**
	 * @NoAdminRequired
	 * 
	 * @param string $path
	 * @return DataResponse
	 */
	public function importOc($path) {
		try {
			$file = $this->userFolder->get($path);

			if (!($file instanceof File)) {
				throw new Exception($this->l10n->t('Could not open file'));
			}

			if ($file->getMimeType() !== 'text/csv') {
				throw new Exception($this->l10n->t('Import file must be of type text/csv'));
			}

			$vehicle = $this->importCsv($file->getContent());
			return new DataResponse([
				'name' => $vehicle->getName(),
				'id' => $vehicle->getId()
			]);
		} catch (NotFoundException $ex) {
			$this->logger->info("CSV OC Import: File <$path> does not exist");
			return new DataResponse($this->l10n->t('File does not exist'),
				Http::STATUS_BAD_REQUEST);
		} catch (Exception $ex) {
			$this->logger->info('Error while importing CSV file: ' + $ex->getMessage());
			return new DataResponse($this->l10n->t('Error while importing'),
				Http::STATUS_BAD_REQUEST);
		}
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
