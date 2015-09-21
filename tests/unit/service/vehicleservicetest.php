<?php

namespace OCA\Fuel\Tests\Unit\Service;

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
use OCA\Fuel\Db\Vehicle;
use OCA\Fuel\Db\VehicleMapper;
use OCA\Fuel\Service\VehicleService;

class VehicleServiceTest extends PHPUnit_Framework_TestCase {

	protected $service;
	protected $mapper;
	protected $userId;

	protected function setUp() {
		$this->mapper = $this->getMockBuilder(VehicleMapper::class)
			->disableOriginalConstructor()
			->getMock();
		$this->service = new VehicleService($this->mapper);
		$this->userId = 'john';
	}

	public function testUpdate() {
		$vehicle = Vehicle::fromRow([
				'id' => 123,
				'name' => 'My Car',
		]);
		$this->mapper->expects($this->once())
			->method('find')
			->with($this->equalTo(123))
			->will($this->returnValue($vehicle));

		$updatedVehicle = Vehicle::fromRow([
				'id' => 123,
		]);
		$updatedVehicle->setName('My Truck');
		$this->mapper->expects($this->once())
			->method('update')
			->with($this->equalTo($updatedVehicle))
			->will($this->returnValue($updatedVehicle));

		$result = $this->service->update(123, 'My Truck', $this->userId);

		$this->assertEquals($updatedVehicle, $result);
	}

}
