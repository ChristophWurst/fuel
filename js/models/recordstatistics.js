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
	var Backbone = require('backbone');

	return Backbone.Model.extend({
		defaults: {
			app: null,
			averageConsumption: null,
			averagePrice: null
		},
		refresh: function (records) {
			this.set('averageConsumption', this.getAverageConsumption(records));
			this.set('averagePrice', this.getAveragePrice(records));
		},
		getAverageConsumption: function (records) {
			var count = 0;
			var sum = 0;
			records.each(function (record) {
				var consumption = Number(record.get('consumption'));
				if (consumption !== Infinity) {
					count++;
					sum += consumption;
				}
			});
			return sum / count;
		},
		getAveragePrice: function (records) {
			var count = 0;
			var sum = 0;
			records.each(function (record) {
				var price = Number(record.get('price'));
				count++;
				sum += price;
			});
			return sum / count;
		}
	});
});
