/* global OC, riot, riot */

(function(global, $, riot, OC) {
	'use strict';

	function RecordStore() {
		riot.observable(this);

		var self = this;

		self.on('records:load', function(vehicle) {
			var url = OC.generateUrl('/apps/fuel/vehicles/{vehicleId}/records', {
				vehicleId: vehicle.id
			});

			if (vehicle.records) {
				self.trigger('records:changed', vehicle.records);
				return;
			}

			$.ajax(url, {
				method: 'get',
				success: function(records) {
					vehicle.records = records;
					self.trigger('records:changed', records);
				}
			});
		});
	}

	global.RecordStore = RecordStore;
})(window, $, riot, OC);