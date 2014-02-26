<?php
/* @var $this SurveyController */
/* @var $model Survey */
?>
<div class="row">
    <div class="col-sm-12">
        <h1><?php echo Yii::t('admin', 'motive.index.heading') ?></h1>

        <a href="<?php echo $this->createUrl('create') ?>" class="new-button btn btn-primary"><?php echo Yii::t('admin', 'motive.create') ?></a>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'htmlOptions' => array(
                'class' => 'table-responsive bordered'
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
                    'name' => 'motive',
                    'type' => 'raw',
                    'value' => 'CHtml::link($data["motive"], array("update", "id" => $data["id"]))',
                ),
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
        ?>
    </div>
</div>