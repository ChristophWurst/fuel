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
	'use strict';

	var Backbone = require('backbone'),
		VehicleCollection = require('models/VehicleCollection'),
		RecordCollection = require('models/RecordCollection');

	return Backbone.Model.extend({
		defaults: {
			vehicles: new VehicleCollection(),
			records: new RecordCollection()
		}
	});
});
