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
            StatisticsView = require('views/statistics'),
            ImportVehicleView = require('views/vehicleimport');

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
                    //TODO: fix
                    console.log(vehicle);
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
        statisticsRegion: '#statistics',
        importVehicleRegion: '#import-vehicle'
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
        var importView = new ImportVehicleView();
        app.newVehicleRegion.show(newVehicleView);
        app.statisticsRegion.show(statisticsView);
        app.importVehicleRegion.show(importView);
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
            'vehicles/:vehicleId': 'showVehicle',
            'vehicles/:vehicleId/records': 'listRecords',
            'vehicles/:vehicleId/records/:recordId': 'showRecord'
        }
    });

    var API = {
        listVehicles: function () {
            return app.VehicleController.listVehicles();
        },
        showVehicle: function (vehicleId) {
            // Show record list instead
            app.trigger('records:list', vehicleId);
        },
        importVehicleLocal: function (file) {
            app.VehicleController.importVehicleLocal(file);
        },
        importVehicleOc: function (path) {
            app.VehicleController.importVehicleOc(path);
        },
        listRecords: function (vehicleId) {
            return app.RecordController.listRecords(vehicleId);
        },
        showRecord: function (vehicleId, recordId) {
            //TODO: implement show
            return this.listRecords(vehicleId);
        }
    };

    var RoutingController = {
        listVehicles: function () {
            API.listVehicles();
        },
        showVehicle: function (vehicleId) {
            vehicleId = Number(vehicleId);
            API.showVehicle(vehicleId);
        },
        listRecords: function (vehicleId) {
            vehicleId = Number(vehicleId);
            $.when(API.listVehicles()).done(function () {
                app.trigger('vehicle:show', vehicleId);
                API.listRecords(vehicleId);
            });
        },
        showRecord: function (vehicleId, recordId) {
            vehicleId = Number(vehicleId);
            recordId = Number(recordId);
            $.when(API.listVehicles()).done(function () {
                app.trigger('vehicle:show', vehicleId);
                $.when(API.listRecords(vehicleId)).done(function () {
                    //TODO: show avtive record
                });
            });
        }
    };

    app.on('vehicles:list', function () {
        app.navigate('vehicles');
        API.listVehicles();
    });

    app.on('vehicle:show', function (vehicleId) {
        app.navigate('vehicles/' + vehicleId);
        API.showVehicle(vehicleId);
    });

    app.on('vehicle:import:local', function (file) {
        API.importVehicleLocal(file);
    });

    app.on('vehicle:import:oc', function (path) {
        API.importVehicleOc(path);
    });

    app.on('records:list', function (vehicleId) {
        app.navigate('vehicles/' + vehicleId + '/records');
        API.listRecords(vehicleId);
    });

    app.on('record:show', function (vehicleId, recordId) {
        app.navigate('vehicles/' + vehicleId + '/records/' + recordId);
        // TODO:
    });

    app.on('start', function () {
        new app.Router({
            controller: RoutingController
        });

        // Start history once our application is ready
        Backbone.history.start();

        if (this.getCurrentRoute() === '') {
            app.trigger('vehicles:list');
        }
    });

    // Hack to return app before it is started
    // -> resolves cyclic dependency issues
    setTimeout(function () {
        app.start();
    }, 0);

    return app;
});
