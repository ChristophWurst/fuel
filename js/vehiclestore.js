/* global riot, OC */

(function(global, $, riot, RiotControl, OC) {
	'use strict';

	function VehicleStore() {
		riot.observable(this);

		var vehiclesURL = OC.generateUrl('/apps/fuel/vehicles');

		var self = this;

		self.vehicles = [];

		self.on('vehicles:init', function() {
			console.log('vehicles init');
			self.trigger('vehicles:changed', self.vehicles);
			$.ajax(vehiclesURL, {
				method: 'get',
				success: function(vehicles) {
					self.vehicles = vehicles;
					self.trigger('vehicles:changed', vehicles);
					if (vehicles.length) {
						RiotControl.trigger('records:load', vehicles[0]);
					}
				}
			});
		});
	}

	global.VehicleStore = VehicleStore;
})(window, $, riot, RiotControl, OC);