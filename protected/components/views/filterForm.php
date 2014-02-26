<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'filter-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="row">
    <div class="col-sm-4">
        <a href="" id="year-button" class="time-button"><?php echo Yii::t('report', 'year'); ?></a>
    </div>
    <div class="col-sm-4">
        <a href="" id="month-button" class="time-button"><?php echo Yii::t('report', 'month'); ?></a>
    </div>
    <div class="col-sm-4">
        <a href="" id="week-button" class="time-button"><?php echo Yii::t('report', 'week'); ?></a>
    </div>
</div>
<div class="row border-bottom">
    <div class="col-sm-6">
        <div class="button">
            <i class="fa fa-chevron-left button-chevron-left"></i>
            <a href="" id="previous-button" ><?php echo Yii::t('report', 'previous'); ?></a>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="button">
            <a href="" id="next-button" ><?php echo Yii::t('report', 'next'); ?></a>
            <i class="fa fa-chevron-right button-chevron-right"></i>
        </div>
    </div>
</div>
<?php echo $form->checkBoxList($filter, 'surveys', CHtml::listData(Survey::model()->findAllByAttributes(array('active' => 1)), 'category', 'name'), array('name' => 'surveys', 'checkAll' => Yii::t('report', 'filter.select all'))); ?>
<?php
echo $form->hiddenField($filter, 'from', array('name' => 'from'));
echo $form->hiddenField($filter, 'to', array('name' => 'to'));
echo $form->hiddenField($filter, 'mode', array('name' => 'mode'));
?>
<input type="hidden" id="compare" name="compare" value="none" />

<?php $this->endWidget(); ?>
