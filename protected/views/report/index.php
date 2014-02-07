<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="form-horizontal">
                <?php
                $this->widget('FilterForm', array(
                    'filter' => new Filter(),
                ));
                ?> 
            </div>
        </div>
        <div class="col-md-9">
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
            </div>
            <div class="row">
                <div class="col-md-3" id="age">
                    <div class="metric-label"><?php echo Yii::t('report', 'age') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-chart"></div>
                </div>
                <div class="col-md-3" id="gender">
                    <div class="metric-label"><?php echo Yii::t('report', 'gender') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-chart"></div>
                </div>
                <div class="col-md-3" id="topic">
                    <div class="metric-label"><?php echo Yii::t('report', 'topics') ?></div>
                    <div class="metric-value"></div>
                    <div class="metric-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        moment.lang('<?php echo Yii::app()->language; ?>');
        
        var from = '2014-01-01T00:00:00.000Z';
        var to = '2014-02-07T23:59:59.000Z';

        $.ajax({
            dataType: "json",
            url: '<?php echo $this->createUrl('/api/metrics') ?>',
            data: {
                sites: 'test,areena',
                from: from,
                to: to,
                interval: 'day',
            },
            success: function(result) {
                $('#nps .metric-value').html(result.nps.average);
                $('#interest .metric-value').html(result.interest.average);
                $('#success .metric-value').html(result.success.average);

                function getPlotSettings(settings) {
                    return $.extend({}, {
                        xaxis: {
                            mode: "time",
                            min: moment(from).valueOf(),
                            max: moment(to).valueOf(),
                            tickFormatter: function(value) { return moment(value).format("D.M") },
                            monthNames: ['<?php echo Yii::t('calendar', 'Jan'); ?>', '<?php echo Yii::t('calendar', 'Feb'); ?>', '<?php echo Yii::t('calendar', 'Mar'); ?>', '<?php echo Yii::t('calendar', 'Apr'); ?>', '<?php echo Yii::t('calendar', 'May'); ?>', '<?php echo Yii::t('calendar', 'Jun'); ?>', '<?php echo Yii::t('calendar', 'Jul'); ?>', '<?php echo Yii::t('calendar', 'Aug'); ?>', '<?php echo Yii::t('calendar', 'Sep'); ?>', '<?php echo Yii::t('calendar', 'Oct'); ?>', '<?php echo Yii::t('calendar', 'Nov'); ?>', '<?php echo Yii::t('calendar', 'Dec'); ?>'],
                        },
                        grid: {
                            hoverable: true,
                            borderWidth: 0,
                        },
                        }, settings);
                }

                var nps = [];
                $.each(result.nps.history, function(index, item) {
                    nps.push([moment(item.time).valueOf(), item.count]);
                })
                $.plot('#nps .metric-chart', [nps], getPlotSettings({
                    yaxis: {
                        min: -100,
                        max: 100,
                    }
                }));

                var interest = [];
                $.each(result.interest.history, function(index, item) {
                    interest.push([moment(item.time).valueOf(), item.count]);
                })
                $.plot('#interest .metric-chart', [interest], getPlotSettings({
                    yaxis: {
                        min: 0,
                        max: 10,
                    }
                }));

                var success = [];
                $.each(result.success.history, function(index, item) {
                    success.push([moment(item.time).valueOf(), item.count]);
                })
                $.plot('#success .metric-chart', [success], getPlotSettings({
                    yaxis: {
                        min: 0,
                        max: 100,
                    }
                }));

            }
        });

        $("<div id='tooltip'></div>").css({
            position: "absolute",
            display: "none",
            border: "1px solid #fdd",
            padding: "2px",
            "background-color": "#fee",
            opacity: 0.80
        }).appendTo("body");

        $(".metric-chart").bind("plothover", function(event, pos, item) {
            if (item) {
                var x = item.datapoint[0],
                        y = item.datapoint[1].toFixed(2);
                $("#tooltip").html(moment(x).format("D.M.YYYY") + " : " + y)
                        .css({top: item.pageY + 5, left: item.pageX + 5})
                        .fadeIn(200);
            } else {
                $("#tooltip").hide();
            }

        });

    </script>