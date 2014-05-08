var chart = (function() {

    var monthNames;

    function getTimeseriesChartSettings(settings) {
        var defaultSettings = {
            xaxis: {
                mode: "time",
                min: moment.utc(filter.current().from).subtract('hours', 6).valueOf(),
                max: moment.utc(filter.current().to).subtract('hours', 18).valueOf(),
                tickFormatter: function(value) {
                    return moment(value).format("D.M.");
                }
            },
            grid: {
                hoverable: true,
                borderWidth: 0
            },
            series: {
                color: '#397ab3',
                shadowSize: 0
            }
        };
        if (monthNames) {
            defaultSettings.xaxis.monthNames = monthNames;
        }
        return $.extend({}, defaultSettings, settings);
    }

    function getPieChartSettings(settings) {
        var defaultSettings = {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true,
                    label: {
                        show: true,
                        radius: 1,
                        threshold: 0.1,
                        formatter: pieLabelFormatter,
                        background: {
                            opacity: 1
                        }
                    }
                }
            },
            grid: {
                hoverable: true
            },
            legend: {
                show: false
            }
        };
        return $.extend({}, defaultSettings, settings);
    }

    function getBarChartSettings(settings) {
        var defaultSettings = {
            series: {
                bars: {
                    show: true,
                    horizontal: true,
                    barWidth: .8,
                    align: "center",
                    fill: 1
                },
                stack: true
            },
            xaxis: {
                show: true
            },
            grid: {
                hoverable: true,
                borderWidth: 0
            },
            legend: {
                show: false
            }
        };
        return $.extend({}, defaultSettings, settings);
    }

    function pieLabelFormatter(label, series) {
        return "<div style='font-size:10pt; text-align:center; padding:5px; color:white;'>" + label + "<br/><b>" + Math.round(series.percent) + "%</b></div>";
    }

    function bindTooltip(tooltipFormatter) {
        return function(ev, pos, item) {
            if (item) {
                $("#tooltip").html(tooltipFormatter(item)).css({
                    top: pos.pageY + 10,
                    left: pos.pageX + 10,
                    border: '1px solid ' + item.series.color
                }).fadeIn(200);
            } else {
                $("#tooltip").hide();
            }
        };
    }

    return {
        timeSeries: function(selector, values, settings) {
            $.plot(selector, values, getTimeseriesChartSettings(settings));
            $(selector).bind("plothover", bindTooltip(function(item) {
                return moment(item.datapoint[0]).format("D.M.YYYY") + " : " + item.datapoint[1];
            }));
        },
        pie: function(selector, values, settings) {
            $.plot(selector, values, getPieChartSettings(settings));
            $(selector).bind("plothover", bindTooltip(function(item) {
                return item.series.label + ' : ' + Math.round(item.datapoint[0] * 100) / 100  + " % (" + item.datapoint[1][0][1] + ")";
            }));
        },
        bar: function(selector, values, settings, tooltipFormatter) {
            $.plot(selector, values, getBarChartSettings(settings));
            $(selector).bind("plothover", bindTooltip(tooltipFormatter));
        },
        setMonthNames: function(newMonthNames) {
            monthNames = newMonthNames;
        }
    };
})();
