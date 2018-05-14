<?php

$container = new Framework\Container\Container(require __DIR__ . '/dependencies.php');

$container->set('config', require 'config/parameters.php');

return $container;