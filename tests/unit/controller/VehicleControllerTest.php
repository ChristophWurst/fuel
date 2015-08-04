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
use PHPUnit_Framework_TestCase;
use OC\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCA\Fuel\Controller\VehicleController;

class VehicleControllerTest extends PHPUnit_Framework_TestCase {

	protected $controller;
	protected $service;
	protected $userId = 'julia';
	protected $request;

	public function setUp() {
		$this->request = $this->getMockBuilder(OCP\IRequest::class)->getMock();
		$this->service = $this->getMockBuilder(OCA\Fuel\Service\VehicleService::class)
			->disableOriginalContstructor()
			->getMock();
		$this->controller = new VehicleController('fuel', $this->request, $this->service, $this->userId);
	}
	
	public function testUpdate() {
		$vehicle = 'test vehicle';
		$this->service->expects($this->once())
			->method('update')
			->with($this->equalTo(3),
				$this->equalTo('name'))
			->will($this->returnValue($vehicle));
		
		$result = $this->controller->update(3, 'name');
		
		$this->assertEquals($vehicle, $result->getData());
	}

}
