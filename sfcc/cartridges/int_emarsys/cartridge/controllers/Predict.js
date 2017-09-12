'use strict';

/**
 * @module controllers/Predict
 */

/* Script Modules */
var app   = require('~/cartridge/scripts/app');
var guard = require('~/cartridge/scripts/guard');

function getCartInfo() {
    app.getView({
        Basket: dw.order.BasketMgr.getCurrentBasket()
    }).render('components/predict/cartinfo');
}

exports.GetCartInfo = guard.ensure(['get'], getCartInfo);
