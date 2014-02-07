function loadLine(element, series) {
    var markerEnabled = true;
    if ($('#mode').val() == 'year') {
        markerEnabled = false;
    }

    Highcharts.setOptions({
        lang: {
            contextButtonTitle: null
        }
    });
    // Create the chart
    element.highcharts({
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: [
                        {
                            text: 'Luo JPG-kuva',
                            onclick: function() {
                                this.exportChart({
                                    type: 'image/jpeg',
                                    filename: 'verkkomittaristo'
                                });
                            },
                            separator: false
                        },
                        {
                            text: 'Luo PNG-kuva',
                            onclick: function() {
                                this.exportChart({
                                    filename: 'verkkomittaristo'
                                });
                            },
                            separator: false
                        },
                        {
                            text: 'Luo PDF-tiedosto',
                            onclick: function() {
                                this.exportChart({
                                    type: 'application/pdf',
                                    filename: 'verkkomittaristo'
                                });
                            }
                        },
                        {
                            text: 'Tulosta',
                            onclick: function() {
                                this.print({
                                });
                            }
                        }
                    ]
                }
            }
        },
        chart: {
            type: 'line',
            backgroundColor: 'rgba(255, 255, 255, 0)'
        },
        'title': {
            text: false
        },
        xAxis: [
            {
                type: 'datetime',
                min: Date.parse(filter.current().from),
                max: Date.parse(filter.current().to)
            },
            {
                labels: false,
                lineWidth: 0,
                type: 'datetime',
                min: Date.parse(filter.previous().from),
                max: Date.parse(filter.previous().to)
            }
        ],
        credits: {
            enabled: false
        },
        'yAxis': [
            // 0 - browsers, visits
            {
                min: 0,
                labels: {
                    enabled: false
                },
                title: ''
            },
            // 1 - visits per browser
            {
                labels: {
                    enabled: false
                },
                min: 0,
                title: ''
            },
            // 2 - interest
            {
                labels: {
                    enabled: false
                },
                min: 0,
                max: 6,
                endOnTick: false,
                maxPadding: 0,
                minPadding: 0,
                title: ''
            },
            // 3 - success
            {
                labels: {
                    enabled: false
                },
                min: 0,
                max: 100,
                endOnTick: false,
                maxPadding: 0,
                minPadding: 0,
                title: ''
            },
            // 4 - nps
            {
                labels: {
                    enabled: false
                },
                min: -100,
                max: 100,
                endOnTick: false,
                maxPadding: 0,
                minPadding: 0,
                title: ''

            },
            // 5 - gender
            {
                labels: {
                    enabled: false
                },
                endOnTick: false,
                maxPadding: 0,
                minPadding: 0,
                title: ''
            },
            // 6 - age
            {
                labels: {
                    enabled: false
                },
                maxPadding: 0,
                minPadding: 0,
                title: ''
            },
            // 7 - SEO Visibility
            {
                labels: {
                    enabled: false
                },
                min: 0,
                maxPadding: 0,
                minPadding: 0,
                title: ''
            },
            // 8 - Sentiment
            {
                labels: {
                    enabled: false
                },
                min: -1,
                max: 1,
                maxPadding: 0,
                minPadding: 0,
                title: ''
            }
        ],
        legend: {
           enabled: true,
            align: 'bottom',
            itemWidth:300
        },
        plotOptions: {
            column: {
                animation: false
            },
            line: {
                animation: false,
                lineWidth: 2.5,
                marker: {
                    enabled: markerEnabled
                }
            },
            area: {
                stacking: 'percent',
                fillOpacity: 0.8,
                animation: false
            },
            'series': {
                groupPadding: 0.05,
                pointPadding: 0.025,
                dataGrouping: {
                    dateTimeLabelFormats: {
                        millisecond: ['%A, %b %e, %H:%M:%S.%L', '%A, %b %e, %H:%M:%S.%L', '-%H:%M:%S.%L'],
                        second: ['%A, %b %e, %H:%M:%S', '%A, %b %e, %H:%M:%S', '-%H:%M:%S'],
                        minute: ['%A, %b %e, %H:%M', '%A, %b %e, %H:%M', '-%H:%M'],
                        hour: ['%A, %b %e, %H:%M', '%A, %b %e, %H:%M', '-%H:%M'],
                        day: ['%A, %b %e, %Y', '%A, %b %e', '-%A, %b %e, %Y'],
                        week: ['Viikko alkaen päivästä %A, %b %e, %Y', '%A, %b %e', '-%A, %b %e, %Y'],
                        month: ['%B %Y', '%B', '-%B %Y'],
                        year: ['%Y', '%Y', '-%Y']
                    }
                }
            }
        },
        tooltip: {
            formatter: function() {
                if (isNaN(this.percentage)) {
                    return Highcharts.dateFormat('%A %d %B %Y', this.x) + '<br /><span style="color: ' + this.series.color + '">' + this.series.name + '</span>: <b>' + formatNumber(this.y) + '</b>';
                }
                else {
                    return Highcharts.dateFormat('%A %d %B %Y', this.x) + '<br /><span style="color: ' + this.series.color + '">' + this.series.name + '</span>: <b>' + Math.round(this.percentage, 2) + '</b> % (<b>' + formatNumber(this.y) + '</b>)';
                }
            }
        },
        'series': series
    });
}

