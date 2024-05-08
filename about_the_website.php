<?php

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

echo $twig->render('about_the_website.twig');
