<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="form-horizontal filter-column">
                <?php
                $this->widget('FilterForm', array(
                ));
                ?> 
            </div>
        </div>
        <div class="col-md-9">
            <div class="date-display">
                <h1 id="time-period"></h1>
                <h3 id="n-number-heading"><?php echo Yii::t('report', 'number of answers'); ?>: <span id="n-number"></span></h3>
                <div class="clearfix"></div>
            </div>
            <div class="row border-bottom metrics-wrapper">
                <div class="col-md-3 border-right" id="nps">
                    <div class="metric-label"><?php echo Yii::t('report', 'NPS') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-chart"></div>
                </div>
                <div class="col-md-3" id="interest">
                    <div class="metric-label"><?php echo Yii::t('report', 'interest') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-chart"></div>
                </div>
                <div class="col-md-3" id="success">
                    <div class="metric-label"><?php echo Yii::t('report', 'success') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-chart"></div>
                </div>
                <div class="col-md-3" id="sentiment">
                    <div class="metric-label"><?php echo Yii::t('report', 'sentiment') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-chart"></div>
                </div>
            </div>
            <div class="row border-bottom">
                <div class="col-md-3" id="age">
                    <div class="metric-label"><?php echo Yii::t('report', 'chart.age') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-pie-chart"></div>
                </div>
                <div class="col-md-3" id="gender">
                    <div class="metric-label"><?php echo Yii::t('report', 'chart.gender') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-pie-chart"></div>
                </div>
                <div class="col-md-6" id="topic">
                    <div class="metric-label"><?php echo Yii::t('report', 'topics') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-bar-chart"></div>
                </div>
            </div>
            <div class="row answers">

            </div>
        </div>
    </div>
    <script type="text/javascript">
        moment.lang('<?php echo Yii::app()->language; ?>');
        chart.setMonthNames(['<?php echo Yii::t('calendar', 'Jan'); ?>', '<?php echo Yii::t('calendar', 'Feb'); ?>', '<?php echo Yii::t('calendar', 'Mar'); ?>', '<?php echo Yii::t('calendar', 'Apr'); ?>', '<?php echo Yii::t('calendar', 'May'); ?>', '<?php echo Yii::t('calendar', 'Jun'); ?>', '<?php echo Yii::t('calendar', 'Jul'); ?>', '<?php echo Yii::t('calendar', 'Aug'); ?>', '<?php echo Yii::t('calendar', 'Sep'); ?>', '<?php echo Yii::t('calendar', 'Oct'); ?>', '<?php echo Yii::t('calendar', 'Nov'); ?>', '<?php echo Yii::t('calendar', 'Dec'); ?>']);
        var lastAnswerId = null;
        //Update every 5 minutes
        setInterval(filter.refresh, 5 * 60 * 1000);

        filter.setFilterChanged(function() {
            dataLoader.abort();
            $('#nps .metric-value').html('');
            $('#interest .metric-value').html('');
            $('#success .metric-value').html('');
            $('#sentiment .metric-value').html('');
            $('#n-number').html('');
            $('#nps .metric-chart').html('');
            $('#interest .metric-chart').html('');
            $('#success .metric-chart').html('');
            $('#sentiment .metric-chart').html('');
            $('#answers').html('');
            $('#age .metric-pie-chart').html('');
            $('#gender .metric-pie-chart').html('');
            $('#topic .metric-bar-chart').html('');
            var loadData = function loadData() {
                dataLoader.loadData(
                        {
                            url: '<?php echo $this->createUrl('api/metrics') ?>',
                            compareMode: $('#compare').val(),
                            serieOptions: {},
                            requestParameters: {
                            },
                            currentComplete: function(data, options) {
                                $('#nps .metric-value').html(data.nps.average);
                                $('#interest .metric-value').html(data.interest.average);
                                $('#success .metric-value').html(data.success.average + ' %');
                                $('#sentiment .metric-value').html(data.sentiment.average);
                                $('#n-number').html(data.n.count);

                                var nps = [];
                                $.each(data.nps.history, function(index, item) {
                                    nps.push([moment(item.time).valueOf(), item.count]);
                                });
                                chart.timeSeries('#nps .metric-chart', [nps], {
                                    yaxis: {
                                        min: -100,
                                        max: 100
                                    }
                                });

                                var interest = [];
                                $.each(data.interest.history, function(index, item) {
                                    interest.push([moment(item.time).valueOf(), item.count]);
                                });
                                chart.timeSeries('#interest .metric-chart', [interest], {
                                    yaxis: {
                                        min: 0,
                                        max: 6
                                    }
                                });

                                var success = [];
                                $.each(data.success.history, function(index, item) {
                                    success.push([moment(item.time).valueOf(), item.count]);
                                });
                                chart.timeSeries('#success .metric-chart', [success], {
                                    yaxis: {
                                        min: 0,
                                        max: 100
                                    }
                                });

                                var sentiment = [];
                                $.each(data.sentiment.history, function(index, item) {
                                    sentiment.push([moment(item.time).valueOf(), item.count]);
                                });
                                chart.timeSeries('#sentiment .metric-chart', [sentiment], {
                                    yaxis: {
                                        min: -1,
                                        max: 1
                                    }
                                });

                                var age = [];
                                var ageColors = {
                                    '0-14': '#43601c',
                                    '15-29': '#6d8616',
                                    '30-44': '#92960f',
                                    '45-59': '#b1a12f',
                                    '60-74': '#868153',
                                    '75+': '#717059'
                                };
                                $.each(data.age, function(index, item) {
                                    age.push({
                                        label: index,
                                        color: ageColors[index],
                                        data: item.total
                                    });
                                });
                                age.reverse();
                                chart.pie('#age .metric-pie-chart', age, {
                                });

                                var gender = [];
                                var genderStrings = {
                                    male: '<?php echo Yii::t('report', 'male'); ?>',
                                    female: '<?php echo Yii::t('report', 'female'); ?>'
                                };
                                var genderColors = {
                                    male: '#3399cc',
                                    female: '#ad4bad'
                                };
                                $.each(data.gender, function(index, item) {
                                    gender.push({
                                        label: genderStrings[index],
                                        color: genderColors[index],
                                        data: item.total
                                    });
                                });
                                chart.pie('#gender .metric-pie-chart', gender, {
                                });

                            }
                        });

                dataLoader.loadData({
                    url: '<?php echo $this->createUrl('api/answers') ?>',
                    compareMode: $('#compare').val(),
                    serieOptions: {},
                    requestParameters: {
                    },
                    currentComplete: function(data, options) {
                        var answers = $('.answers').data('masonry');
                        if (answers) {
                            answers.destroy();
                        }
                        $('.answers').html('');
                        var answers = renderAnswers(data);
                        $('.answers').append(answers);
                        $('.answers').masonry({
                            itemSelector: '.answer'
                        });
                    }
                });

                dataLoader.loadData({
                    url: '<?php echo $this->createUrl('api/topics') ?>',
                    compareMode: $('#compare').val(),
                    serieOptions: {},
                    requestParameters: {
                    },
                    currentComplete: function(data, options) {
                        data.reverse();
                        var sentimentStrings = ['positive', 'neutral', 'negative'];
                        var localizedSentimentStrings = [
                            '<?php echo Yii::t('report', 'positive'); ?>',
                            '<?php echo Yii::t('report', 'neutral'); ?>',
                            '<?php echo Yii::t('report', 'negative'); ?>'
                        ];
                        var sentiments = [];
                        var sentimentColors = {
                            positive: '#5c9eda',
                            neutral: '#bfbfbf',
                            negative: '#be4b50'
                        };
                        $.each(sentimentStrings, function(index, sentiment) {
                            var topics = [];
                            $.each(data, function(index, item) {
                                topics.push([
                                    item[sentiment],
                                    index
                                ]);
                            });
                            sentiments.push({
                                data: topics,
                                color: sentimentColors[sentiment]
                            });
                        });

                        var ticks = [];
                        $.each(data, function(index, topic) {
                            ticks.push([
                                index,
                                topic.topic
                            ]);
                        });

                        chart.bar('#topic .metric-bar-chart', sentiments, {
                            yaxis: {
                                ticks: ticks
                            }
                        }, function(item) {
                            return localizedSentimentStrings[item.seriesIndex] + " : " + item.datapoint[0];
                        });
                    }
                });
            };

            loadData();
            renderTimePeriod();

            $(window).scroll(function() {
                if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
                    dataLoader.loadData({
                        url: '<?php echo $this->createUrl('api/answers') ?>',
                        compareMode: $('#compare').val(),
                        serieOptions: {},
                        requestParameters: {
                            fromId: lastAnswerId,
                        },
                        currentComplete: function(data, options) {
                            var answers = renderAnswers(data);
                            $('.answers').masonry().append(answers).masonry('reloadItems');
                            $('.answers').masonry().masonry('reloadItems');
                        }
                    });
                }
            });

            moment.lang('fi', {
                relativeTime: {
                    future: "%s päästä",
                    past: "%s sitten",
                    s: "sekuntia",
                    m: "minuutti",
                    mm: "%d minuuttia",
                    h: "tunti",
                    hh: "%d tuntia",
                    d: " päivä",
                    dd: "%d päivää",
                    M: "kuukausi",
                    MM: "%d kk",
                    y: "vuosi",
                    yy: "%d vuotta"
                }
            });
            function renderAnswers(data) {
                var answerTemplate = _.template('<?php echo preg_replace("/\r|\n/", "", $this->renderPartial('_answer', null, true)); ?>');
                var genderStrings = {
                    male: '<?php echo Yii::t('report', 'male'); ?>',
                    female: '<?php echo Yii::t('report', 'female'); ?>'
                };
                var NPSStrings = {
                    promoter: '<?php echo Yii::t('report', 'promoter'); ?>',
                    passive: '<?php echo Yii::t('report', 'passive'); ?>',
                    detractor: '<?php echo Yii::t('report', 'detractor'); ?>'
                };

                var answers = [];
                $.each(data, function(index, element) {
                    if (element.id < lastAnswerId || lastAnswerId == null) {
                        element.localizedGender = genderStrings[element.gender];
                        element.timeago = moment(element.timestamp).fromNow();
                        element.localizedNPSGroup = NPSStrings[element.group];
                        element.sentimentClass = getSentimentClass(element.sentiment);
                        element.ageClass = getAgeClass(element.age);
                        element.recommendColor = getRecommendColor(element.group);
                        element.interestColor = getInterestColor(element.interest);
                        answers.push(answerTemplate(element));
                    }
                });
                if (data.length) {
                    lastAnswerId = data.pop().id;
                }
                return answers;

                function getSentimentClass(sentiment) {
                    if (sentiment < 0) {
                        return 'negative';
                    }
                    else if (sentiment > 0) {
                        return 'positive';
                    }
                }

                function getAgeClass(age) {
                    if (age < 15) {
                        return 'age1';
                    }
                    else if (age < 30) {
                        return 'age2';
                    }
                    else if (age < 45) {
                        return 'age3';
                    }
                    else if (age < 60) {
                        return 'age4';
                    }
                    else if (age < 75) {
                        return 'age5';
                    }
                    else {
                        return 'age6';
                    }
                }

                function getRecommendColor(group) {
                    if (group === 'detractor') {
                        return 'low';
                    }
                    else if (group === 'neutral') {
                        return 'medium';
                    }
                    else if (group === 'promoter') {
                        return 'high';
                    }
                }

                function getInterestColor(interest) {
                    if (interest <= 2) {
                        return 'low';
                    }
                    else if (interest <= 4) {
                        return 'medium';
                    }
                    else {
                        return 'high';
                    }
                }
            }

            function renderTimePeriod() {
                var timePeriod = '';

                var mode = $('#mode').val();
                if (mode === 'week') {
                    timePeriod += 'Viikko ' + getWeekNumber(filter.current().from) + ' ';
                }
                timePeriod += moment.utc(filter.current().from).format('DD.MM.YYYY') + ' - ' + moment.utc(filter.current().to).format('DD.MM.YYYY') + ' (' + getPeriodLength(filter.current().from, filter.current().to) + ' päivää)';

                var comparePeriod = '';
                if (filter.previous().from) {
                    comparePeriod = ' Vertailujakso ' + moment.utc(filter.current().from).format('DD.MM.YYYY') + ' - ' + moment.utc(filter.current().to).format('DD.MM.YYYY') + ' (' + getPeriodLength(filter.current().from, filter.current().to) + ' päivää)';
                }
                $('#time-period').html(timePeriod);
                $('#compare-period').html(comparePeriod);
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
                var weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
                // Return array of year and week number
                return weekNo;
            }

            function getPeriodLength(from, to) {
                return Math.round((filter.current().to - filter.current().from) / 1000 / 60 / 60 / 24);
            }
        });
    </script>

    <div id="tooltip"></div>