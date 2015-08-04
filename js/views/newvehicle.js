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
		Backbone = require('backbone');

	return Marionette.ItemView.extend({
		opened: false,
		template: '#new-vehicle-template',
		templateHelpers: function () {
			return {
				showButton: function () {
					return this.opened ? 'hidden' : '';
				},
				showDialog: function () {
					return this.opened ? '' : 'hidden';
				}
			};
		},
		events: {
			'click #new-vehicle-btn': 'open',
			'click document': 'onClick'
		},
		initialize: function () {
			console.log('init');

			var State = new Backbone.Model({
				opened: false
			});
			this.model = State;

			// Close dialog on ESC
			var _this = this;
			$('body').bind('keyup', function (e) {
				if (e.keyCode === 27 && _this.$('.new-vehicle-name').is(':focus')) {
					_this.close();
				}
			});
		},
		open: function () {
			this.model.set('opened', true);
			this.render();
			this.$('.new-vehicle-name').focus();
		},
		close: function () {
			this.model.set('opened', false);
			this.render();
		}
	});
});
