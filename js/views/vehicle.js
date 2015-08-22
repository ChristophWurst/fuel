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

	var Marionette = require('marionette');

	return Marionette.ItemView.extend({
		state: null,
		tagName: 'li',
		menuOpened: false,
		editMode: false,
		className: function () {
			var classes = 'with-menu';
			if (this.model.get('active')) {
				classes += ' active';
			}
			return classes;
		},
		template: '#vehicle-list-item-template',
		templateHelpers: function () {
			var _this = this;
			return {
				menuOpened: function () {
					return _this.menuOpened ? 'open' : '';
				},
				isEditable: function () {
					return _this.editMode;
				}
			};
		},
		events: {
			'click': 'onClick',
			'click .app-navigation-entry-utils-menu-button': 'onMenu',
			'click .rename-vehicle': 'onRename',
			'click input': 'onInputClick',
			'submit .edit-form': 'onEditSubmit',
			'click .delete-vehicle': 'onDelete'
		},
		initialize: function () {
			this.listenTo(this.model, 'change', this.render);
			require('app').on('vehicle:show', this.toggleActive, this);
		},
		toggleActive: function (vehicleId) {
			if (this.model.get('id') === vehicleId) {
				this.$el.addClass('active');
			} else {
				this.$el.removeClass('active');
			}
		},
		toggleMenu: function (state) {
			this.menuOpened = state;
			this.render();
		},
		toggleEditMode: function (state) {
			this.editMode = state;
			this.render();

			// Close menu
			this.toggleMenu(false);
		},
		onMenu: function (e) {
			e.stopPropagation();
			this.toggleMenu(!this.menuOpened);
		},
		onClick: function (e) {
			e.preventDefault();
			e.stopPropagation();
			require('app').trigger('vehicle:show', this.model.get('id'));
		},
		onRename: function (e) {
			e.stopPropagation();

			this.toggleEditMode(true);
		},
		onInputClick: function (e) {
			e.stopPropagation();
		},
		onEditSubmit: function (e) {
			e.preventDefault();

			// Get form data
			var name = $('input.vehicle-name').val();
			var data = {
				name: name
			};
			
			// Close editmode
			this.toggleEditMode(false);

			// Update the model
			this.trigger('vehicle:edit', this.model, data);
		},
		onDelete: function (e) {
			e.stopPropagation();
			this.trigger('vehicle:delete', this.model);
		}
	});
});