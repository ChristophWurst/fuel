/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */

define(function (require) {
	var $ = require('jquery'),
			VehicleCollection = require('models/VehicleCollection'),
			vehicles = new VehicleCollection(),
			fetched = false,
			fetching = false,
			queue = [
			];

	function getVehicleEntities() {
		var defer = $.Deferred();

		if (fetched) {
			// Vehicles have already been loaded -> resolve immediately
			defer.resolve(vehicles);
		} else {
			// Add request to waiting queue
			queue.push(defer);

			if (!fetching) {
				vehicles.fetch({
					success: function (data) {
						fetched = true;
						fetching = false;

						// Resolve all waiting promises
						_.each(queue, function (defer) {
							defer.resolve(data);
						});
						// Empty queue
						queue.length = 0;
					}
				});
				fetching = true;
			}
		}

		return defer.promise();
	}

	function getVehicleEntity(vehicleId) {
		var defer = $.Deferred();

		$.when(getVehicleEntities()).done(function (vehicles) {
			var vehicle = vehicles.get(vehicleId);
			defer.resolve(vehicle);
		});

		return defer.promise();
	}

	return {
		getVehicleEntities: getVehicleEntities,
		getVehicleEntity: getVehicleEntity
	};
});
