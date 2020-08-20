var KushkiCheckout = function(modules) {
    var installedModules = {};

    function __webpack_require__(moduleId) {

        if (installedModules[moduleId]) return installedModules[moduleId].exports;
        var module = installedModules[moduleId] = {
            i: moduleId,
            l: !1,
            exports: {}
        };
        return modules[moduleId].call(module.exports, module, module.exports, __webpack_require__), module.l = !0, module.exports
    }
    return __webpack_require__.m = modules, __webpack_require__.c = installedModules, __webpack_require__.d = function(exports, name, getter) {
        __webpack_require__.o(exports, name) || Object.defineProperty(exports, name, {
            enumerable: !0,
            get: getter
        })
    }, __webpack_require__.r = function(exports) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(exports, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(exports, "__esModule", {
            value: !0
        })
    }, __webpack_require__.t = function(value, mode) {
        if (1 & mode && (value = __webpack_require__(value)), 8 & mode) return value;
        if (4 & mode && "object" == typeof value && value && value.__esModule) return value;
        var ns = Object.create(null);
        if (__webpack_require__.r(ns), Object.defineProperty(ns, "default", {
                enumerable: !0,
                value: value
            }), 2 & mode && "string" != typeof value)
            for (var key in value) __webpack_require__.d(ns, key, function(key) {
                return value[key]
            }.bind(null, key));
        return ns
    }, __webpack_require__.n = function(module) {
        var getter = module && module.__esModule ? function() {
            return module.default
        } : function() {
            return module
        };
        return __webpack_require__.d(getter, "a", getter), getter
    }, __webpack_require__.o = function(object, property) {
        return Object.prototype.hasOwnProperty.call(object, property)
    }, __webpack_require__.p = "", __webpack_require__(__webpack_require__.s = 0)
}([function(module, exports, __webpack_require__) {
    "use strict";
    exports.__esModule = !0;
    var kushki_checkout_legacy_1 = __webpack_require__(1);
    module.exports = kushki_checkout_legacy_1.KushkiCheckout
}, function(module, exports, __webpack_require__) {
    "use strict";
    exports.__esModule = !0;
    var CurrencyEnum, LanguageEnum, PaymentMethodsEnum, environment_1 = __webpack_require__(2);
    ! function(CurrencyEnum) {
        CurrencyEnum.USD = "USD", CurrencyEnum.COP = "COP", CurrencyEnum.PEN = "PEN", CurrencyEnum.CLP = "CLP"
    }(CurrencyEnum = exports.CurrencyEnum || (exports.CurrencyEnum = {})),
    function(LanguageEnum) {
        LanguageEnum.ES = "es", LanguageEnum.EN = "en"
    }(LanguageEnum = exports.LanguageEnum || (exports.LanguageEnum = {})),
    function(PaymentMethodsEnum) {
        PaymentMethodsEnum.card = "credit-card", PaymentMethodsEnum.transfer = "transfer", PaymentMethodsEnum.cash = "cash", PaymentMethodsEnum.card_async = "card_async", PaymentMethodsEnum.card_dynamic = "card_dynamic"
    }(PaymentMethodsEnum = exports.PaymentMethodsEnum || (exports.PaymentMethodsEnum = {}));
    var KushkiCheckout = function() {
        function KushkiCheckout(params) {
            var _this = this,
                form = document.getElementById(params.form);
            if (this._params = params, this._params.is_subscription = this._params.is_subscription || !1, this._params.language = this._params.language || LanguageEnum.ES, this._params.currency = this._params.currency || CurrencyEnum.USD, this._url = this._getCajitaUrl(), this._id = (+new Date).toString(), this._iFrameHeightOffset = 10, null === form) throw new Error("Form must exists.");
            if ("number" == typeof this._params.amount && (this._params.amount = this._params.amount.toFixed(2).toString()), "string" != typeof this._params.amount && "object" != typeof this._params.amount) throw new Error("Invalid amount.");
            if (void 0 !== this._params.payment_methods && -1 !== this._params.payment_methods.indexOf(PaymentMethodsEnum.transfer) && "object" != typeof this._params.amount) throw new Error("On transfer payment is required the amount as object.");
            this._form = form, this._iFrame = document.createElement("iframe"), this._loadIFrame(), window.addEventListener("message", function(event) {
                if (event.origin === _this._expectedOrigin()) return _this._processMessage(event.data)
            }, !1)
        }
        return KushkiCheckout.prototype._expectedOrigin = function() {
            
            var url_parts = this._url.split("/");

            return url_parts[0] + "//" + url_parts[2]
        }, KushkiCheckout.prototype._processMessage = function(message) {
            if ("string" == typeof message) {
                var _a = Array.from(message.split(":")),
                    method = _a[0],
                    argument = _a[1];

                switch (method) {
                    case "height":
                        return this._adjustHeight(argument);
                    case "parameters":
                        return this._setParameters(argument);
                    default:
                        return
                }
            }
        }, KushkiCheckout.prototype._getCajitaUrl = function() {
            return void 0 !== this._params.inTestEnvironment ? this._params.inTestEnvironment ? this._params.regional ? environment_1.environment.regionalTestUrl : environment_1.environment.testUrl : this._params.regional ? environment_1.environment.regionalProductionUrl : environment_1.environment.productionUrl : this._params.regional ? environment_1.environment.regionalDefaultUrl : environment_1.environment.defaultUrl
        }, KushkiCheckout.prototype._loadIFrame = function() {

            var _this = this,
                url = this._url + "?merchant_id=" + this._params.merchant_id + "&is_subscription=" + this._params.is_subscription + "&amount=" + ("string" == typeof this._params.amount ? this._params.amount : encodeURIComponent(JSON.stringify(this._params.amount))) + "&language=" + this._params.language + "&currency=" + this._params.currency + "&payment_methods=" + (void 0 !== this._params.payment_methods ? this._params.payment_methods : PaymentMethodsEnum.card) + "&regional=" + (void 0 !== this._params.regional && this._params.regional);
            void 0 !== this._params.callback_url && (url = url + "&callback_url=" + this._params.callback_url), void 0 !== this._params.return_url && (url = url + "&return_url=" + this._params.return_url);
            var attributes = {
                src: url,
                width: "100%",
                style: "display:block",
                name: "kushki-iframe",
                id: this._id,
                scrolling: "no",
                frameborder: "0"
            };
            return Object.keys(attributes).forEach(function(name) {
                _this._iFrame.setAttribute(name, attributes[name])
            }), this._form.appendChild(this._iFrame)
        }, KushkiCheckout.prototype._adjustHeight = function(height) {
            this._iFrame.height = (this._iFrameHeightOffset + parseInt(height, 10)).toString()
        }, KushkiCheckout.prototype._setParameters = function(parameters) {
            for (var _a = parameters.split(","), token = _a[0], months = _a[1], payment_method = _a[2], type = _a[3], months_of_grace = _a[4], add = !0, _i = 0, _b = this._form.elements; _i < _b.length; _i++) {
                if ("kushkiToken" === _b[_i].name) {
                    
                    add = !1;
                    break
                }
            }
            add && (this._createInput(token, "kushkiToken"), this._createInput(payment_method, "kushkiPaymentMethod"), void 0 !== type && "" !== type && (this._createInput(type, "kushkiDeferredType"), this._createInput(months, "kushkiDeferred"), void 0 !== months_of_grace && "" !== months_of_grace && this._createInput(months_of_grace, "kushkiMonthsOfGrace"))), this._form.submit()
        }, KushkiCheckout.prototype._createInput = function(valueParameter, nameParameter) {
            var input = document.createElement("input"),
                attributes = {
                    type: "hidden",
                    name: nameParameter,
                    value: valueParameter.trim()
                };

            Object.keys(attributes).forEach(function(name) {
                input.setAttribute(name, attributes[name])
            }), this._form.appendChild(input)
        }, KushkiCheckout
    }();
    exports.KushkiCheckout = KushkiCheckout
}, function(module, exports, __webpack_require__) {
    "use strict";
    exports.__esModule = !0, exports.environment = {
        defaultUrl: "https://cdn.kushkipagos.com/index.html",
        productionUrl: "https://cdn.kushkipagos.com/index.html",
        testUrl: "https://cdn-uat.kushkipagos.com/index.html",
        regionalDefaultUrl: "https://regional-cdn.kushkipagos.com/index.html",
        regionalProductionUrl: "https://regional-cdn.kushkipagos.com/index.html",
        regionalTestUrl: "https://regional-cdn-uat.kushkipagos.com/index.html"
    }
}]);
//# sourceMappingURL=kushki-checkout.js.map