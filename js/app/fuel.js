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

    /**
     * Libraries
     */
    var $ = require('jquery'),
            Backbone = require('backbone'),
            Marionette = require('marionette'),
            _ = require('underscore');

    /**
     * Views
     */
    var NewVehicleView = require('views/newvehicle'),
            StatisticsView = require('views/statistics');

    /**
     * Controller
     */
    var VehicleController = require('controllers/vehiclecontroller'),
            RecordController = require('controllers/recordcontroller');

    /**
     * Services
     */
    var VehicleService = require('service/vehicle'),
            RecordService = require('service/record');

    var ApplicationState = require('models/ApplicationState');

    var FuelApplication = Marionette.Application.extend({
        baseUrl: OC.generateUrl('/apps/fuel/'),
        state: null,
        VehicleController: VehicleController,
        RecordController: RecordController,
        initialize: function () {
            this.state = new ApplicationState();
        },
        navigate: function (route, options) {
            options = options || {};
            Backbone.history.navigate(route, options);
        },
        getCurrentRoute: function () {
            return Backbone.history.fragment;
        },
        addVehicle: function (options) {
            /**
             * TODO: use Backbone sync instead of manual request
             */
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

    var app = new FuelApplication();

    /**
     * Application regions
     */
    app.addRegions({
        vehiclesRegion: '#vehicle-list',
        newVehicleRegion: '#new-vehicle',
        recordsRegion: '#records',
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
        var statisticsView = new StatisticsView({
            model: app.state.get('statistics')
        });
        app.newVehicleRegion.show(newVehicleView);
        app.statisticsRegion.show(statisticsView);
    });

    /**
     * Set up request handler
     */
    app.reqres.setHandler('vehicle:entities', function () {
        return VehicleService.getVehicleEntities();
    });
    app.reqres.setHandler('record:entities', function (vehicleId) {
        return RecordService.getRecordEntities(vehicleId);
    });

    /**
     * Set up routing
     */
    app.Router = Marionette.AppRouter.extend({
        appRoutes: {
            'vehicles': 'listVehicles',
            'vehicles/:vehicleId/records': 'listRecords'
        }
    });

    var API = {
        listVehicles: function () {
            app.VehicleController.listVehicles();
        },
        listRecords: function (vehicleId) {
            app.RecordController.listRecords(vehicleId);
        }
    };

    app.on('vehicles:list', function () {
        app.navigate('vehicles');
        API.listVehicles();
    });

    app.on('records:list', function (vehicleId) {
        app.navigate('vehicles/' + vehicleId + '/records');
        API.listRecords(vehicleId);
    });

    app.on('start', function () {
        // Start history once our application is ready
        Backbone.history.start();

        if (this.getCurrentRoute() === '') {
            app.trigger('vehicles:list');
        }

        app.Router = new app.Router({
            controller: API
        });
    });

    // Hack to return app before it is started
    // -> resolves cyclic dependency issues
    setTimeout(function () {
        app.start();
    }, 0);

    return app;
});