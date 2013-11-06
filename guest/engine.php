<?php
$template = file_get_contents('guest/' . $page['mode'] . '/template.php');
require 'guest/' . $page['mode'] . '/converter.php';
$Convert = new Convert();
$Convert -> template();
?>