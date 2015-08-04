/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */

define(function () {
	var Marionette = require('marionette');

	return Marionette.ItemView.extend({
		template: '#record-list-item-template'
	});
});