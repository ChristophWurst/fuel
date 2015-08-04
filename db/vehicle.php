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

use JsonSerializable;
use OCP\AppFramework\Db\Entity;

class Vehicle extends Entity implements JsonSerializable {
	
	protected $name;
	protected $userId;
	
	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'name' => $this->name,
		];
	}

}
