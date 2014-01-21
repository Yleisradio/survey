<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'survey-form',
        ));
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo Yii::t('form', 'survey.heading', array('{site}' => $survey->name)); ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 question-box">
            <h2><?php echo Yii::t('form', 'survey.motive.question', array('{site}' => $survey->name)); ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 question-box">
            <h2><?php echo Yii::t('form', 'survey.success.question', array('{site}' => $survey->name)); ?></h2>
            <?php
            echo $form->radioButtonList($answer, 'success', array(
                Yii::t('form', 'yes'),
                Yii::t('form', 'no'),
            ));
            ?>
            <h2><?php echo Yii::t('form', 'survey.failure_text.question', array('{site}' => $survey->name)); ?></h2>
            <?php
            echo $form->textArea($answer, 'failure_text');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 question-box">
            <h2><?php echo Yii::t('form', 'survey.recommend.question', array('{site}' => $survey->name)); ?></h2>
            <?php
            echo $form->radioButtonList($answer, 'interest', array(
                1 . ' - ' . Yii::t('form', 'answer.recommend.1'),
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10 . ' - ' . Yii::t('form', 'answer.recommend.10'),
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
            <?php echo $form->textArea($answer, 'feedback'); ?>
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
                        'female' => Yii::t('form', 'survey.gender.female'),
                        'male' => Yii::t('form', 'survey.gender.male'),
                    ));
                    ?>
                </div>
                <div class="col-md-6">
                    <h2><?php echo Yii::t('form', 'survey.year_of_birth.question', array('{site}' => $survey->name)); ?></h2>
                    <?php
                    echo $form->dropDownList($answer, 'gender', $dateOfBirthYears);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 submit-box">
            <?php echo CHtml::submitButton(Yii::t('form', 'survey.submit'), array('class' => 'btn btn-primary')); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>