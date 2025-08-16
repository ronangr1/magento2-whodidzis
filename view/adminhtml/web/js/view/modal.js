/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
], function ($, modal, $t) {
    'use strict';

    return {
        response: null,
        modal: {
            title: 'Changes',
            content: null
        },

        init: function (content) {
            this.response = $('<pre class="language-json"><code class="language-json">' + content + '</code></pre>');
            this.modal.content = $('<div class="admin__scope-old">').html(this.response);
            this._open();
        },

        _open: function () {
            const self = this;
            self.modal.content.modal({
                title: self.modal.title,
                modalClass: 'ronangr1-whodidzis-modal',
                innerScroll: true,
                buttons: [{
                    text: $t('Close'),
                    class: 'action-primary',
                    click: function () {
                        this.closeModal();
                    }
                }]
            });

            self.modal.content.trigger('openModal');
        }
    }
})
