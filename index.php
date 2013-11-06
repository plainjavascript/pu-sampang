<?php
// url, access, so that im able to include the layout
$url = array();
$page = array();
$permission = 'guest';
$layout = 'engine';
$config = '{
	"title"			: "PU-Sampang - Kementrian Pekerjaan Umum Kab. Sampang, Jawa Timur, Indonesia",
	"cookie-user"	: "pusampang-username",
	"secret-key"	: "1229567342",
	"url-limit"		: 5,
	"cookie-time"	: 172800
}';
$config = json_decode($config, true);


class Setting {
	function baseUrl($file) {
		$u = strip_tags(htmlspecialchars($_SERVER['PHP_SELF']));
		$u = str_ireplace($file, '', $u);
		return $u;
	}
	
	
	function baseMap($file) {
		$root	= $_SERVER['DOCUMENT_ROOT'];
		$map	= $root . $this -> baseUrl($file);
		return $map;
	}
	
	
	function url() {
		global $url, $config;
		$url['extra']  = strip_tags(htmlspecialchars($_SERVER['REQUEST_URI']));
		$url['full']   = $_SERVER['SERVER_NAME'] . $url['extra'];
		$url['domain'] = $_SERVER['SERVER_NAME'] . '/';
		$url['base']   = $this -> baseUrl('index.php');
		$url['map']	   = $this -> baseMap('index.php');
		$n = 1;
		for ( ; $n <= $config['url-limit']; $n++ ) {
			if ( isset($_GET['url' . $n]) && !empty($_GET['url' . $n]) ) {
				$url[$n] = strip_tags(htmlspecialchars($_GET['url' . $n]));
			}
		}
	}
	
	
	function permission() {
		global $url, $config, $permission, $layout;
		$cookieUser = $config['cookie-user'];
		$iv = file_get_contents('db/users/code.txt');
		$limit = $config['cookie-time'];
		if ( isset($_COOKIE[$cookieUser]) ) {
			$cookieUsername = $_COOKIE[$cookieUser];
			if ( @file_exists('db/users/' . $cookieUsername . '/key.txt') ) {
				$savedKey = file_get_contents('db/users/' . $cookieUsername . '/key.txt');
				$savedValue = file_get_contents('db/users/' . $cookieUsername . '/value.txt');
				
				if ( isset($_COOKIE[$savedKey]) ) {
					$cookieValue = $_COOKIE[$savedKey];
					$cookieValue = $Security -> encrypt($config['secret-key'], $cookieValue, $iv);
					
					if ( $cookieValue === $savedValue ) {
						$permission	= file_get_contents('db/users/' . $cookieUsername . '/permission.txt');
						$layout = 'guest-mode';
						
						/*! strict area */
						if ( isset($url[1]) ) {
							if ( $url[1] === 'backend' ) {
								$layout	= 'engine';
							} else {
								if ( $url[1] === 'out' ) {
									setcookie($cookieUser, '', time() - $limit, '/');
									setcookie($savedKey, '', time() - $limit, '/');
									header('location:' . $url['base']);
									exit();
								}
							}
						}
					} else {
						setcookie($cookieUser, '', time() - $limit, '/');
						setcookie($savedKey, '', time() - $limit, '/');
					}
					
				} else {
					setcookie($cookieUser, '', time() - $limit, '/');
				}
				
			} else {
				setcookie($cookieUser, '', time() - $limit, '/');
			}
		}
		
	}
	
	
	function page() {
		global $url, $page;
		if ( !isset($url[1]) ) {
			$page['mode'] = 'home-page';
			$page['level'] = 1;
		}
	}
	
}


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
$Setting = new Setting();
$Setting -> url();
$Setting -> permission();
$Setting -> page();
require $permission . '/' . $layout . '.php';
?>