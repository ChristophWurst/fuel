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
		VehicleController = require('controllers/VehicleController'),
		VehicleCollection = require('models/VehicleCollection'),
		VehiclesView = require('views/vehicles');

	var FuelApplication = Marionette.Application.extend({
		baseUrl: OC.generateUrl('/apps/fuel/'),
		vehicles: new VehicleCollection(),/*[
			{
				id: 1,
				name: 'Vehicle 1'
			},
			{
				id: 2,
				name: 'Vehicle 2'
			}
		]),*/
		initialize: function () {
			console.log('application initialized');
		}
	});

	var FuelRouter = Marionette.AppRouter.extend({
		controller: VehicleController
	});

	var app = new FuelApplication;

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
		var view = new VehiclesView({
			collection: app.vehicles
		});
		app.vehiclesRegion.show(view);
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
		
		app.vehicles.url = app.baseUrl + '/vehicles';
		app.vehicles.fetch();

		app.router = new FuelRouter();
		app.router.processAppRoutes(VehicleController, vehicleRoutes);
	});

	$(document).ready(function () {
		app.start();
	});

	return app;
});