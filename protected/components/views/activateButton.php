<form class="form-horizontal" method="post" action="<?php echo Yii::app()->createUrl('/survey/activate') ?>">
    <input name="active" type="hidden" value="<?php echo ($survey['active'] + 1) % 2; ?>" />
    <input name="id" type="hidden" value="<?php echo $survey['id']; ?>" />
    <?php
    if ($survey['active']) {
        echo CHtml::submitButton(Yii::t('admin', 'survey.active.on'), array('class' => 'btn btn-success'));
    } else {
        echo CHtml::submitButton(Yii::t('admin', 'survey.active.off'), array('class' => 'btn btn-warning'));
    }
    ?>
</form>