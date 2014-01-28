<?php
$this->beginContent('//layouts/base');
?>
<div class="container">
    <div class="col-md-12">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'htmlOptions' => array(
                'class' => 'nav nav-pills',
            ),
            'items' => array(
                array('label' => '', 'url' => array('')),
                array('label' => '', 'url' => array('')),
            ),
        ));
        ?>
    </div>
    <?php echo $content; ?>
</div>

<?php
$this->endContent();
