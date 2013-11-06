<?php
class Security {
	// hex2bin function by chaos79 taken from http://php.net/manual/en/function.bin2hex.php
	function hexToBin($h) {
		if (!is_string($h)) return null;
		$r = '';
		for ($a = 0; $a < strlen($h); $a += 2) {
			$r .= chr(hexdec($h{$a}.$h{($a + 1)}));
		}
		return $r;
	}
	
	
	function mhashLike($data) {
		$result	= $this -> hexToBin(hash('sha1', $data));
		return $result;
	}
	
	
	function encrypt($key, $data, $vector) {
		$key		= $this -> mhashLike($key);
		$encryption	= mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $vector);
		return $encryption;
	}
	
	
	function decrypt($key, $data, $vector) {
		$key		= $this -> mhashLike($key);
		$decryption	= mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $vector);
		return $decryption;
	}
}


$Security = new Security();
$iv = file_get_contents('../db/users/code.txt');
$password = 'admin';
$key = "1229567342";
$encryption = $Security -> encrypt($key, $password, $iv);

file_put_contents('password.txt', $encryption);
?>