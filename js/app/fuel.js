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
	'use strict';

	var $ = require('jquery'),
		Backbone = require('backbone'),
		Marionette = require('marionette'),
		_ = require('underscore'),
		ApplicationState = require('models/ApplicationState'),
		VehicleController = require('controllers/VehicleController'),
		VehiclesView = require('views/vehicles'),
		RecordsView = require('views/records'),
		NewVehicleView = require('views/newvehicle'),
		NewRecordView = require('views/newrecord');

	var FuelApplication = Marionette.Application.extend({
		baseUrl: OC.generateUrl('/apps/fuel/'),
		state: null,
		initialize: function () {
			this.state = new ApplicationState();
			console.log('application initialized');
		},
		addVehicle: function (options) {
			var defaults = {
				success: function () {

				},
				error: function () {

				},
				complete: function () {

				},
				name: ''
			};
			options = _.defaults(options, defaults);

			var url = OC.generateUrl('/apps/fuel/vehicles');
			$.ajax(url, {
				method: 'POST',
				data: {
					name: options.name
				},
				success: function (vehicle) {
					app.state.get('vehicles').add(vehicle);
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
		newRecordRegion: '#new-record',
		statisticsRegion: '#statistics'
	});

	/**
	 * Initialize vehicle UI
	 */
	app.addInitializer(function () {
		var newVehicleView = new NewVehicleView({
			app: app
		});
		var vehicleView = new VehiclesView({
			collection: app.state.get('vehicles')
		});
		var newRecordView = new NewRecordView({
			app: app
		});
		var recordsView = new RecordsView({
			collection: app.state.get('records')
		});
		app.newVehicleRegion.show(newVehicleView);
		app.vehiclesRegion.show(vehicleView);
		app.newRecordRegion.show(newRecordView);
		app.recordsRegion.show(recordsView);
	});

	app.listenTo(app.state, 'change:records', function(state, records) {
		// Update statistics
		state.get('statistics').refresh(records);

		// Update records list view
		app.recordsRegion.reset();
		var recordsView = new RecordsView({
			collection: records
		});
		app.recordsRegion.show(recordsView);
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

		app.state.get('vehicles').fetch();

		app.router = new FuelRouter();
		app.router.processAppRoutes(VehicleController, vehicleRoutes);
	});

	$(document).ready(function () {
		app.start();
	});

	return app;
});