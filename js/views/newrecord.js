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
		app: null,
		template: '#new-record-template',
		events: {
			'submit form': 'submit'
		},
		initialize: function (options) {
			this.app = options.app;
		},
		submit: function (e) {
			e.preventDefault();
			var record = new Record({
				odo: this.$('input[name=odo]').val(),
				date: this.$('input[name=date]').val(),
				fuel: this.$('input[name=fuel]').val(),
				price: this.$('input[name=price]').val()
			});
			this.app.state.get('records').create(record);
		}
	});
});
