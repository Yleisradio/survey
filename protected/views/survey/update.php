<?php
/* @var $this SurveyController */
/* @var $model Survey */
?>

<h1><?php echo Yii::t('admin', 'survey.update.heading'); ?></h1>

<div class="form-horizontal">
    <div class="form-group">
        <div class="col-sm-2 control-label">
            <?php echo Yii::t('admin', 'survey.active'); ?>
        </div>
    </div>
</div>
<?php
$this->renderPartial('_form', array('model' => $model));

