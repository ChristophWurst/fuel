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

	var Marionette = require('marionette'),
		Backbone = require('backbone');

	return Marionette.ItemView.extend({
		app: null,
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
			'click .new-vehicle-add': 'add'
		},
		initialize: function (options) {
			this.app = options.app;

			var State = new Backbone.Model({
				opened: false,
				loading: false
			});
			this.model = State;

			// Close dialog on ESC
			var _this = this;
			$('body').bind('keyup', function (e) {
				var inputFocused = _this.$('.new-vehicle-name').is(':focus');
				if (e.keyCode === 27 && inputFocused) {
					_this.close();
				}
			});
			
			this.model.on('change:loading', this.loading, this);
		},
		open: function (e) {
			e.stopPropagation();
			this.model.set('opened', true);
			this.render();
			this.$('.new-vehicle-name').focus();
		},
		close: function () {
			this.model.set('opened', false);
			this.render();
		},
		loading: function(state, loading) {
			if (loading) {
				this.$('.new-vehicle-name').prop('disabled', true);
				this.$('.new-vehicle-add').prop('disabled', true);
			} else {
				this.$('.new-vehicle-name').prop('disabled', false);
				this.$('.new-vehicle-add').prop('disabled', false);
			}
		},
		add: function () {
			this.model.set('loading', true);
			var name = this.$('.new-vehicle-name').val();
			var _this = this;
			this.app.addVehicle({
				name: name,
				success: function () {
					_this.close();
				},
				error: function () {
					//TODO: show error message
				},
				complete: function () {
					_this.model.set('loading', false);
				}
			});
		}
	});
});
