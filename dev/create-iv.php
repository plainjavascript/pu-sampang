<?php
$ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);

file_put_contents('code.txt', $iv);
?>