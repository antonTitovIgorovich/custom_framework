<?php
/** @var \Framework\Template\PhpRenderer $this */
$this->params['title'] = 'About';
$this->extend('layout/columns');
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li class="active">About</li>
</ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('sidebar'); ?>
<div class="panel panel-default">
    <div class="panel-heading">About</div>
    <div class="panel-body">About Navigation</div>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('content'); ?>
<h1>About the site</h1>
<?php $this->endBlock(); ?>