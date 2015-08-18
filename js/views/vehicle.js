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
			'click': 'onClick',
			'click .app-navigation-entry-utils-menu-button': 'toggleMenu',
			'click .delete-vehicle': 'onDelete'
		},
		initialize: function () {
			this.listenTo(this.model, 'change', this.render);
			
		},
		toggleMenu: function(e) {
			e.stopPropagation();
			this.menuOpened = !this.menuOpened;
			this.render();
		},
		onClick: function(e) {
			e.preventDefault();
			e.stopPropagation();
			this.trigger('records:list', this.model);
		},
		onDelete: function(e) {
			e.stopPropagation();
			this.trigger('vehicle:delete', this.model);
		}
	});
});