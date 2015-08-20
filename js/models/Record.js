/* global Infinity */

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

	var Backbone = require('backbone');

	return Backbone.Model.extend({
		defaults: {
			id: null,
			vehicleId: null,
			date: null,
			odo: 0.0,
			fuel: 0.0,
			distance: 0.0,
			consumption: Infinity,
			predecessor: null,
			active: false
		},
		initialize: function() {
			this.on('change:predecessor', function(record) {
				record.set('distance', this.getDistance());
			});
			this.on('change:distance', function(record) {
				record.set('consumption', this.getConsumption());
			});
		},
		getDistance: function () {
			var predecessor = this.get('predecessor');
			if (predecessor) {
				return this.get('odo') - predecessor.get('odo');
			}
			return Infinity;
		},
		getConsumption: function() {
			var consumption = this.get('fuel') / this.getDistance() * 100;
			return consumption.toFixed(2);
		}
	});
});