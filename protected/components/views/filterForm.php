<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'filter-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="row">
    <div class="col-sm-6">
        <a id="previous-button" class="btn btn-default"><?php echo Yii::t('report', 'previous'); ?></a>
    </div>
    <div class="col-sm-6">
        <a id="next-button" class="btn btn-default"><?php echo Yii::t('report', 'next'); ?></a>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <a id="year-button" class="btn btn-default"><?php echo Yii::t('report', 'year'); ?></a>
    </div>
    <div class="col-sm-4">
        <a id="month-button" class="btn btn-default"><?php echo Yii::t('report', 'month'); ?></a>
    </div>
    <div class="col-sm-4">
        <a id="week-button" class="btn btn-default"><?php echo Yii::t('report', 'week'); ?></a>
    </div>
</div>
<div class="row">
    <div>
        <?php echo $form->dropDownList($filter, 'compare', Filter::getCompares(), array('name' => 'compare', 'id' => 'compare', 'class' => 'form-control')); ?>
    </div>
</div>
<?php echo $form->checkBoxList($filter, 'surveys', CHtml::listData(Survey::model()->findAllByAttributes(array('active' => 1)), 'category', 'name'), array('name' => 'surveys')); ?>
<?php
echo $form->hiddenField($filter, 'from', array('name' => 'from'));
echo $form->hiddenField($filter, 'to', array('name' => 'to'));
echo $form->hiddenField($filter, 'mode', array('name' => 'mode'));
?>
<?php $this->endWidget(); ?>
