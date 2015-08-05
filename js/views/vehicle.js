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
		state: null,
		tagName: 'li',
		className: function() {
			var classes = 'with-menu';
			if (this.model.get('active')) {
				classes += ' active';
			}
			return classes;
		},
		template: '#vehicle-list-item-template',
		templateHelpers: function() {
			var _this = this;
			return {
				menuOpened: function() {
					return _this.menuOpened ? 'open' : '';
				}
			};
		},
		events: {
			'click .app-navigation-entry-utils-menu-button': 'toggleMenu',
			'click .delete-vehicle': 'onDelete'
		},
		initialize: function () {
			this.listenTo(this.model, 'change', this.render);
			
		},
		toggleMenu: function() {
			this.menuOpened = !this.menuOpened;
			this.render();
		},
		onDelete: function() {
			this.model.destroy();
		}
	});
});