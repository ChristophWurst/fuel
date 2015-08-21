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
			records: null,
			averageConsumption: null,
			averagePrice: null
		},
		refresh: function (records) {
			this.set('records', records);
			this.set('averageConsumption', this.getAverageConsumption());
			this.set('averagePrice', this.getAveragePrice());
			this.trigger('refreshed');
		},
		getAverageConsumption: function () {
			var count = 0;
			var sum = 0;
			this.get('records').each(function (record) {
				var consumption = Number(record.get('consumption'));
				if (consumption !== Infinity) {
					count++;
					sum += consumption;
				}
			});
			var consumption = sum / count;
			return consumption.toFixed(2);
		},
		getAveragePrice: function () {
			var count = 0;
			var sum = 0;
			this.get('records').each(function (record) {
				var price = Number(record.get('price'));
				var fuel = Number(record.get('fuel'));
				count++;
				sum += price / fuel;
			});
			var avg = sum / count;
			return avg.toFixed(2);
		}
	});
});
