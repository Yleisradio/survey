<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'survey-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->checkBoxList($filter, 'surveys', CHtml::listData(Survey::model()->findAllByAttributes(array('active' => 1)), 'id', 'name'), array()); ?>

<?php $this->endWidget(); ?>
