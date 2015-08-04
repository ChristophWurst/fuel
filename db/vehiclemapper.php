<?php

namespace OCA\Fuel\Db;

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */
use OCP\IDb;
use OCP\AppFramework\Db\Mapper;
use OCA\Fuel\Db\Vehicle;

class VehicleMapper extends Mapper {

	public function __construct(IDb $db) {
		parent::__construct($db, 'fuel_vehicles', Vehicle::class);
	}

	public function find($id, $userId) {
		$sql = 'SELECT * FROM *PREFIX*fuel_vehicles'
			. ' WHERE id = ?'
			. ' AND user_id = ?';
		return $this->findEntity($sql, [
				$id,
				$userId,
		]);
	}

	public function findAll($userId) {
		$sql = 'SELECT * FROM *PREFIX*fuel_vehicles'
			. ' WHERE user_id = ?';
		return $this->findEntities($sql, [
				$userId,
		]);
	}

}
