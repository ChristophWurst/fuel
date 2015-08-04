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
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
use OCA\Fuel\Db\Vehicle;
use OCA\Fuel\Db\VehicleMapper;

class VehicleService {

	private $mapper;

	public function __construct(VehicleMapper $mapper) {
		$this->mapper = $mapper;
	}

	public function findAll($userId) {
		return $this->mapper->findAll($userId);
	}

	public function handleException($e) {
		if ($e instanceof DoesNotExistException || $e instanceof MultipleObjectsReturnedException) {
			throw new DoesNotExistException($e->getMessage());
		} else {
			throw $e;
		}
	}

	public function find($id, $userId) {
		try {
			return $this->mapper->find($id, $userId);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function create($name, $userId) {
		$vehicle = new Vehicle();
		$vehicle->setName($name);
		$vehicle->setUserId($userId);
		return $this->mapper->insert($vehicle);
	}

	public function update($id, $name, $userId) {
		try {
			$vehicle = $this->mapper->find($id, $userId);
			$vehicle->setName($name);
			return $this->mapper->update($vehicle);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$vehicle = $this->mapper->find($id, $userId);
			$this->mapper->delete($vehicle);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

}
