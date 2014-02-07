
<div class="date-display">
    <div class="time-period"></div>
    <div class="compare-period"></div> 
    <div class="current-site"></div>
    <div class='clearfix'></div>
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'filter-form',
    'enableAjaxValidation' => false,
        ));
?>
<div>
    <a id="previous-button" class="btn btn-default"><?php echo Yii::t('report', 'previous'); ?></a>
    <a id="next-button" class="btn btn-default"><?php echo Yii::t('report', 'next'); ?></a>
</div>
<div>
    <a id="year-button" class="btn btn-default"><?php echo Yii::t('report', 'year'); ?></a>
    <a id="month-button" class="btn btn-default"><?php echo Yii::t('report', 'month'); ?></a>
    <a id="week-button" class="btn btn-default"><?php echo Yii::t('report', 'week'); ?></a>

</div>
<div>
    <?php echo $form->dropDownList($filter, 'compare', Filter::getCompares(), array('name' => 'compare', 'id' => 'compare', 'class' => 'form-control')); ?>
</div>
<?php echo $form->checkBoxList($filter, 'surveys', CHtml::listData(Survey::model()->findAllByAttributes(array('active' => 1)), 'id', 'name'), array('name' => 'surveys')); ?>
<?php
echo $form->hiddenField($filter, 'from', array('name' => 'from'));
echo $form->hiddenField($filter, 'to', array('name' => 'to'));
echo $form->hiddenField($filter, 'mode', array('name' => 'mode'));
?>
<?php $this->endWidget(); ?>
