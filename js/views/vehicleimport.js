/* global OC */

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
            'click .import-local-btn': 'onImportLocalClick',
            'click .import-oc-btn': 'onImportOcClick',
            'change .local-import': 'onImportLocal'
        },
        onImportLocalClick: function (e) {
            e.stopPropagation();
            this.$('.local-import').click();
        },
        onImportOcClick: function (e) {
            e.stopPropagation();
            OC.dialogs.filepicker(t('fuel', 'Select Fuelio CSV file'), function(path) {
                require('app').trigger('vehicle:import:oc', path);
            });
        },
        onImportLocal: function (e) {
            var files = e.target.files;
            _.each(files, function(file) {
                require('app').trigger('vehicle:import:local', file);
            });
        }
    });
});
