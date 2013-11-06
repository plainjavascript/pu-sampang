<?php
class Convert {
	function navigation() {
		$all = file_get_contents('db/navigation/all.txt');
		$array = explode('|', $all);
		$total = count($array) - 1;
		$n = 1;
		$print = '';
		for ( ; $n <= $total; $n++ ) {
			$id = $array[$n];
			$text = file_get_contents('db/navigation/' . $id . '/text.txt');
			$link = file_get_contents('db/navigation/' . $id . '/link.txt');
			$print .= '<a href="' . $link . '" class="column block nav transition-color">' . $text . '</a>';
		}
		
		return $print;
	}
	
	
	function bigSlide() {
		$all   = file_get_contents('db/big-slide/all.txt');
		$array = explode('|', $all);
		$total = count($array) - 1;
		$data  = '';
		$img   = '';
		$n     = 1;
		for ( ; $n <= $total; $n++ ) {
			$id    = $array[$n];
			$img  .= '-' . $id . '.jpg';
			$data .= '{}' . file_get_contents('db/big-slide/' . $id . '/name.txt');
		}
		
		$print = '
		<div id="big-slide">
			<input type="hidden" class="img" value="' . $img . '">
			<div class="data hidden">' . $data . '</div>
			<div class="wrapper">
				<div class="frame colsgroup center">
					<div class="relative images-wrapper colsgroup">
						
					</div>
				</div>
			</div>
		</div>
		';
		return $print;
	}
	
	
	function programPromo() {
		$all = file_get_contents('db/program-promo/all.txt');
		$array = explode('|', $all);
		$total = count($array) - 1;
		$n = 1;
		$print = '<div class="colsgroup center" id="program-promo">';
		for ( ; $n <= $total; $n++ ) {
			$extraClass = 'col-a';
			if ( $n % 2 === 0 ) {
				$extraClass = 'col-b';
			}
			$id = $array[$n];
			$name = file_get_contents('db/program-promo/' . $id . '/name.txt');
			$link = file_get_contents('db/program-promo/' . $id . '/link.txt');
			$picture = file_get_contents('db/program-promo/' . $id . '/picture.txt');
			$print .= '
				<a class="block column ' . $extraClass . '" href="' . $link . '">
					<img alt="promosi program kementrian pu sampang" src="images/program-promo/' . $id . '/' . $picture . '">
				</a>
			';
		}
		$print .= '</div>';
		return $print;
	}
	
	
	function newsSlide() {
		$all = file_get_contents('db/news/all.txt');
		$array = explode('|', $all);
		$total = count($array) - 1;
		$n = $total;
		$print = '<div id="news-slide">
					<div class="frame">
						<div class="relative wrapper">';
		for ( ; $n > 0; $n-- ) {
			$id = $array[$n];
			$title = file_get_contents('db/news/' . $id . '/title.txt');
			$description = file_get_contents('db/news/' . $id . '/description.txt');
			$date = file_get_contents('db/news/' . $id . '/date.txt');
			$cat = file_get_contents('db/news/' . $id . '/category.txt');
			$detailUrl = file_get_contents('db/news/' . $id . '/url.txt');
			$completeUrl = $cat . '/' . $detailUrl;
			$image = file_get_contents('db/news/' . $id . '/image.txt');
			
			$print .= '
				<div class="list colsgroup">
					<div class="column col1">
						<img alt="pu sampang news" class="block" src="images/news/' . $id . '/landscape-' . $image . '">
					</div>
					<div class="column col2">
						<a href="' . $completeUrl . '" class="block title transition-bg">' . $title . '</a>
						<div class="date">' . $date . '</div>
						<div class="description">' . $description . '</div>
					</div>
				</div>
			';
		}
		
		$print .= '
					</div>
				</div>
				<div class="slider center">
					<div class="absolute previous transition-opacity arrow none"></div>
					<div class="absolute next transition-opacity arrow"></div>
				</div>
			</div>';
		return $print;
	}
	
	
	function template() {
		global $url, $page, $template;
		$keyword = array(
			'{doctype}',
			'{meta}',
			'{title}',
			'{framework styles}',
			'{styles}',
			'{framework scripts}',
			'{scripts}',
			'{logo}',
			'{site name}',
			'{search}',
			'{nav}',
			'{big slide}',
			'{slogan}',
			'{news slide}',
			'{program promo}',
			'{copyright}'
		);
		
		$replace = array(
			// {doctype}
			'<!doctype html>',
			
			// {meta}
			'<base href="' . $url['base'] . '" target="_self">'
			. '<link rel="shortcut icon" href="guest/images/logo.ico">',
			
			// {title}
			'Kementrian Pekerjaan Umum | Wilayah Sampang, Madura - PU Sampang',
			
			// {framework styles}
			'<link rel="stylesheet" href="framework/rezet.css">
			<link rel="stylesheet" href="framework/ui.css">',
			
			// {styles}
			'<link rel="stylesheet" href="guest/all.css">
			<link rel="stylesheet" href="guest/' . $page['mode'] . '/style.css">',
			
			// {framework scripts}
			'<script src="framework/dom.js"></script>
			<script src="framework/requestFrame.js"></script>
			<script src="framework/jquery.js"></script>',
			
			// {scripts}
			'<script src="guest/all.js" defer></script>
			<script src="guest/' . $page['mode'] . '/script.js" defer></script>',
	
			// {logo}
			'<img alt="logo kementrian pekerjaan umum sampang" src="guest/images/logo.png" class="block logo">',
			
			// {site name}
			'<div class="site-name">KEMENTRIAN PEKERJAAN UMUM RI<br>SAMPANG - MADURA</div>',
			
			// {search}
			'<form action="" method="get" class="block colsgroup search">
				<input type="text" class="column input-text block" placeholder="pencarian...">
				<input type="submit" value="Search" class="column ui button submit">
			</form>',
			
			// {nav}
			$this -> navigation(),
			
			// {big slide}
			$this -> bigSlide(),
			
			// {slogan}
			'<div class="slogan">' . file_get_contents('db/slogan/data.txt') . '</div>',
			
			// {news slide}
			$this -> newsSlide(),
			
			// {program promo}
			$this -> programPromo(),
			
			// {copyright}
			'<div class="copyright">Hak Cipta &copy; 2013. Kementrian Pekerjaan Umum Sampang - Madura, Indonesia</div>'
		);
		
		$template = str_ireplace($keyword, $replace, $template);
		echo $template;
	}
}
?>