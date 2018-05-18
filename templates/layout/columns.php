<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */
    $this->extend('layout/default');
?>

<?php $this->beginBlock('main')?>
<div class="row">
    <div class="col-md-9">
        <?= $this->renderBlock('content') ?>
    </div>
    <div class="col-md-3">
        <?php $this->block('sidebar', function (){ ob_start();?>
            <div class="panel panel-default">
                <div class="panel-heading">Column</div>
                <div class="panel-body">Column Navigation</div>
            </div>
        <?php return ob_get_clean(); });?>
        <?= $this->renderBlock('sidebar') ?>
    </div>
</div>
<?php $this->endBlock(); ?>