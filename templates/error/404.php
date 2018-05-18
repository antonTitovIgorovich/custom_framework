<?php
/** @var \Framework\Template\PhpRenderer $this */
$this->extend('layout/default');
?>

<?php $this->beginBlock('title'); ?>404 - Not found<?php $this->endBlock(); ?>
<?php $this->beginBlock('main'); ?>
<ul class="breadcrumb">
    <li><a href="<?= $this->path('home')?>">Home</a></li>
    <li class="active">Error</li>
</ul>
<h1>404 - Not Found</h1>
<?php $this->endBlock(); ?>
