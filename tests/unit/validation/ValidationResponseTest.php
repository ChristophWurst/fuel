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
use OCA\Fuel\Validation\Validator;
use OCA\Fuel\Validation\ValidationResponse;

class ValidationResponseTest extends PHPUnit_Framework_TestCase {

	private $validator;
	private $response;

	protected function setUp() {
		parent::setUp();

		// Create validtor with one error
		$this->validator = new Validator();
		$this->validator->validateRequired("var", null);

		$this->response = new ValidationResponse($this->validator);
	}

	public function testResponseData() {
		$data = $this->response->getData();

		$this->assertArrayHasKey("errors", $data);
		$this->assertCount(1, $data["errors"]);
	}

	public function testHasHttpStatus() {
		$this->assertSame(Http::STATUS_BAD_REQUEST, $this->response->getStatus());
	}

}
