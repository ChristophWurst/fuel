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

	var $ = require('jquery'),
			VehiclesView = require('views/vehiclelist'),
			LoadingView = require('views/loading');

	function listVehicles() {
		var defer = $.Deferred();
		var fetchingVehicles = require('app').request('vehicle:entities');

		// Show loading spinner
		var loadingView = new LoadingView();
		require('app').vehiclesRegion.show(loadingView);

		$.when(fetchingVehicles).done(function (vehicles) {
			var vehiclesView = new VehiclesView({
				collection: vehicles
			});

			vehiclesView.on('childview:records:list', function (childView, model) {
				require('app').trigger('records:list', model.get('id'));
			});

			vehiclesView.on('childview:vehicle:edit', function (childView, model, data) {
				model.set('name', data.name);
				model.save();
			});

			vehiclesView.on('childview:vehicle:delete', function (childView, model) {
				model.destroy();
			});

			require('app').vehiclesRegion.show(vehiclesView);
			defer.resolve(vehicles);
		});

		return defer.promise();
	}

	// ref: http://www.html5rocks.com/en/tutorials/file/dndfiles/
	function importVehicleLocal(file) {
		// Check file type for 'text/csv'
		if (file.type !== 'text/csv') {
			OC.Notification.showTemporary(t('fuel', 'Import file must be of type text/csv'));
			return;
		}

		var reader = new FileReader();
		reader.onload = function (e) {
			var content = e.target.result;

			var url = OC.generateUrl('/apps/fuel/vehicles/import-local');
			$.ajax(url, {
				method: 'post',
				data: {
					content: content
				},
				success: function (data) {
					OC.Notification.showTemporary('"' + data.name + '" ' + t('fuel', 'imported successfully'));
					var app = require('app');
					app.trigger('vehicles:list');
				},
				error: function (xhr) {
					var error = JSON.parse(xhr.responseText);
					OC.Notification.showTemporary(t('fuel', 'Import error') + ': ' + error);
				}
			});
		};

		reader.readAsText(file);
	}

	function importVehicleOc(path) {
		var url = OC.generateUrl('/apps/fuel/vehicles/import-oc');
		$.ajax(url, {
			method: 'post',
			data: {
				path: path
			},
			success: function (data) {
				OC.Notification.showTemporary('"' + data.name + '" ' + t('fuel', 'imported successfully'));
				var app = require('app');
				app.trigger('vehicles:list');
			},
			error: function (xhr) {
				var error = JSON.parse(xhr.responseText);
				OC.Notification.showTemporary(t('fuel', 'Import error') + ': ' + error);
			}
		});
	}

	return {
		listVehicles: listVehicles,
		importVehicleLocal: importVehicleLocal,
		importVehicleOc: importVehicleOc
	};
});