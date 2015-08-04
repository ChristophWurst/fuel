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
	var VehicleView = require('views/vehicle'),
		Marionette = require('marionette');

	return Marionette.CollectionView.extend({
		tagName: 'ul',
		childView: VehicleView,
		initialize: function (options) {
			options = options || {};
			this.listenTo(this.collection, 'change', this.render);
		}
	});
});
