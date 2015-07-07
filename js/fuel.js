/* global OC, Marionette, Backbone */

/**
 * ownCloud - Fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */

var FuelApplication = Marionette.Application.extend({
	initialize: function () {
		console.log('application initialized');
	}
});

$(document).ready(function () {
	var app = new FuelApplication;

	/**
	 * Application regions
	 */
	app.addRegions({
		vehiclesRegion: '#vehicle-list'
	});

	app.addInitializer(function (options) {
		var vehiclesView = new VehiclesView({
			collection: options.vehicles
		});
		app.vehiclesRegion.show(vehiclesView);
	});

	app.on('start', function () {
		// Start history once our application is ready
		Backbone.history.start();
	});

	app.start({
		vehicles: new VehicleCollection([
			{
				name: 'Vehicle 1'
			},
			{
				name: 'Vehicle 2'
			}
		])
	});
});