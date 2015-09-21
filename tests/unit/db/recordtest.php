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
use DateTime;
use OCA\Fuel\Db\Record;

/**
 * Description of recordtest
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 */
class RecordTest extends PHPUnit_Framework_TestCase {

	private $record;

	protected function setUp() {
		parent::setUp();

		$this->record = new Record();
	}

	public function testJsonSerializable() {
		$id = 123;
		$odo = 2394;
		$date = '2015-05-05';
		$fuel = 10.3;
		$price = 12.3;
		$vehicleId = 13;
		$userId = 'john';

		$this->record->setId($id);
		$this->record->setOdo($odo);
		$this->record->setDate($date);
		$this->record->setFuel($fuel);
		$this->record->setPrice($price);
		$this->record->setVehicleId($vehicleId);
		$this->record->setUserId($userId);

		$expected = [
			'id' => $id,
			'odo' => $odo,
			'price' => $price,
			'date' => $date,
			'fuel' => $fuel,
			'vehicleId' => $vehicleId,
		];
		$actual = json_decode(json_encode($this->record), true);

		$this->assertEquals($expected, $actual);
	}

}
