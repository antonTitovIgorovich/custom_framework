<?php

$container = new Framework\Container\Container();

$container->set('config', require 'config/parameters.php');

require 'config/dependencies.php';

return $container;