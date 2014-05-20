<script type="text/javascript">
$(document).on('submit', '#survey-form', function() {
    $('#form-submit-button').attr('disabled', 'disabled');
    $('#form-submit-button').attr('value', '<?php echo Yii::t('form', 'submitting') ?>');
    return true;
});
</script>
<div class="container">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'survey-form',
    ));
    ?>
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo Yii::t('form', 'survey.heading', array('{site}' => $survey->name)); ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 question-box">
            <h2><?php echo Yii::t('form', 'survey.motive.question', array('{site}' => $survey->name)); ?></h2>
            <?php
            echo $form->radioButtonList($answer, 'motive_id', CHtml::listData($survey->motives, 'id', 'motive'));
            ?>
            <div class="row form-horizontal form-group">
                <div class="col-md-12">
                    <input id="Answer_success_other" value="" type="radio" name="Answer[motive_id]"> 
                    <label for="Answer_success_other"><?php echo Yii::t('form', 'survey.success.other'); ?></label>
                </div>
                <div class="col-md-12">
                    <?php echo $form->textField($answer, 'motive_text', array('class' => 'form-control')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 question-box">
            <h2><?php echo Yii::t('form', 'survey.success.question', array('{site}' => $survey->name)); ?></h2>
            <h5><?php echo Yii::t('form', 'survey.success.later'); ?></h5>
            <?php
            echo $form->radioButtonList($answer, 'success', array(
                1 => Yii::t('form', 'yes'),
                0 => Yii::t('form', 'no'),
            ));
            ?>
            <h2><?php echo Yii::t('form', 'survey.failure_text.question', array('{site}' => $survey->name)); ?></h2>
            <?php
            echo $form->textArea($answer, 'failure_text', array('class' => 'form-control'));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 question-box">
            <h2><?php echo Yii::t('form', 'survey.recommend.question', array('{site}' => $survey->name)); ?></h2>
            <?php
            echo $form->radioButtonList($answer, 'recommend', array(
                1 => 1 . ' - ' . Yii::t('form', 'answer.recommend.1'),
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10 . ' - ' . Yii::t('form', 'answer.recommend.10'),
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 question-box">
            <h2><?php echo Yii::t('form', 'survey.interest.question', array('{site}' => $survey->name)); ?></h2>
            <?php
            echo $form->radioButtonList($answer, 'interest', array(
                Yii::t('form', 'answer.interest.6'),
                Yii::t('form', 'answer.interest.5'),
                Yii::t('form', 'answer.interest.4'),
                Yii::t('form', 'answer.interest.3'),
                Yii::t('form', 'answer.interest.2'),
                Yii::t('form', 'answer.interest.1'),
                Yii::t('form', 'answer.interest.0'),
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 question-box">
            <h2><?php echo Yii::t('form', 'survey.feedback.question', array('{site}' => $survey->name)); ?></h2>
            <?php echo $form->textArea($answer, 'feedback', array('class' => 'form-control')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 question-box">
            <h2><?php echo Yii::t('form', 'survey.users.question', array('{site}' => $survey->name)); ?></h2>
            <?php
            echo $form->radioButtonList($answer, 'users', array(
                1,
                2,
                3,
                4 . ' ' . Yii::t('form', 'answer.users.4'),
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <?php echo Yii::t('form', 'survey.notice.user-information'); ?>
    </div>
    <div class="row">
        <div class="col-md-12 question-box">
            <div class="row">
                <div class="col-md-6">
                    <h2><?php echo Yii::t('form', 'survey.gender.question', array('{site}' => $survey->name)); ?></h2>
                    <?php
                    echo $form->dropDownList($answer, 'gender', array(
                        '' => Yii::t('form', 'choose'),
                        'female' => Yii::t('form', 'survey.gender.female'),
                        'male' => Yii::t('form', 'survey.gender.male'),
                            ), array('class' => 'form-control'));
                    ?>
                </div>
                <div class="col-md-6">
                    <h2><?php echo Yii::t('form', 'survey.year_of_birth.question', array('{site}' => $survey->name)); ?></h2>
                    <?php
                    echo $form->dropDownList($answer, 'year_of_birth', $yearsOfBirth, array('class' => 'form-control'));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 submit-box">
            <?php echo CHtml::submitButton(Yii::t('form', 'survey.submit'), array('id' => 'form-submit-button', 'class' => 'btn btn-primary')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php
$this->widget('ComScoreTracking', array(
    'path' => $survey->comscore . "/s?srv",
));
