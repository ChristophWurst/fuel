/* global OC */

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
	'use strinct';

	var $ = require('jquery'),
		VehiclesView = require('views/vehicles');

	function listVehicles() {
		var fetchingVehicles = require('app').request('vehicle:entities');

		$.when(fetchingVehicles).done(function (vehicles) {
			var vehiclesView = new VehiclesView({
				collection: vehicles
			});

			vehiclesView.on('childview:records:list', function (childView, model) {
				require('app').trigger('records:list', model.get('id'));
			});

			vehiclesView.on('childview:vehicle:delete', function (childView, model) {
				model.destroy();
			});

			require('app').vehiclesRegion.show(vehiclesView);
		});
	}

	return {
		listVehicles: listVehicles
	};
});