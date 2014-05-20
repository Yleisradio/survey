<?php
/* @var $this SurveyController */
/* @var $model Survey */
/* @var $form CActiveForm */
?>

<div class="form-horizontal">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'survey-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t('admin', 'survey.name.tooltip') ?>">
        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'name', array('maxlength' => 32, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
    </div>

    <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t('admin', 'survey.url.tooltip') ?>">
        <?php echo $form->labelEx($model, 'url', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'url', array('maxlength' => 128, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'url'); ?>
        </div>
    </div>

    <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t('admin', 'survey.category.tooltip') ?>">
        <?php echo $form->labelEx($model, 'category', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'category', array('maxlength' => 32, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'category'); ?>
        </div>
    </div>

    <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t('admin', 'survey.frequency.tooltip') ?>">
        <?php echo $form->labelEx($model, 'frequency', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'frequency', array('maxlength' => 3, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'frequency'); ?>
        </div>
    </div>

        <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t('admin', 'survey.comscore.tooltip') ?>">
        <?php echo $form->labelEx($model, 'comscore', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'comscore', array('maxlength' => 32, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'comscore'); ?>
        </div>
    </div>

    <div class="form-group"  data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t('admin', 'survey.language.tooltip') ?>">
        <?php echo $form->labelEx($model, 'language', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->dropDownList($model, 'language', Survey::getLanguages(), array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'language'); ?>
        </div>
    </div>

    <div class="form-group"> 
        <?php echo $form->labelEx($model, 'motives', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->checkBoxList($model, 'motiveIds', CHtml::listData(Motive::getMotives($model->language), 'id', 'motive'), array()); ?>
            <?php echo $form->error($model, 'motives'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <?php echo CHtml::submitButton(Yii::t('admin', 'save'), array('class' => 'btn btn-primary')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->