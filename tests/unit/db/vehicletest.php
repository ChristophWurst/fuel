<?php

namespace OCA\Fuel\Tests\Unit\Db;

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */
use PHPUnit_Framework_TestCase;
use JsonSerializable;
use OCA\Fuel\Db\Vehicle;

/**
 * Description of vehicletest
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 */
class VehicleTest extends PHPUnit_Framework_TestCase {

	private $vehicle;

	protected function setUp() {
		parent::setUp();

		$this->vehicle = new Vehicle();
	}

	public function testJsonSerializeable() {
		$id = 123;
		$name = 'My Car';

		$this->vehicle->setId($id);
		$this->vehicle->setName($name);

		$expected = [
			'id' => $id,
			'name' => $name,
		];
		$actual = json_decode(json_encode($this->vehicle), true);

		$this->assertEquals($expected, $actual);
	}

}
