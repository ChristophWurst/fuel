/* global Infinity */

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
	var Marionette = require('marionette'),
			Chart = require('chartjs');

	return Marionette.ItemView.extend({
		template: '#statistics-template',
		className: 'container',
		charts: {},
		modelEvents: {
			'change': 'onRender'
		},
		onRender: function () {
			// Destroy old charts
			for (var chart in this.charts) {
				this.charts[chart].destroy();
			}

			var consumptionContex = this.$('.consumption-chart').get(0).getContext("2d");
			var odoContex = this.$('.odo-chart').get(0).getContext("2d");
			var priceContex = this.$('.price-chart').get(0).getContext("2d");

			var records = this.model.get('records');
			if (records) {
				var labels = records.map(function (record) {
					return record.get('date');
				});
				var consumptionData = records.map(function (record) {
					var consumption = record.get('consumption');
					return consumption === Infinity ? null : consumption;
				});
				var odoData = records.map(function (record) {
					return record.get('odo');
				});
				var priceData = records.map(function (record) {
					var price = record.get('price') / record.get('fuel');
					return price.toFixed(2);
				});

				// Remove oldest point -> has no distance/consumption
				labels.splice(labels.length - 1);
				consumptionData.splice(consumptionData.length - 1);
				odoData.splice(odoData.length - 1);

				// Show only 20 newest data points
				labels.splice(21);
				consumptionData.splice(21);
				odoData.splice(21);

				// Reverse data -> ascending date
				labels.reverse();
				consumptionData.reverse();
				odoData.reverse();
				priceData.reverse();

				var chartOptions = {
					responsive: true,
					datasetFill: false,
					scaleIntegersOnly: false,
					scaleFontSize: 10,
					showTooltips: true,
					pointDot: false,
					datasetStroke: true,
					maintainAspectRatio: false
				};

				// Consumption chart
				this.charts.consumption = new Chart(consumptionContex).Line({
					labels: labels,
					datasets: [
						{
							data: consumptionData,
							strokeColor: "#1D2D44",
							datasetFill: false
						}
					]
				}, chartOptions);

				// Odo chart
				this.charts.odo = new Chart(odoContex).Line({
					labels: labels,
					datasets: [
						{
							data: odoData,
							strokeColor: "#1D2D44",
							datasetFill: false
						}
					]
				}, chartOptions);

				this.charts.price = new Chart(priceContex).Line({
					labels: labels,
					datasets: [
						{
							data: priceData,
							strokeColor: "#1D2D44",
							datasetFill: false
						}
					]
				}, chartOptions);
			}
		}
	});
});
