<?php
    /** @var \Framework\Template\PhpRenderer $this */
    $this->params['title'] = 'Hello';
    $this->extend('layout/default');
?>

<div class="jumbotron">
    <h1>Hello <?= $name; ?>!</h1>
    <p>
        Congratulations! You have successfully created your application.
    </p>
</div>
