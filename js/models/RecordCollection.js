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
	'use strict';

	var Backbone = require('backbone'),
			Record = require('models/Record');

	return Backbone.Collection.extend({
		model: Record,
		comparator: function (r1, r2) {
			return parseInt(r1.get('odo')) < parseInt(r2.get('odo'));
		},
		vehicleId: null,
		url: null,
		fetched: false,
		initialize: function (data, options) {
			options = options || {};
			this.vehicleId = options.vehicleId;
			this.url = OC.generateUrl('/apps/fuel/vehicles/{vehicleId}/records', {
				vehicleId: this.vehicleId
			});

			this.on('add', this.change); //TODO: trigger only once per change

			// Save fetched state to easily determine if the collection has to be fetched or not
			this.on('sync', function () {
				this.fetched = true;
			});
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