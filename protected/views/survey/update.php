<?php
/* @var $this SurveyController */
/* @var $model Survey */
?>

<h1><?php echo Yii::t('admin', 'survey.update.heading'); ?></h1>

<?php
$this->renderPartial('_form', array('model' => $model));

