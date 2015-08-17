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
			average: null
		},
		refresh: function (records) {
			console.info('avg: ' + this.getAverage(records));
		},
		getAverage: function (records) {
			var count = 0;
			var sum = 0;
			records.each(function (record) {
				console.log(record.distance);
				count++;
				sum += record.distance;
			});
			return sum / count;
		}
	});
});
