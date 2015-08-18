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
		VehicleCollection = require('models/VehicleCollection');

	function getVehicleEntities() {
		var vehicles = new VehicleCollection();
		var defer = $.Deferred();
		vehicles.fetch({
			success: function (data) {
				defer.resolve(data);
			}
		});
		return defer.promise();
	}

	return {
		getVehicleEntities: getVehicleEntities
	};
});
