<?php
$this->beginContent('//layouts/base');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array(
                    'class' => 'nav nav-pills',
                ),
                'items' => array(
                    array('label' => Yii::t('admin', 'surveys'), 'url' => array('survey/index')),
                    array('label' => Yii::t('admin', 'motives'), 'url' => array('motive/index')),
                ),
            ));
            ?>
        </div>
    </div>
    <?php echo $content; ?>
</div>

<?php
$this->endContent();
