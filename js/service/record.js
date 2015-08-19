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
            VehicleService = require('service/vehicle');

    function getRecordEntities(vehicleId) {
        var fetchingVehicle = VehicleService.getVehicleEntity(vehicleId);
        var defer = $.Deferred();

        $.when(fetchingVehicle).done(function (vehicle) {
            var records = vehicle.get('records');
            records.fetch({
                success: function (data) {
                    defer.resolve(data);
                }
            });
        });

        return defer.promise();
    }

    return {
        getRecordEntities: getRecordEntities
    };
});
