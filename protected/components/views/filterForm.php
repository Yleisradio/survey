<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'filter-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="row">
    <div class="col-xs-4">
        <a href="" id="year-button" class="time-button"><?php echo Yii::t('report', 'year'); ?></a>
    </div>
    <div class="col-xs-4">
        <a href="" id="month-button" class="time-button"><?php echo Yii::t('report', 'month'); ?></a>
    </div>
    <div class="col-xs-4">
        <a href="" id="week-button" class="time-button"><?php echo Yii::t('report', 'week'); ?></a>
    </div>
</div>
<div class="row border-bottom">
    <div class="col-xs-6">
        <a href="#" id="previous-button"  class="button">
            <?php echo Yii::t('report', 'previous'); ?>
            <i class="fa fa-chevron-left button-chevron-left"></i>
        </a>
    </div>
    <div class="col-xs-6">
        <a href="#" id="next-button"  class="button">
            <?php echo Yii::t('report', 'next'); ?>
            <i class="fa fa-chevron-right button-chevron-right"></i>
        </a>
    </div>
</div>
<?php echo $form->checkBoxList($filter, 'surveys', array('surveys_all' => Yii::t('report', 'filter.select all')) + CHtml::listData(Survey::model()->findAll(), 'category', 'name'), array('name' => 'surveys')); ?>
<?php
echo $form->hiddenField($filter, 'from', array('name' => 'from'));
echo $form->hiddenField($filter, 'to', array('name' => 'to'));
echo $form->hiddenField($filter, 'mode', array('name' => 'mode'));
?>
<input type="hidden" id="compare" name="compare" value="none" />

<?php $this->endWidget(); ?>
