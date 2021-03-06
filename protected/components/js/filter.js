/**
 * 
 * Filter module handles saving and processing of the date filters.
 */
var filter = (function() {
    var saveRequest;

    $(document).ready(function() {
        setCurrent(new Date(moment($('#from').val())));
        filter.changeMode(this, '7-days');

        $('#compare').change(function() {
            filter.refresh();
        });
        $('#surveys').change(function(ev) {
            if ($(ev.target).attr('id') !== 'surveys_0') {
                filter.refresh();
            }
        });

        jQuery('#surveys_0').click(function() {
            jQuery("input[name='surveys\[\]']").prop('checked', this.checked);
            filter.refresh();
        });
        jQuery("input[name='surveys\[\]']").click(function() {
            jQuery('#surveys_0').prop('checked', !jQuery("input[name='surveys\[\]']:not(:checked)").length);
        });
        jQuery('#surveys_0').prop('checked', !jQuery("input[name='surveys\[\]']:not(:checked)").length);


        $('#filter-form .active').removeClass('active');
        $('#' + $('#mode').val() + '-button').addClass('active');

        $('#year-button').click(function() {
            filter.changeMode(this, 'year');
            return false;
        });
        $('#month-button').click(function() {
            filter.changeMode(this, 'month');
            return false;
        });
        $('#7-days-button').click(function() {
            filter.changeMode(this, '7-days');
            return false;
        });
        $('#week-button').click(function() {
            filter.changeMode(this, 'week');
            return false;
        });
        $('#day-button').click(function() {
            filter.changeMode(this, 'day');
            return false;
        });
        $('#previous-button').click(function() {
            filter.previousRange();
            return false;
        });
        $('#next-button').click(function() {
            filter.nextRange();
            return false;
        });
        $('#gender').change(function() {
            filter.refresh();
        });
        $('#age').change(function() {
            filter.refresh();
        });
        $('#recommend-min').change(function() {
            filter.refresh();
        });
        $('#recommend-max').change(function() {
            filter.refresh();
        });
        $('#interest-min').change(function() {
            filter.refresh();
        });
        $('#interest-max').change(function() {
            filter.refresh();
        });
        $('#text-only').change(function() {
            filter.refresh();
        });
        $('#failed-only').change(function() {
            filter.refresh();
        });
        $('#sentiment').change(function() {
            filter.refresh();
        });
    });

    var filterChanged = null;

    var filters = {
        current: {
            from: null,
            to: null
        },
        previous: {
            from: null,
            to: null
        },
        topics: []
    };

    function getTo(from) {
        var to = from;
        var mode = $('#mode').val();
        if (mode === 'year') {
            to.setUTCFullYear(to.getUTCFullYear() + 1);
        }
        if (mode === 'month') {
            to.setUTCMonth(to.getUTCMonth() + 1);
        }
        if (mode === 'week') {
            to.setUTCDate(to.getUTCDate() + 7);
        }
        if (mode === 'day') {
            to.setUTCDate(to.getUTCDate() + 1);
        }
        if (mode === '7-days') {
            to.setUTCDate(to.getUTCDate() + 7);
        }
        if (mode !== 'day' && mode !== 'week' && mode !== '7-days') {
            to = getSunday(to);
        }
        to.setUTCSeconds((to.getUTCSeconds() - 1));
        return to;
    }

    function setCurrent(from) {
        filters.current.from = new Date(from);
        filters.current.to = new Date(getTo(from));
        $('#filter-form #from').val(filters.current.from);
        $('#filter-form #to').val(filters.current.to);
        filter.refresh();
    }

    function getSelected(type) {
        var selectedSeries = [];
        $('.' + type + ' .series-toggler').each(function(index, element) {
            if ($(element).is(':checked')) {
                var id = $(element).attr('id');
                id = id.split('_');
                selectedSeries.push(id[1]);
            }
        });
        return selectedSeries;
    }

    function saveFilter() {
        if (typeof(saveRequest) === 'object') {
            saveRequest.abort();
        }
        saveRequest = $.ajax({
            dataType: "json",
            url: 'filter/save',
            data: $('#filter-form').serialize(),
            success: function(response) {

            }
        });
    }

    function setPreviousDates() {
        var start = new Date(filters.current.from);
        var end = new Date(filters.current.to);
        var length = end - start;
        var compare = $('#compare').val();

        filters.previous.from = null;
        filters.previous.to = null;
        if (compare === 'year') {
            start = sameWeekDayOfPreviousYear(start);
            end = sameWeekDayOfPreviousYear(end);
            if ((end - start) < length) {
                end.setDate(end.getUTCDate() + 7);
            }
            if ($('#mode').val() !== 'day') {
                start = getMonday(start);
                end = getSunday(end);
            }
            if ($('#mode').val() === 'year') {
                end.setUTCDate((end.getUTCDate() - 1));
            }
            end.setUTCSeconds((end.getUTCSeconds() - 1));
        }
        else if (compare === 'period') {
            end = new Date(start);
            start = new Date(start - length);
            start.setUTCSeconds(0);
            if ($('#mode').val() === 'month') {
                end.setUTCDate(end.getUTCDate() - 1);
            }
            if ($('#mode').val() !== 'day') {
                start = getMonday(start);
            }
            if ($('#mode').val() === 'year') {
                end.setUTCDate((end.getUTCDate() - 1));
            }
            end.setUTCSeconds((end.getUTCSeconds() - 1));
        }
        if (compare !== 'none') {
            filters.previous.from = start;
            filters.previous.to = end;
        }
    }

    function sameWeekDayOfPreviousYear(date) {
        // Here we store the day of the week            
        var originalDay = date.getUTCDay();
        // Move back a year 
        date.setUTCFullYear(date.getUTCFullYear() - 1);
        // Find the day of the week offset
        var offset = originalDay - date.getUTCDay();
        if (offset < 0) {
            offset += 7;
        }
        date.setUTCDate(date.getUTCDate() + offset);
        return date;
    }



    /**
     * Returns the Monday of the same week of the input date
     * @param {Date} d
     * @returns {Date}
     */
    function getMonday(d) {
        d = new Date(d);
        var day = d.getUTCDay();
        var diff = d.getUTCDate() - day + (day === 0 ? -6 : 1); // adjust when day is sunday
        return new Date(d.setUTCDate(diff));
    }
    /**
     * Returns the Sunday of the same week of the input date
     * @param {type} d
     * @returns {Date}
     */
    function getSunday(d) {
        d = new Date(d);
        var day = d.getUTCDay();
        var diff = d.getUTCDate() + 1 + (day === 0 ? 0 : 7 - day); // adjust when day is sunday
        return new Date(d.setUTCDate(diff));
    }

    function getSelected(element) {
        var selected = [];
        $(element + ' input').each(function(index, element) {
            if ($(element).is(':checked')) {
                selected.push((element).value);
            }
        });
        selected = selected.join(',');
        return selected;
    }

    function getFilter(id) {
        var filter = $('#' + id).val();
        if (filter.indexOf('_all') === -1) {
            return filter;
        } else {
            return '';
        }
    }

    function updateTopicList() {
        var list = '';
        var hidden = '';
        for (var i in filters.topics) {
            hidden += '<input name="topics[' + filters.topics[i].value + ']" type="hidden" value="' + filters.topics[i].label + '" >'
            list += '<li class="label label-default">' + filters.topics[i].label + '<button data-topic="' + filters.topics[i].value + '" type="button" class="close">&times;</button></li>';
        }
        $('#topics').html(list);
        $('#topics-hidden').html(hidden);
        console.log(filters.topics);
        filter.refresh();
        $('#topics .close').click(function(event) {
            var topicId = $(event.target).attr('data-topic');
            filter.removeTopic(topicId);
        });
    }

    return {
        /**
         * Returns current time period
         */
        current: function() {
            return filters.current;
        },
        /**
         * Returns previous (compare) time period
         */
        previous: function() {
            return filters.previous;
        },
        age: function() {
            return getFilter('age');
        },
        gender: function() {
            return getFilter('gender');
        },
        recommendMin: function() {
            return getFilter('recommend-min');
        },
        recommendMax: function() {
            return getFilter('recommend-max');
        },
        interestMin: function() {
            return getFilter('interest-min');
        },
        interestMax: function() {
            return getFilter('interest-max');
        },
        failedOnly: function() {
            if ($('#failed-only').attr('checked')) {
                return 1;
            } else {
                return 0;
            }
        },
        textOnly: function() {
            if ($('#text-only').attr('checked')) {
                return 1;
            } else {
                return 0;
            }
        },
        sentiment: function() {
            return getFilter('sentiment');
        },
        /**
         * Changes to previous time period
         */
        previousRange: function() {
            var mode = $('#mode').val();
            var from = filters.current.from;
            if (mode === 'year') {
                from.setUTCFullYear(from.getUTCFullYear() - 1);
                from.setUTCDate(from.getUTCDate() + 7);
            }
            if (mode === 'month') {
                from.setUTCMonth(from.getUTCMonth() - 1);
                from.setUTCDate(from.getUTCDate() + 7);
            }
            if (mode === 'week' || mode === '7-days') {
                from.setUTCDate(from.getUTCDate() - 7);
            }
            if (mode === 'day') {
                from.setUTCDate(from.getUTCDate() - 1);
            }
            if (mode !== 'day') {
                from = getMonday(from);
            }

            setCurrent(from);
        },
        /**
         * Changes to next time period
         */
        nextRange: function() {
            var mode = $('#mode').val();
            var from = filters.current.from;
            if (mode === 'year') {
                from.setUTCFullYear(from.getUTCFullYear() + 1);
            }
            if (mode === 'month') {
                from.setUTCMonth(from.getUTCMonth() + 1);
            }
            if (mode === 'week' || mode === '7-days') {
                from.setUTCDate(from.getUTCDate() + 7);
            }
            if (mode === 'day') {
                from.setUTCDate(from.getUTCDate() + 1);
            }
            if (mode !== 'day') {
                from = getMonday(from);
            }
            setCurrent(from);
        },
        /**
         * Changes time period mode
         * @param {type} button
         * @param {type} mode
         * @returns {undefined}
         */
        changeMode: function(button, mode) {
            $('#filter-form .active').removeClass('active');
            $(button).addClass('active');
            $('#mode').val(mode);

            //Set start time according to the time period
            var from = new Date();
            from.setUTCHours(0);
            from.setUTCMinutes(0);
            from.setUTCSeconds(0);
            from.setUTCMilliseconds(0);
            if (mode === 'year') {
                from.setUTCFullYear(from.getUTCFullYear() - 1);
            }
            if (mode === 'month') {
                from.setUTCMonth(from.getUTCMonth() - 1);
            }
            if (mode === 'week') {

            }
            if (mode === 'day') {
                from.setUTCDate(from.getUTCDate() - 1);
            }
            if (mode === '7-days') {
                from.setUTCDate(from.getUTCDate() - 6);
            }
            if (mode !== 'day' && mode !== '7-days') {
                from = getMonday(from);
            }
            setCurrent(from);
        },
        /**
         * Sets callback function that is called when filter is changed
         * @param {type} callbackFunction
         * @returns {undefined}
         */
        setFilterChanged: function(callbackFunction) {
            if (typeof(callbackFunction) === 'function') {
                filterChanged = callbackFunction;
            }
        },
        surveys: function() {
            return getSelected('#filter-form #surveys');
        },
        refresh: function() {
            setPreviousDates();
            saveFilter();
            if (typeof(filterChanged) === 'function') {
                filterChanged();
            }
        },
        topics: function() {
            return filters.topics;
        },
        addTopic: function(topic) {
            filters.topics.push(topic);
            updateTopicList();
        },
        removeTopic: function(id) {
            console.log(id);
            for (var i in filters.topics) {
                console.log(filters.topics[i].value);
                if (filters.topics[i].value == id) {
                    delete filters.topics[i];
                }
            }
            updateTopicList();
        },
        setTopics: function(topics) {
            for (var id in topics) {
                filters.topics.push({
                    label: topics[id],
                    value: id
                });
            }
            updateTopicList();
        }
    };
})();