function loadColumn(element, series, categories) {
    // Create the chart
    element.highcharts({
        exporting: {
            enabled: false,
        },
        chart: {
            type: 'column',
            backgroundColor: 'rgba(255, 255, 255, 0)'
        },
        'title': {
            text: false
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: categories,
            tickmarkPlacement: 'on',
            lineWidth: 0
        },
        yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 0,
            title: ''
        },
        legend: {
            enabled: false
        },
        plotOptions: {
        },
        'series': series
    });
}

function loadBar(element, series) {
    element.highcharts({
        exporting: {
            enabled: false,
        },
        chart: {
            type: 'bar',
            backgroundColor: 'rgba(255, 255, 255, 0)'
        },
        'title': {
            text: false
        },
        credits: {
            enabled: false
        },
        xAxis: {
            title: '',
            lineWidth: 0,
            gridLineWidth: 0,
            minorGridLineWidth: 0,
            minorTickWidth: 0,
            tickWidth: 0,
            labels: {
                enabled: false
            }
        },
        yAxis: {
            gridLineInterpolation: 'polygon',
            title: '',
            lineWidth: 0,
            gridLineWidth: 0,
            minorGridLineWidth: 0,
            minorTickWidth: 0,
            tickWidth: 0,
            labels: {
                enabled: false
            },
            gridLineWidth: 0
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            bar: {
                animation: false,
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: '#FFF',
                    style: {
                        fontSize: '12px'
                    },
                    formatter: function() {
                        if (this.percentage > 15) {
                            return this.series.name + '<br /><b>' + Math.round(this.percentage) + '</b> %';
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function() {
                return '<span style="color: ' + this.series.color + '">' + this.series.name + '</span>: <b>' + Math.round(this.percentage, 2) + '</b> % (<b>' + formatNumber(this.y) + '</b>)';
            }
        },
        'series': series
    });
}

function loadPie(element, series) {
    element.highcharts({
        exporting: {
            enabled: false,
        },
        chart: {
            type: 'pie',
        },
        'title': {
            text: false
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            pie: {
                animation: false
            }
        },
        'series': series,
        tooltip: {
            formatter: function() {
                return '<span style="color: ' + this.series.color + '">' + this.key + '</span>: <b>' + Math.round(this.percentage, 2) + '</b> % (<b>' + formatNumber(this.y) + '</b>)';
            }
        }
    });
}

function chartYAxes() {
    return {
        'browser': 0,
        'visit': 0,
        'visits-per-browser': 1,
        'interest': 2,
        'success': 3,
        'nps': 4,
        male: 5,
        female: 5,
        '0-14': 6,
        '15-29': 6,
        '30-44': 6,
        '45-59': 6,
        '60-74': 6,
        '75+': 6,
        visibility: 7,
        sentiment: 8
    };
}

function getChartYAxis(chart) {
    var axes = chartYAxes();
    return axes[chart];
}

/**
 * Renders all the selected series on the chart
 * @returns {undefined} */
function renderChart() {
    changeWeeklyLabel();
    renderChartTitle();
    var seriesToRender = $.map(series, function(serie) {

        if (typeof(serie.identifier) !== 'undefined') {
            toggler = $('#series_' + serie.identifier);
            if (typeof(toggler) !== 'undefined') {
                if (toggler.is(':checked'))
                    return serie;
            }
        }
        return null;
    });
    loadLine($('#big-chart'), seriesToRender);

}

function renderChartTitle() {
    var timePeriod = '';

    var mode = $('#mode').val();
    if (mode == 'week') {
        timePeriod += 'Viikko ' + getWeekNumber(filter.current().from) + ' ';
    }

    periodLength = (filter.current().to - filter.current().from) / 1000 / 60 / 60 / 24;
    timePeriod += filter.current().from.getUTCDate() + '.' + (filter.current().from.getUTCMonth() + 1) + '.' + filter.current().from.getUTCFullYear() + ' - ' + filter.current().to.getUTCDate() + '.' + (filter.current().to.getUTCMonth() + 1) + '.' + filter.current().to.getUTCFullYear() + ' (' + (Math.round(periodLength)) + ' päivää)';

    var comparePeriod = '';
    if (filter.previous().from) {
        comparePeriod = ' Vertailujakso ' + filter.previous().from.getUTCDate() + '.' + (filter.previous().from.getUTCMonth() + 1) + '.' + filter.previous().from.getUTCFullYear();
        periodLength = (filter.previous().to - filter.previous().from) / 1000 / 60 / 60 / 24;
        comparePeriod += ' - ' + filter.previous().to.getUTCDate() + '.' + (filter.previous().to.getUTCMonth() + 1) + '.' + filter.previous().to.getUTCFullYear() + ' (' + (Math.round(periodLength)) + ' päivää)';
    }
    $('.time-period').html(timePeriod);
    $('.compare-period').html(comparePeriod);
}

function changeWeeklyLabel() {
    if ($('#mode').val() === 'day' || $('#mode').val() === 'week') {
        $('#browsers-label').html('Selaimet');
        $('#visits-label').html('Käynnit');
    } else {
        $('#browsers-label').html('Selaimia viikossa');
        $('#visits-label').html('Käyntejä viikossa');
    }
}

function getWeekNumber(d) {
    // Copy date so don't modify original
    d = new Date(d);
    d.setHours(0, 0, 0);
    // Set to nearest Thursday: current date + 4 - current day number
    // Make Sunday's day number 7
    d.setDate(d.getDate() + 4 - (d.getDay() || 7));
    // Get first day of year
    var yearStart = new Date(d.getFullYear(), 0, 1);
    // Calculate full weeks to nearest Thursday
    var weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7)
    // Return array of year and week number
    return weekNo;
}
