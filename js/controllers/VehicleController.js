/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */

var VehicleController = (function () {
	this.index = function () {
		/**
		 * @todo do this before any request
		 */
		app.vehicles.forEach(function (vehicle) {
			vehicle.set('active', false);
		});
	};

	this.vehicle = function (id) {
		/**
		 * @todo do this before any request
		 */
		app.vehicles.forEach(function (vehicle) {
			vehicle.set('active', false);
		});
		app.vehicles.get(id).set('active', true);
	};

	return this;
}());