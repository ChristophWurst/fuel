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

	var RecordView = require('views/record'),
		Marionette = require('marionette');

	return Marionette.CollectionView.extend({
		tagName: 'ul',
		childView: RecordView,
		initialize: function () {
			this.listenTo(this.collection, 'change', this.render);
		}
	});
});
