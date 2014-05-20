function loadYleWebPollResources() {
    if (typeof jQuery != 'undefined') {
        if (typeof (jQuery().cookie) === 'undefined') {
            /**
             * Cookie plugin
             *
             * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
             * Dual licensed under the MIT and GPL licenses:
             * http://www.opensource.org/licenses/mit-license.php
             * http://www.gnu.org/licenses/gpl.html
             *
             */
            jQuery.cookie = function(name, value, options) {
                if (typeof value != 'undefined') {
                    options = options || {};
                    if (value === null) {
                        value = '';
                        options = jQuery.extend({}, options);
                        options.expires = -1;
                    }
                    var expires = '';
                    if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
                        var date;
                        if (typeof options.expires == 'number') {
                            date = new Date();
                            date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
                        } else {
                            date = options.expires;
                        }
                        expires = '; expires=' + date.toUTCString();
                    }
                    var path = options.path ? '; path=' + (options.path) : '';
                    var domain = options.domain ? '; domain=' + (options.domain) : '';
                    var secure = options.secure ? '; secure' : '';
                    document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
                } else {
                    var cookieValue = null;
                    if (document.cookie && document.cookie != '') {
                        var cookies = document.cookie.split(';');
                        for (var i = 0; i < cookies.length; i++) {
                            var cookie = jQuery.trim(cookies[i]);
                            if (cookie.substring(0, name.length + 1) == (name + '=')) {
                                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                                break;
                            }
                        }
                    }
                    return cookieValue;
                }
            };
        }
        (function($) {
            $.yleWebPoll = function(el, options) {
                var base = this;
                base.$el = $(el);
                base.el = el;
                base.$el.data("yleWebPoll", base);
                base.sessionCookie = "sessionCookie";
                base.userIdCookie = "webropoll_id";
                base.init = function() {
                    base.options = options;
                    base.webropollSurveyIdCookie = base.options.siteURL;
                    base.launchSurveyByFreq(function() {
                        base.setUserIdCookie(base.userIdCookie);
                        base.setCookie(base.webropollSurveyIdCookie, "yleWebPoll");
                        base.viewLayer(base.getWebroPollUrl());
                    })
                };
                base.setUserIdCookie = function(userIdCookie) {
                    if (!base.isCookie(userIdCookie)) {
                        var userId = base.randomNumber(600000);
                        userId += new Date().getTime();
                        base.setCookie(userIdCookie, userId);
                    }
                };
                base.getWebroPollUrl = function() {
                    var url = base.options.formURL
                            , urlParams = base.options.urlParams
                            , urlParamsArray = [];
                    if (url != '') {
                        for (key in urlParams) {
                            if (urlParams[key] != 'undefined' && urlParams[key] != null && urlParams[key] != '') {
                                urlParamsArray.push(key + '=' + urlParams[key]);
                            }
                        }
                        if (url && url.match(/\?/)) {
                            return url + '&' + urlParamsArray.join('&');
                        } else {
                            return url + '?' + urlParamsArray.join('&');
                        }
                    } else {
                        base.log('YLE.fi - Webropol error ' + e);
                    }
                };
                base.isCookie = function(cookie) {
                    var found = false;
                    if ($.cookie(cookie) != null) {
                        found = true;
                    }
                    return found;
                };
                base.isFreqPoll = function() {
                    $.cookie(base.sessionCookie, base.sessionCookie, {path: base.options.path});
                    var viewLayer = false;
                    var randomNumber = base.randomNumber(base.options.displayFrequency);
                    var freqView = randomNumber / base.options.displayFrequency;
                    base.debug("Arvonnassa", freqView);
                    if (freqView == 1) {
                        viewLayer = true;
                    }
                    return viewLayer;
                };
                base.viewLayer = function(url) {
                    base.$el.append('<div id="yleWebPoll-modal"><h1 style="display: block;font-size: 2em;font-weight: bold; margin: 0.67em 0;border:none;">' + base.options.texts.title + '</h1><p>' + base.options.texts.row1 + '</p><p>' + base.options.texts.row2 + '</p><p>' + base.options.texts.row3 + '</p><p>' + base.options.texts.row4 + '</p><p>' + base.options.texts.row5 + '</p><a href="#" id="yleWebPoll-yes">' + base.options.texts.linkYes + '</a><a href="#" id="yleWebPoll-no">' + base.options.texts.linkNo + '</a><div style="clear: both;"></div></div><div id="yleWebPoll-mask"></div>');
                    var modalWrapperCSS = {
                        'width': '100%',
                        'position': 'absolute',
                        'top': '50px'
                    };
                    base.$el.css(modalWrapperCSS);
                    var maskCSS = {
                        'position': 'fixed',
                        'left': '0',
                        'top': '0',
                        'z-index': '9',
                        'background-color': 'black',
                        'display': 'block',
                        'width': '100%',
                        'height': '100%',
                        'opacity': '0.4'
                    };
                    base.$el.find('#yleWebPoll-mask').css(maskCSS);
                    //var leftMargin = ($(window).width() / 2) - (base.$el.width() / 2);
                    //base.$el.css('left', leftMargin + 'px');
                    var linkCSS = {
                        'background-color': '#00b5c8',
                        'color': 'white',
                        'display': 'block',
                        'text-align': 'center',
                        'vertical-align': 'middle',
                        'border-radius': '4px',
                        'font-family': '"Helvetica", Helvetica, Arial, sans-serif',
                        'font-size': '12pt',
                        'font-weight': 'normal',
                        'padding': '8px 0 8px 0',
                        'margin': '0 10px 10px 0',
                        'text-decoration': 'none',
                        'width': '100px',
                        'float': 'left'
                    };
                    base.$el.find('a').css(linkCSS);
                    var modalCSS = {
                        'position': 'relative',
                        'background-color': 'white',
                        'font-family': '"Helvetica Neue",Helvetica,Arial,sans-serif',
                        'font-size': '14px',
                        'line-height': '20px',
                        'color': '#000',
                        'top': '20%',
                        'max-width': '500px',
                        'width': '100%',
                        'z-index': '99999',
                        'padding': '20px',
                        'margin': '20px auto 0 auto'
                    };
                    base.$el.find('#yleWebPoll-modal').css(modalCSS);
                    base.$el.fadeIn();
                    base.$el.find('#yleWebPoll-yes')
                            .click(function(e) {
                        e.preventDefault();
                        base.$el.fadeOut();
                        var popunder = window.open(url, '_blank');
                    });
                    base.$el.find('#yleWebPoll-no')
                            .click(function(e) {
                        e.preventDefault();
                        base.$el.fadeOut();
                    });
                };
                base.launchSurveyByFreq = function(callback) {
                    if (!base.isCookie(base.sessionCookie) && !base.isCookie(base.webropollSurveyIdCookie) || base.options.debug) {
                        if (base.isFreqPoll() || base.options.debug) {
                            callback();
                        } else {
                            return false;
                        }
                    }
                };
                base.getCookie = function(cookieName) {
                    return $.cookie(cookieName);
                };
                base.setCookie = function(cookie, str) {
                    var expirationDate = new Date;
                    expirationDate.setMonth(expirationDate.getMonth() + 6);
                    $.cookie(cookie, str, {expires: expirationDate, path: base.options.path});
                    base.debug("Cookie vanhenee", expirationDate);
                };
                base.randomNumber = function(freq) {
                    return Math.floor(Math.random() * freq) + 1;
                };
                base.debug = function(msg, content) {
                    if (base.options.debug && typeof console !== "undefined") {
                        console.log(msg + ": " + content);
                    }
                };
                // Run initializer
                base.init();
            };

            $.fn.yleWebPoll = function(options) {
                var el = this.data("yleWebPoll");
                if (el) {
                    return el;
                }
                return this.each(function() {
                    (new $.yleWebPoll(this, options));
                });
            };

        })(jQuery);
        (function($) {

            function init(siteConfs) {
                var currentPath = getSiteRoot()
                        , currentHostname = window.location.hostname
                        , currentUrl = currentHostname + currentPath
                        , currentCategory = $('body').attr(siteConfs.surveyConfig.categoryAttribute)
                        , currentSiteConf = getCurrentSiteConf(siteConfs.surveyList, currentUrl, currentCategory)
                        , localization = siteConfs.popupLocalization;
                if (currentSiteConf) {
                    launchPlugin(currentSiteConf, siteConfs.surveyConfig, localization);
                } else {
                    return false;
                }
            }

            function launchPlugin(currentSiteConf, formSettings, localization) {
                var pluginOptions = mapOptions(currentSiteConf, formSettings, localization);
                $('<div id="yleWebPoll" style="display:none;"></div>')
                        .appendTo('body')
                        .yleWebPoll(pluginOptions);
            }
            function mapOptions(currentSiteConf, formSettings, localization) {
                var options = formSettings;
                options.path = currentSiteConf.currentPath;
                options.siteURL = currentSiteConf.siteURL;
                options.debug = false,
                        options.urlParams = {
                    surveyId: currentSiteConf.id
                };
                options.texts = localization[currentSiteConf.language]  ;
                options.displayFrequency = currentSiteConf.freq;
                return options;
            }
            function getCurrentSiteConf(siteConf, currentUrl, currentCategory) {
                var currentSiteConf
                        , lastSlashRegx = /\/$/;
                for (i in siteConf) {
                    var siteUrl = siteConf[i].siteURL,
                            siteUrlObj = getSiteConfUrlLocation(siteUrl);
                    siteUrl = siteUrlObj.domain + siteUrlObj.path;
                    siteUrl = siteUrl.replace(lastSlashRegx, '');
                    currentUrl = currentUrl.replace(lastSlashRegx, '');
                    //Match by category
                    if (typeof(currentCategory) !== 'undefined') {
                        if (currentCategory === siteConf[i].category && siteConf[i].category) {
                            currentSiteConf = siteConf[i];
                            currentSiteConf.currentPath = '/';
                            break;
                        }
                    }
                    //Match by URL
                    else if (typeof(currentUrl) !== 'undefined' && siteUrl) {
                        if (currentUrl.match(siteUrl)) {
                            currentSiteConf = siteConf[i];
                            currentSiteConf.currentPath = siteUrlObj.path;
                            break;
                        }
                    }
                }
                return currentSiteConf || false;
            }
            function getSiteRoot() {
                return window.location.pathname;
            }
            function getCurrentComscoreCategory() {
                if (typeof(window.ns_pixelUrl) !== 'undefined') {
                    return window.ns_pixelUrl.replace(/^.*\?/, '').replace(/&.*$/, '');
                } else {
                    return false;
                }
            }
            function getSiteConfUrlLocation(siteConfUrl) {
                var url = siteConfUrl.replace(/http:\/\/|https:\/\//, ""),
                        urlSplit = url.split('/'),
                        siteConfLocation = {
                    'domain': urlSplit.shift(),
                    'path': '/' + urlSplit.join('/'),
                };
                return siteConfLocation;
            }
            var conf = window.YLESurveyConfig || {};

            init(conf);
        })(jQuery);
    }
}
if (window.attachEvent) {
    window.attachEvent('onload', loadYleWebPollResources);
} else {
    window.addEventListener('load', loadYleWebPollResources, false);
}