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

    var Marionette = require('marionette'),
            _ = require('underscore');

    return Marionette.ItemView.extend({
        template: '#vehicle-import-template',
        className: 'vehicle-import',
        events: {
            'click .csv-import-btn': 'onImportCsvClick',
            'change .csv-import': 'onImportCsv'
        },
        onImportCsvClick: function (e) {
            e.stopPropagation();
            this.$('.csv-import').click();
        },
        onImportCsv: function (e) {
            var files = e.target.files;
            _.each(files, function(file) {
                require('app').trigger('vehicle:import', file);
            });
        }
    });
});
