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
use OCA\Fuel\Db\Vehicle;
use OCA\Fuel\Db\VehicleMapper;

class VehicleService {

	use ExceptionHandler;

	private $mapper;

	public function __construct(VehicleMapper $mapper) {
		$this->mapper = $mapper;
	}

	/**
	 * 
	 * @param int $id
	 * @param string $userId
	 * @return Vehicle
	 */
	public function find($id, $userId) {
		try {
			return $this->mapper->find($id, $userId);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	/**
	 * 
	 * @param string $userId
	 * @return Vehicle[]
	 */
	public function findAll($userId) {
		return $this->mapper->findAll($userId);
	}

	/**
	 * 
	 * @param string $name
	 * @param string $userId
	 * @return Vehicle
	 */
	public function create($name, $userId) {
		$vehicle = new Vehicle();
		$vehicle->setName($name);
		$vehicle->setUserId($userId);
		return $this->mapper->insert($vehicle);
	}

	/**
	 * 
	 * @param int $id
	 * @param string $name
	 * @param string $userId
	 * @return Vehicle
	 */
	public function update($id, $name, $userId) {
		try {
			$vehicle = $this->mapper->find($id, $userId);
			$vehicle->setName($name);
			return $this->mapper->update($vehicle);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	/**
	 * 
	 * @param int $id
	 * @param string $userId
	 */
	public function delete($id, $userId) {
		try {
			$vehicle = $this->mapper->find($id, $userId);
			$this->mapper->delete($vehicle);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

}
