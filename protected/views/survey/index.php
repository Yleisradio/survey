<?php
/* @var $this SurveyController */
/* @var $model Survey */
?>

<h1><?php echo Yii::t('admin', 'survey.index.heading') ?></h1>

<a href="<?php echo $this->createUrl('create') ?>" class="btn btn-primary"><?php echo Yii::t('admin', 'survey.create') ?></a>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'htmlOptions' => array(
        'class' => 'bordered'
    ),
    'cssFile' => false,
    'itemsCssClass' => 'table table-striped table-condensed',
    'id' => 'survey-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'buttons' => array(
                'update' => array(
                    'imageUrl' => false,
                    'label' => Yii::t('admin', 'update'),
                    'options' => array(
                        'class' => 'btn btn-primary',
                    ),
                ),
            ),
        ),
        array(
            'type' => 'raw',
            'value' => function($data) { return $this->widget('ActivateButton', array('survey' => $data))->content; },
        ),
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data["name"], array("update", "id" => $data["id"]))',
        ),
        'url',
        'category',
        'frequency',
        'comscore',
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'imageUrl' => false,
                    'label' => Yii::t('admin', 'delete'),
                    'options' => array(
                        'class' => 'btn btn-danger',
                    ),
                ),
            ),
        ),
    ),
));