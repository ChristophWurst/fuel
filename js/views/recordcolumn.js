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

	var Marionette = require('marionette'),
			NewRecordView = require('views/newrecord'),
			RecordListView = require('views/recordlist');
	return Marionette.LayoutView.extend({
		template: '#record-list-template',
		id: 'record-column',
		vehicleId: null,
		regions: {
			newRecord: '#new-record',
			recordList: '#record-list'
		},
		initialize: function (options) {
			this.collection = options.collection;
			this.vehicleId = options.vehicleId;
		},
		onShow: function () {
			var newRecordView = new NewRecordView({
				vehicleId: this.vehicleId
			});
			this.newRecord.show(newRecordView);
			var recordList = new RecordListView({
				collection: this.collection
			});
			this.recordList.show(recordList);
		}
	});
});
