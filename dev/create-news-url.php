<?php
$n = 1;
$total = 9;
for ( ; $n <= $total; $n++ ) {
	$title = file_get_contents('../db/news/' . $n . '/title.txt');
	$url = strtolower($title);
	$url = str_replace(' ', '-', $url);
	
	file_put_contents('../db/news/' . $n . '/url.txt', $url);
}
?>