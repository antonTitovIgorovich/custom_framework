<?php
/** @var \Framework\Template\PhpRenderer $this */
$this->params['title'] = 'Cabinet';
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
    <div class="panel-heading">Cabinet</div>
    <div class="panel-body">Cabinet Navigation</div>
</div>
<?php $this->endBlock(); ?>

<h1>Cabinet of <?= htmlspecialchars($name) ?></h1>