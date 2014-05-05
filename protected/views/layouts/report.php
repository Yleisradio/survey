<?php
$this->beginContent('//layouts/base');
echo $this->getHeader();
?>
<div class="container">
    <?php echo $content; ?>
</div>
<?php
$this->endContent();