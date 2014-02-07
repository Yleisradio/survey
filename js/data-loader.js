/*
 * Module for loading one or two sets of data defined by the filter
 * 
 */
var dataLoader = (function() {
    var requests = new Array();

    function getDefaultRequestParameters() {
        var requestParameters = {
            interval: $('#filter-form #mode').val(),
            sites: getSelected('#filter-form #surveys'),
            from: moment($('#filter-form #from').val()).toISOString(),
            to: moment($('#filter-form #to').val()).toISOString()
        };
        return requestParameters;
    }

    return {
        /*
         * Abort all requests
         */
        abort: function abort() {
            $.each(requests, function(index, request) {
                request.abort();
            });
        },
        loadData: function loadData(optionsParameters) {
            var options = optionsParameters;
            options.requestParameters = $.extend(getDefaultRequestParameters(), optionsParameters.requestParameters);
            var responses = 0;
            var responsesNeeded;
            var data = {};

            if (options.compareMode == 'none') {
                responsesNeeded = 1;
            }
            else {
                responsesNeeded = 2;
            }

            requests.push($.ajax({
                dataType: "json",
                url: options.url,
                data: options.requestParameters,
                success: function(response) {
                    responses++;
                    data.current = response;
                    if (typeof(options.callback) !== 'undefined') {
                        options.callback(response, options);
                    }
                    if (typeof(options.currentComplete) !== 'undefined') {
                        options.currentComplete(response, options);
                    }
                    if (responses === responsesNeeded) {
                        if (options.compareMode != 'none') {
                            if (typeof(options.compare) !== 'undefined') {
                                options.compare(data, options);
                            }
                        }
                        if (typeof(options.complete) !== 'undefined') {
                            options.complete(data, options);
                        }
                    }
                }
            }));


            if (options.compareMode != 'none') {
                options.requestParameters.from = moment(filter.previous().from).toISOString();
                options.requestParameters.to = moment(filter.previous().to).toISOString();

                requests.push($.ajax({
                    dataType: "json",
                    url: options.url,
                    data: options.requestParameters,
                    success: function(response) {
                        responses++;
                        data.previous = response;
                        if (typeof(options.callback) !== 'undefined') {
                            options.callback(response, options);
                        }
                        if (typeof(options.previousComplete) !== 'undefined') {
                            options.previousComplete(response, options);
                        }
                        if (responses === responsesNeeded) {
                            if (options.compareMode != 'none') {
                                if (typeof(options.compare) !== 'undefined') {
                                    options.compare(data, options);
                                }
                            }
                            if (typeof(options.complete) !== 'undefined') {
                                options.complete(data, options);
                            }
                        }
                    }
                }));
            }
        }
    }
})();

function getSelected(element) {
    var selected = [];
    $(element + ' input').each(function(index, element) {
        if ($(element).is(':checked')) {
            var id = $(element).attr('id');
            id = id.split('_');
            selected.push(id[1]);
        }
    });
    return selected;
}