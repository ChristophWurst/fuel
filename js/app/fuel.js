/* global OC */

/**
 * ownCloud - Fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */

define(function (require) {

	var $ = require('jquery'),
		Backbone = require('backbone'),
		Marionette = require('marionette'),
		_ = require('underscore'),
		VehicleController = require('controllers/VehicleController'),
		VehicleCollection = require('models/VehicleCollection'),
		VehiclesView = require('views/vehicles'),
		NewVehicleView = require('views/newvehicle');

	var FuelApplication = Marionette.Application.extend({
		baseUrl: OC.generateUrl('/apps/fuel/'),
		vehicles: new VehicleCollection(),
		initialize: function () {
			console.log('application initialized');
		},
		addVehicle: function(options) {
			var defaults = {
				success: function() {},
				error: function() {},
				complete: function() {},
				name: ''
			};
			options = _.defaults(options, defaults);

			var url = OC.generateUrl('/apps/fuel/vehicles');
			$.ajax(url, {
				method: 'POST',
				data: {
					name: options.name
				},
				success: function(vehicle) {
					app.vehicles.add(vehicle);
					options.success(vehicle);
				},
				error: options.error,
				complete: options.complete
			});
		}
	});

	var FuelRouter = Marionette.AppRouter.extend({
		controller: VehicleController
	});

	var app = new FuelApplication();

	/**
	 * Application regions
	 */
	app.addRegions({
		vehiclesRegion: '#vehicle-list',
		newVehicleRegion: '#new-vehicle',
		recordsRegion: '#record-list',
		statisticsRegion: '#statistics'
	});

	/**
	 * Initialize vehicle UI
	 */
	app.addInitializer(function () {
		var vehicleView = new VehiclesView({
			collection: app.vehicles
		});
		var newVehicleView = new NewVehicleView({
			app: app
		});
		app.vehiclesRegion.show(vehicleView);
		app.newVehicleRegion.show(newVehicleView);
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

		app.vehicles.url = app.baseUrl + 'vehicles';
		app.vehicles.fetch();

		app.router = new FuelRouter();
		app.router.processAppRoutes(VehicleController, vehicleRoutes);
	});

	$(document).ready(function () {
		app.start();
	});

	return app;
});