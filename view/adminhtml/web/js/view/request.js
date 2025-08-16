/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
define(['jquery', 'mage/translate'], function ($, $t) {
    'use strict';

    return {
        content: null,

        do: function (path, logId) {
            const self = this;
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: path + '/id/' + logId + '/?isAjax=true',
                    type: 'GET',
                })
                .done(function (response) {
                    if (response.success) {
                        self.content = JSON.stringify(response.data, null, 2);
                        resolve(self.content);
                    } else {
                        reject(new Error($t('Invalid response.')));
                    }
                })
                .fail(function () {
                    reject(new Error($t('Unable to load diff.')));
                });
            });
        }
    }
})
