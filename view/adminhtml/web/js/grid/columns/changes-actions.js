/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'Magento_Ui/js/grid/columns/actions',
    'jquery',
    'Ronangr1_WhoDidZis/js/view/modal',
    'Ronangr1_WhoDidZis/js/view/request',
    'mage/url',
    'prismjs',
], function (Actions, $, modal, request, urlBuilder) {
    'use strict';

    return Actions.extend({
        defaults: {
            diffUrl: '${ $.config.diffUrl }',
        },

        initialize: function () {
            this._super();
            urlBuilder.setBaseUrl(window.adminUrl);
            this.diffUrl = urlBuilder.build(this.diffUrl);
            return this;
        },

        openChanges: function (logId) {
            const data = request.do(this.diffUrl, logId);
            data.then((content) => {
                modal.init(content);
            })
            .catch((error) => {
                console.error(error.message);
            });
            return false;
        }
    });
});
