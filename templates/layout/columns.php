<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */
    $this->extend('layout/default');
?>

<?php $this->beginBlock('mainContent')?>
<div class="row">
    <div class="col-md-9">
        <?= $this->renderBlock('content') ?>
    </div>
    <div class="col-md-3">
        <?= $this->renderBlock('sidebar') ?>
    </div>
</div>
<?php $this->endBlock(); ?>