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
	'use strict';

	var Backbone = require('backbone'),
		Statistics = require('models/recordstatistics');

	return Backbone.Model.extend({
		defaults: {
			statistics: new Statistics()
		}
	});
});
