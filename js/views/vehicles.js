/* global Handlebars, Marionette, VehicleView */

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */

var VehiclesView = Marionette.CollectionView.extend({
	tagName: 'ul',
	childView: VehicleView,
	initialize: function (options) {
		options = options || {};
		this.collection = options.collection;
		this.listenTo(this.model, 'change', this.render);
	}
});