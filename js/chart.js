var chart = (function() {

    var monthNames;

    function getTimeseriesChartSettings(settings) {
        var defaultSettings = {
            xaxis: {
                mode: "time",
                min: moment(filter.current().from).valueOf(),
                max: moment(filter.current().to).valueOf(),
                tickFormatter: function(value) {
                    return moment(value).format("D.M")
                },
            },
            grid: {
                hoverable: true,
                borderWidth: 0,
            },
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
                        formatter: pieLabelFormatter,
                        background: {
                            opacity: 0.8
                        }
                    }
                }
            },
            legend: {
                show: false
            }
        }
        return $.extend({}, defaultSettings, settings);
    }

    function pieLabelFormatter(label, series) {
        return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
    }

    function timeSeriesTooltip(event, pos, item) {
        if (item) {
            var x = item.datapoint[0],
                    y = item.datapoint[1].toFixed(2);
            $("#tooltip").html(moment(x).format("D.M.YYYY") + " : " + y)
                    .css({top: item.pageY + 5, left: item.pageX + 5})
                    .fadeIn(200);
        } else {
            $("#tooltip").hide();
        }

    }

    return {
        timeSeries: function(selector, values, settings) {
            $.plot(selector, values, getTimeseriesChartSettings(settings));
            $(selector).bind("plothover", timeSeriesTooltip);
        },
        pie: function(selector, values, settings) {
            $.plot(selector, values, getPieChartSettings(settings));
        },
        setMonthNames: function(newMonthNames) {
            monthNames = newMonthNames;
        }
    };
})();
