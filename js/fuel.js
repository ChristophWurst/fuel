/* global OC, Marionette, Backbone, VehicleController, _, */

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
	baseUrl: OC.generateUrl('/apps/fuel/'),
	vehicles: new VehicleCollection([
		{
			id: 1,
			name: 'Vehicle 1'
		},
		{
			id: 2,
			name: 'Vehicle 2'
		}
	]),
	initialize: function () {
		console.log('application initialized');
	}
});

var FuelRouter = Marionette.AppRouter.extend({
	controller: VehicleController
});

window.app = new FuelApplication;

/**
 * Application regions
 */
app.addRegions({
	vehiclesRegion: '#vehicle-list',
	recordsRegion: '#record-list',
	statisticsRegion: '#statistics'
});

/**
 * Initialize vehicle UI
 */
app.addInitializer(function () {
	var vehiclesView = new VehiclesView({
		collection: app.vehicles
	});
	app.vehiclesRegion.show(vehiclesView);
});

app.on('start', function () {
	// Start history once our application is ready
	Backbone.history.start();

	var vehicleRoutes = {
		'': 'index',
		'vehicle/:id': 'vehicle'
	};

	// Prefix URLs
	var prefixedRoutes = {};
	for (var route in vehicleRoutes) {
		var method = vehicleRoutes[route];
		prefixedRoutes[app.baseUrl + route] = method;
	}

	app.router = new FuelRouter();
	app.router.processAppRoutes(VehicleController, vehicleRoutes);
});

$(document).ready(function () {
	app.start();
});