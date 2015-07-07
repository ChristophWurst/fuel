/* global Handlebars, Marionette */

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */

var VehicleView = Marionette.ItemView.extend({
	tagName: 'li',
	template: '#vehicle-list-item-template',
	initialize: function () {
		this.listenTo(this.model, 'change', this.render);
	}
});