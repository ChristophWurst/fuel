<?php

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */

namespace OCA\Fuel\Test\Unit\Controller;

use PHPUnit_Framework_TestCase;
use OCP\IRequest;
use OCP\IL10N;
use OC\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCA\Fuel\Controller\VehiclesController;
use OCA\Fuel\Service\Logger;
use OCA\Fuel\Service\NotFoundException;
use OCA\Fuel\Service\RecordService;
use OCA\Fuel\Service\VehicleService;

class VehiclesControllerTest extends PHPUnit_Framework_TestCase {

	protected $controller;
	protected $request;
	protected $vehicleService;
	protected $recordService;
	protected $userFolder;
	protected $userId = 'julia';
	protected $l10n;
	protected $logger;

	public function setUp() {
		$this->request = $this->getMockBuilder(IRequest::class)->getMock();
		$this->vehicleService = $this->getMockBuilder(VehicleService::class)
			->disableOriginalConstructor()
			->getMock();
		$this->recordService = $this->getMockBuilder(RecordService::class)
			->disableOriginalConstructor()
			->getMock();
		$this->userFolder = '/tmp';
		$this->l10n = $this->getMockBuilder(IL10N::class)
			->disableOriginalConstructor()
			->getMock();
		$this->logger = $this->getMockBuilder(Logger::class)
			->disableOriginalConstructor()
			->getMock();

		$this->controller = new VehiclesController('fuel', $this->request,
			$this->vehicleService, $this->recordService, $this->userFolder,
			$this->userId, $this->l10n, $this->logger);
	}

	public function testIndex() {
		$vehicles = 'vehicles';
		$this->vehicleService->expects($this->once())
			->method('findAll')
			->with($this->userId)
			->will($this->returnValue($vehicles));

		$expected = new DataResponse($vehicles);
		$actual = $this->controller->index();

		$this->assertEquals($expected, $actual);
	}

	public function testShow() {
		$id = 123;
		$vehicle = 'vehicle';

		$this->vehicleService->expects($this->once())
			->method('find')
			->with($id, $this->userId)
			->will($this->returnValue($vehicle));

		$expected = new DataResponse($vehicle);
		$actual = $this->controller->show($id);

		$this->assertEquals($expected, $actual);
	}

	public function testCreate() {
		$name = 'My Car';
		$vehicle = 'vehicle';

		$this->vehicleService->expects($this->once())
			->method('create')
			->with($name, $this->userId)
			->will($this->returnValue($vehicle));

		$actual = $this->controller->create($name);

		$this->assertEquals($vehicle, $actual);
	}

	public function testUpdate() {
		$vehicle = 'test vehicle';
		$this->vehicleService->expects($this->once())
			->method('update')
			->with($this->equalTo(3), $this->equalTo('name'))
			->will($this->returnValue($vehicle));

		$result = $this->controller->update(3, 'name');

		$this->assertEquals($vehicle, $result->getData());
	}

	public function testUpdateNotFound() {
		$this->vehicleService->expects($this->once())
			->method('update')
			->will($this->throwException(new NotFoundException()));

		$result = $this->controller->update(17, 'name');

		$this->assertEquals(Http::STATUS_NOT_FOUND, $result->getStatus());
	}

	public function testDestroy() {
		$id = 123;
		$vehicle = 'vehicle';

		$this->vehicleService->expects($this->once())
			->method('delete')
			->with($id, $this->userId)
			->will($this->returnValue($vehicle));

		$expected = new DataResponse($vehicle);
		$actual = $this->controller->destroy($id);

		$this->assertEquals($expected, $actual);
	}

}
