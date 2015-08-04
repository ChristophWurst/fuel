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
	var Backbone = require('backbone'),
		Vehicle = require('models/Vehicle');

	var VehicleCollection = Backbone.Collection.extend({
		model: Vehicle
	});

	return VehicleCollection;
});