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
<div class="row border-bottom">
    <?php echo $form->checkBoxList($filter, 'surveys', array('surveys_all' => Yii::t('report', 'filter.select all')) + CHtml::listData(Survey::model()->findAll(), 'category', 'name'), array('name' => 'surveys')); ?>
    <?php
    echo $form->hiddenField($filter, 'from', array('name' => 'from'));
    echo $form->hiddenField($filter, 'to', array('name' => 'to'));
    echo $form->hiddenField($filter, 'mode', array('name' => 'mode'));
    ?>
</div>
<div class="row">
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo $form->dropDownList($filter, 'gender', array('gender_all' => Yii::t('report', 'gender')) + Filter::getGenders(), array('name' => 'gender', 'class' => 'form-control')); ?>
        </div>
        <div class="col-xs-6">
            <?php echo $form->dropDownList($filter, 'age', array('age_all' => Yii::t('report', 'age')) + Filter::getAges(), array('name' => 'age', 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <label for="recommend-min"><?php echo Yii::t('report', 'recommend') ?></label>
        </div>
        <div class="col-xs-5">
            <?php echo $form->dropDownList($filter, 'recommend_min', array('recommend_all' => Yii::t('report', 'min')) + array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10), array('id' => 'recommend-min', 'name' => 'recommend_min', 'class' => 'form-control')); ?>
        </div>
        <div class="col-xs-2 min-max-separator">
            -
        </div>
        <div class="col-xs-5">
            <?php echo $form->dropDownList($filter, 'recommend_min', array('recommend_all' => Yii::t('report', 'max')) + array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10), array('id' => 'recommend-max', 'name' => 'recommend_max', 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <label for="interest-min"><?php echo Yii::t('report', 'interest') ?></label>
        </div>
        <div class="col-xs-5">
            <?php echo $form->dropDownList($filter, 'interest_min', array('interest_all' => Yii::t('report', 'min')) + array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6), array('id' => 'interest-min', 'name' => 'interest_min', 'class' => 'form-control')); ?>
        </div>
        <div class="col-xs-2 min-max-separator">
            -
        </div>
        <div class="col-xs-5">
            <?php echo $form->dropDownList($filter, 'interest_max', array('interest_all' => Yii::t('report', 'max')) + array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6), array('id' => 'interest-max', 'name' => 'interest_max', 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <label for="text-only">
                <?php echo $form->checkBox($filter, 'text_only', array('id' => 'text-only', 'name' => 'text_only')); ?>
                <?php echo Yii::t('report', 'text only') ?>
            </label>
        </div>
        <div class="col-xs-12">
            <label for="failed-only">
                <?php echo $form->checkBox($filter, 'failed_only', array('id' => 'failed-only', 'name' => 'failed_only')); ?>
                <?php echo Yii::t('report', 'failed only') ?>
            </label>
        </div>
    </div>
</div>
<input type="hidden" id="compare" name="compare" value="none" />
<?php $this->endWidget(); ?>
