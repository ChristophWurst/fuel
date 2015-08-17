/* global OC */

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
	'use strinct';

	var Backbone = require('backbone'),
		Record = require('models/Record');

	return Backbone.Collection.extend({
		model: Record,
		comparator: function (r1, r2) {
			var d1 = new Date(r1.get('date'));
			var d2 = new Date(r2.get('date'));
			return d1 < d2;
		},
		vehicleId: null,
		url: null,
		initialize: function (data, options) {
			options = options || {};
			this.vehicleId = options.vehicleId;
			if (this.vehicleId) {
				this.url = OC.generateUrl('/apps/fuel/vehicles/{vehicleId}/records', {
					vehicleId: this.vehicleId
				});
			}
			this.on('add', this.change); //TODO: trigger only once per change
		},
		change: function () {
			// Set predecessors
			var prev = null;
			this.forEach(function (record) {
				if (prev) {
					prev.set('predecessor', record);
				}
				prev = record;
			});
		}
	});
});