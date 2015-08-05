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

	var RecordsCollection = require('models/RecordCollection');

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
			var app = require('app');
			/**
			 * @todo do this before any request
			 */
			app.vehicles.forEach(function (vehicle) {
				vehicle.set('active', false);
			});

			var activeVehicle = app.vehicles.get(id);
			activeVehicle.set('active', true);

			// Show cached records until real data arrived from the
			// server if available
			var records = activeVehicle.get('records');
			if (records) {
				app.records.reset(records.toJSON());
			} else {
				// Empty records list
				app.records.reset();
				records = new RecordsCollection();
			}

			// Sync data
			records.url = app.baseUrl + 'vehicles/' + id + '/records';
			records.fetch({
				success: function (collection) {
					// Update vehicle model to have newest data
					activeVehicle.set('records', collection);
					// Update record list
					app.records.reset(collection.toJSON());
				},
				error: function () {
					OC.Notification.showTemporary(t('fuel', 'Could not load record data'));
				}
			});
		}
	};
});