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
			id: null,
			date: null,
			odometer: 0.0,
			fuel: 0.0,
			cost: 0.0,
			full: true
		}
	});
});