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
use OCA\Fuel\Db\Record;

class RecordMapper extends Mapper {

	public function __construct(IDb $db) {
		parent::__construct($db, 'fuel_records', Record::class);
	}

	/**
	 * 
	 * @param int $id
	 * @param int $vehicleId
	 * @param string $userId
	 * @return Record
	 */
	public function find($id, $vehicleId, $userId) {
		$sql = 'SELECT * FROM *PREFIX*fuel_records'
			. ' WHERE id = ?'
			. ' AND vehicle_id = ?'
			. ' AND user_id = ?';
		return $this->findEntity($sql, [
				$id,
				$vehicleId,
				$userId,
		]);
	}

	/**
	 * 
	 * @param int $vehicleId
	 * @param string $userId
	 * @return Record[]
	 */
	public function findAll($vehicleId, $userId) {
		$sql = 'SELECT * FROM *PREFIX*fuel_records'
			. ' WHERE vehicle_id = ?'
			. ' AND user_id = ?';
		return $this->findEntities($sql, [
				$vehicleId,
				$userId,
		]);
	}

}
