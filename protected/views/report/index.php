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
                <div class="col-md-3" id="NPS">
                    <div class="metric-label">NPS</div>
                    <div class="metric-value"></div>
                    <div class="metric-chart"></div>
                </div>
                <div class="col-md-3">
                    Kiinnostavuus
                </div>
                <div class="col-md-3">
                    Onnistuminen
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    Ikäjakauma
                </div>
                <div class="col-md-3">
                    Sukupuolijakauma
                </div>
                <div class="col-md-3">
                    Puheenaiheet
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $.ajax({
            url: '<?php echo $this->createUrl('/api/metrics') ?>',
            data: {
                sites: 'areena,test',
                from: '2014-01-01T00:00:00.000Z',
                to: '2014-02-02T23:59:59.000Z',
                interval: 'day',
            },
            success: function(result) {
                console.log(result);
            }
        });
    </script>