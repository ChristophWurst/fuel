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
		vehicleId: null,
		url: null,
		events: {
			'change': 'change'
		},
		initialize: function (data, options) {
			options = options || {};
			this.vehicleId = options.vehicleId;
			if (this.vehicleId) {
				this.url = OC.generateUrl('/apps/fuel/vehicles/{vehicleId}/records', {
					vehicleId: this.vehicleId
				});
			}
		},
		change: function () {
			if (this.vehicleId) {
				this.url = OC.generateUrl('/apps/fuel/vehicles/{vehicleId}/records', {
					vehicleId: this.vehicleId
				});
			}
		}
	});
});