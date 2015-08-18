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
	var $ = require('jquery'),
		RecordCollection = require('models/RecordCollection');
	
	function getRecordEntities(vehicleId) {
		var records = new RecordCollection(null, {
			vehicleId: vehicleId
		});
		var defer = $.Deferred();
		records.fetch({
			success: function (data) {
				defer.resolve(data);
			}
		});
		return defer.promise();
	}

	return {
		getRecordEntities: getRecordEntities
	};
});
