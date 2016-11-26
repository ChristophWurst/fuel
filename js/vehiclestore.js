/* global riot, RiotControl, OC */

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
						self.trigger('vehicle:load', vehicles[0]);
					}
				}
			});
		});

		self.on('vehicle:load', function(vehicle) {
			self.vehicles.forEach(function(vehicle) {
				vehicle.active = false;
			});
			vehicle.active = true;
			self.trigger('vehicles:changed', self.vehicles);
			RiotControl.trigger('records:load', vehicle);
		});
	}

	global.VehicleStore = VehicleStore;
})(window, $, riot, RiotControl, OC);