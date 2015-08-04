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
	return {
		index: function () {
			/**
			 * @todo do this before any request
			 */
			require('app').vehicles.forEach(function (vehicle) {
				vehicle.set('active', false);
			});
		},
		vehicle: function (id) {
			/**
			 * @todo do this before any request
			 */
			require('app').vehicles.forEach(function (vehicle) {
				vehicle.set('active', false);
			});
			require('app').vehicles.get(id).set('active', true);
		}
	};
});