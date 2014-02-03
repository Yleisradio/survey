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

    <div class="form-group">
        <?php echo $form->labelEx($model, 'motive', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'motive', array('maxlength' => 32, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'motive'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <?php echo CHtml::submitButton(Yii::t('admin', 'save'), array('class' => 'btn btn-primary')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->