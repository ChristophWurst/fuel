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

	var $ = require('jquery'),
		RecordsView = require('views/records');

	function listRecords(vehicleId) {
		var fetchingRecords = require('app').request('record:entities', vehicleId);

		$.when(fetchingRecords).done(function (records) {
			var recordsView = new RecordsView({
				collection: records
			});

			recordsView.on('childview:record:show', function (childView, model) {
				require('app').trigger('record:show', vehicleId, model.get('id'));
			});

			require('app').recordsRegion.show(recordsView);
			// Update statistics
			require('app').state.get('statistics').refresh(records);
		});
	}

	return {
		listRecords: listRecords
	};
});
