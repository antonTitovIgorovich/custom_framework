<?php
    /** @var \Framework\Template\PhpRenderer $this */
    $this->extend('layout/default');
?>

<?php $this->beginBlock('title'); ?>Hello<?php $this->endBlock(); ?>

<?php $this->beginBlock('main'); ?>
<div class="jumbotron">
    <h1>Hello <?= $this->encode($name); ?>!</h1>
    <p>
        Congratulations! You have successfully created your application.
    </p>
</div>
<?php $this->endBlock(); ?>
