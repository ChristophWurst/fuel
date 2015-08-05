<?php

namespace OCA\Fuel\Service;

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
use OCA\Fuel\Db\Record;
use OCA\Fuel\Db\RecordMapper;

class RecordService {

	use ExceptionHandler;

	private $mapper;

	public function __construct(RecordMapper $mapper) {
		$this->mapper = $mapper;
	}

	/**
	 * 
	 * @param int $id
	 * @param int $vehicleId
	 * @param string $userId
	 * @return Record
	 */
	public function find($id, $vehicleId, $userId) {
		try {
			return $this->mapper->find($id, $vehicleId, $userId);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	/**
	 * 
	 * @param int $vehicleId
	 * @param string $userId
	 */
	public function findAll($vehicleId, $userId) {
		return $this->mapper->findAll($vehicleId, $userId);
	}

	/**
	 * 
	 * @param int $odo
	 * @param float $fuel
	 * @param float $price
	 * @param string $date
	 * @param int $vehicleId
	 * @param string $userId
	 * @return Record
	 */
	public function create($odo, $fuel, $price, $date, $vehicleId, $userId) {
		$record = new Record();
		$record->setOdo($odo);
		$record->setFuel($fuel);
		$record->setPrice($price);
		$record->setDate($date);
		$record->setVehicleId($vehicleId);
		$record->setUserId($userId);
		return $this->mapper->insert($record);
	}

	/**
	 * 
	 * @param int $id
	 * @param int $odo
	 * @param float $fuel
	 * @param float $price
	 * @param string $date
	 * @param int $vehicleId
	 * @param string $userId
	 * @return Record
	 */
	public function update($id, $odo, $fuel, $price, $date, $vehicleId, $userId) {
		try {
			$record = $this->mapper->find($id, $vehicleId, $userId);
			$record->setOdo($odo);
			$record->setFuel($fuel);
			$record->setPrice($price);
			$record->setDate($date);
			return $this->mapper->update($record);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	/**
	 * 
	 * @param int $id
	 * @param int $vehicleId
	 * @param string $userId
	 */
	public function delete($id, $vehicleId, $userId) {
		try {
			$record = $this->mapper->find($id, $vehicleId, $userId);
			$this->mapper->delete($record);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

}
