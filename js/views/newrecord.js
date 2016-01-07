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
		Record = require('models/Record');

	return Marionette.ItemView.extend({
		vehicleId: null,
		template: '#new-record-template',
		events: {
			'submit form': 'submit'
		},
		initialize: function (options) {
			this.vehicleId = options.vehicleId;
		},
		submit: function (e) {
			e.preventDefault();
			var data = {
				odo: this.$('input[name=odo]').val(),
				date: this.$('input[name=date]').val(),
				fuel: this.$('input[name=fuel]').val(),
				price: this.$('input[name=price]').val(),
				vehicleId: this.vehicleId
			};
            this.trigger('form:submit', data);
		}
	});
});
