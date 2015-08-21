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
			Record = require('models/Record'),
			RecordColumn = require('views/recordcolumn'),
			LoadingView = require('views/loading');

	function listRecords(vehicleId) {
		var fetchingRecords = require('app').request('record:entities', vehicleId);

		// Show loading spinner
		var loadingView = new LoadingView();
		require('app').recordsRegion.show(loadingView);

		$.when(fetchingRecords).done(function (records) {
			var recordsView = new RecordColumn({
				collection: records
			});

			// Update statistics
			require('app').state.get('statistics').refresh(records);

			recordsView.on('childview:record:show', function (childView, model) {
				require('app').trigger('record:show', vehicleId, model.get('id'));
			});

			require('app').recordsRegion.show(recordsView);

			var newRecordView = recordsView.newRecord.currentView;
			newRecordView.on('form:submit', function (data) {
				var record = new Record(data);
				records.create(record);
			});
		});
	}

	return {
		listRecords: listRecords
	};
});
