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
		tagName: 'li',
		template: '#record-list-item-template',
		templateHelpers: {
			addSign: function(value) {
				return value > 0 ? '+' + value : value;
			}
		},
        events: {
            'click': 'onClick'
        },
		initialize: function () {
			this.listenTo(this.model, 'change', this.render);
		},
        onClick: function(e) {
            e.stopPropagation();
            e.preventDefault();
            require('app').trigger('record:show', this.model.get('vehicleId'), this.model.get('id'));
        }
	});
});