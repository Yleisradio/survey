<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo Yii::t('form', 'thanks'); ?></h1>
        </div>
    </div>
</div>

<?php
$this->widget('ComScoreTracking', array(
    'path' => $answer->survey->comscore . "/s?srv." . strtolower($answer->survey->name) . ".a&yle_t=" . $answer->success . "&yle_n=" . $answer->recommend . "&yle_i=" . $answer->interest . "&yle_b=" . $answer->year_of_birth . "&yle_m=" . $answer->motive_id . "&yle_u=" . $answer->users . "&yle_s=" . $answer->gender,
));