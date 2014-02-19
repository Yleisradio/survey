<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="form-horizontal">
                <?php
                $this->widget('FilterForm', array(
                ));
                ?> 
            </div>
        </div>
        <div class="col-md-9">
            <div class="date-display">
                <div id="time-period"></div>
                <div id="compare-period"></div> 
                <div><?php echo Yii::t('report', 'number of answers'); ?>: <span id="n-number"></span></div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="col-md-3" id="nps">
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
            <div class="row">
                <div class="col-md-3" id="age">
                    <div class="metric-label"><?php echo Yii::t('report', 'age') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-pie-chart"></div>
                </div>
                <div class="col-md-3" id="gender">
                    <div class="metric-label"><?php echo Yii::t('report', 'gender') ?></div>
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


        filter.setFilterChanged(function() {
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
                                $('#success .metric-value').html(data.success.average);
                                $('#sentiment .metric-value').html(data.sentiment.average);
                                $('#n-number').html(data.n.count);

                                var nps = [];
                                $.each(data.nps.history, function(index, item) {
                                    nps.push([moment(item.time).valueOf(), item.count]);
                                });
                                chart.timeSeries('#nps .metric-chart', [nps], {
                                    yaxis: {
                                        min: -100,
                                        max: 100,
                                    }
                                });

                                var interest = [];
                                $.each(data.interest.history, function(index, item) {
                                    interest.push([moment(item.time).valueOf(), item.count]);
                                })
                                chart.timeSeries('#interest .metric-chart', [interest], {
                                    yaxis: {
                                        min: 0,
                                        max: 6,
                                    }
                                });

                                var success = [];
                                $.each(data.success.history, function(index, item) {
                                    success.push([moment(item.time).valueOf(), item.count]);
                                })
                                chart.timeSeries('#success .metric-chart', [success], {
                                    yaxis: {
                                        min: 0,
                                        max: 100,
                                    }
                                });

                                var sentiment = [];
                                $.each(data.sentiment.history, function(index, item) {
                                    sentiment.push([moment(item.time).valueOf(), item.count]);
                                })
                                chart.timeSeries('#sentiment .metric-chart', [sentiment], {
                                    yaxis: {
                                        min: -1,
                                        max: 1,
                                    }
                                });

                                var age = [];
                                $.each(data.age, function(index, item) {
                                    age.push({
                                        label: index,
                                        data: item.total
                                    });
                                })
                                age.reverse();
                                chart.pie('#age .metric-pie-chart', age, {
                                });

                                var gender = [];
                                var genderStrings = {
                                    male: '<?php echo Yii::t('report', 'male'); ?>',
                                    female: '<?php echo Yii::t('report', 'female'); ?>'
                                };
                                $.each(data.gender, function(index, item) {
                                    gender.push({
                                        label: genderStrings[index],
                                        data: item.total
                                    });
                                })
                                chart.pie('#gender .metric-pie-chart', gender, {
                                });

                            },
                        });

                var answerTemplate = _.template('<?php $this->renderPartial('_answer'); ?>');

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
                        var genderStrings = {
                            male: '<?php echo Yii::t('report', 'male'); ?>',
                            female: '<?php echo Yii::t('report', 'female'); ?>'
                        };
                        var NPSStrings = {
                            promoter: '<?php echo Yii::t('report', 'promoter'); ?>',
                            passive: '<?php echo Yii::t('report', 'passive'); ?>',
                            detractor: '<?php echo Yii::t('report', 'detractor'); ?>'
                        }
                        $.each(data, function(index, element) {
                            element.localizedGender = genderStrings[element.gender];
                            element.timeago = moment(element.timestamp).fromNow();
                            element.localizedNPSGroup = NPSStrings[element.group];
                            $('.answers').append(answerTemplate(element));
                        });
                        $('.answers').masonry({
                            itemSelector: '.answer'
                        });
                    },
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
                            '<?php echo Yii::t('report', 'negative'); ?>',
                        ];
                        var sentiments = [];
                        $.each(sentimentStrings, function(index, sentiment) {
                            var topics = [];
                            $.each(data, function(index, item) {
                                topics.push([
                                    item[sentiment],
                                    index
                                ]);
                            });
                            sentiments.push(topics);
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
                                ticks: ticks,
                            }
                        }, function(item) {
                            return localizedSentimentStrings[item.seriesIndex] + " : " + item.datapoint[1];
                        });
                    }
                });
            }

            loadData();
            renderTimePeriod();

            function renderTimePeriod() {
                var timePeriod = '';

                var mode = $('#mode').val();
                if (mode == 'week') {
                    timePeriod += 'Viikko ' + getWeekNumber(filter.current().from) + ' ';
                }

                timePeriod += moment(filter.current().from).format('DD.MM.YYYY') + ' - ' + moment(filter.current().to).format('DD.MM.YYYY') + ' (' + getPeriodLength(filter.current().from, filter.current().to) + ' päivää)';

                var comparePeriod = '';
                if (filter.previous().from) {
                    comparePeriod = ' Vertailujakso ' + moment(filter.current().from).format('DD.MM.YYYY') + ' - ' + moment(filter.current().to).format('DD.MM.YYYY') + ' (' + getPeriodLength(filter.current().from, filter.current().to) + ' päivää)';
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
                var weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7)
                // Return array of year and week number
                return weekNo;
            }

            function getPeriodLength(from, to) {
                return Math.round((filter.current().to - filter.current().from) / 1000 / 60 / 60 / 24);
            }
        });
    </script>

    <div id="tooltip"></div>