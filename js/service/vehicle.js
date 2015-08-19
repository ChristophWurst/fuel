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
            vehicles = new VehicleCollection();

    function getVehicleEntities() {
        var defer = $.Deferred();

        vehicles.fetch({
            success: function (data) {
                defer.resolve(data);
            }
        });

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
