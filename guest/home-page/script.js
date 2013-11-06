function NewsScroller(options) {
	var shown   = options.shown,
		node    = options.node,
		speed   = options.speed;
		
	var frame   = node.getElementsByClassName('frame')[0],
		wrapper = frame.getElementsByClassName('wrapper')[0],
		$wrapper= $(wrapper),
		list    = wrapper.getElementsByClassName('list'),
		height	= $(list[0]).outerHeight(true),
		total   = list.length,
		arrows  = node.getElementsByClassName('arrow'),
		previous= arrows[0],
		next    = arrows[1],
		currentIndex = 1,
		totalIndex   = total/shown;
	
	if ( totalIndex <= 1 ) {
		next.classList.add('none');
	} else {
		// let's coding
		var stringIndex, arrayIndex, beforeDot, lastIndex, margin, n;
		stringIndex = totalIndex.toFixed(1);
		indexArray  = stringIndex.split('.');
		beforeDot   = parseInt(indexArray[0]);
		if ( totalIndex > beforeDot ) {
			totalIndex += 1;
		}
		
		lastIndex = totalIndex;
		n = 0;
		margin = 0;
		
		function goNext() {
			margin -= height * shown;
			currentIndex += 1;
			previous.classList.remove('none');
			if ( currentIndex === lastIndex ) {
				next.classList.add('none');
			}
			$wrapper.stop().animate({marginTop: margin}, speed);
		}
		
		function goPrevious() {
			margin += height * shown;
			currentIndex -= 1;
			next.classList.remove('none');
			if ( currentIndex === 1 ) {
				previous.classList.add('none');
			}
			$wrapper.stop().animate({marginTop: margin}, speed);
		}
		
		next.addEventListener('mousedown', goNext, false);
		previous.addEventListener('mousedown', goPrevious, false);
		// done
	}
}



function Slideflow(options) {
	var node    = options.node,
		speed   = options.speed,
		timeout = options.timeout;
	
	var wrapper = node.getElementsByClassName('wrapper')[0],
		frame   = wrapper.getElementsByClassName('frame')[0],
		imagesWrapper = frame.getElementsByClassName('images-wrapper')[0],
		imgData = node.getElementsByClassName('img')[0].value,
		array   = imgData.split('-'),
		total   = (array.length) - 1;
	
	(function() {
		var image, frag, n, s;
		frag = document.createDocumentFragment();
		n    = 1;
		for ( ; n <= total; n++ ) {
			s = n.toString();
			image = document.createElement('img');
			image.src = 'images/big-slide/' + s + '.jpg';
			image.className = 'block column img';
			image.setAttribute('alt', 'Slideshow web resmi kementrian PU Sampang - Madura');
			image.setAttribute('data-id', s);
			frag.appendChild(image);
		}
		imagesWrapper.appendChild(frag);
	})();
	
	var currentIndex  = 1,
		previousIndex = 0,
		nextIndex     = 2,
		frameWidth    = parseInt(window.getComputedStyle(frame, null).getPropertyValue('width')),
		images        = imagesWrapper.getElementsByClassName('img'),
		imgWidth      = parseInt(window.getComputedStyle(images[previousIndex], null).getPropertyValue('width')),
		imgHeight     = parseInt(window.getComputedStyle(images[previousIndex], null).getPropertyValue('height')),
		imgOpacity    = window.getComputedStyle(images[previousIndex], null).getPropertyValue('opacity'),
		allImgWidth   = (imgWidth * total).toString() + 'px',
		leftMargin    = 0,
		limit         = total - 1,
		activeHeight;
	
	(function() {
		if ( frameWidth > imgWidth ) {
			var remain = frameWidth - imgWidth,
				half   = remain/2;
			
			leftMargin = -(imgWidth - half);
			leftMargin = leftMargin.toString() + 'px';
		}
	})();
	
	imagesWrapper.style.width = allImgWidth;
	imagesWrapper.style.marginLeft = leftMargin;
	images[currentIndex].classList.add('current');
	activeHeight = parseInt(window.getComputedStyle(images[currentIndex], null).getPropertyValue('height'));
	
	var currentImg, previousImg, nextImg, $currentImg, $previousImg, $nextImg, removed, appendImage, timeoutId;
	function sliding() {
		images       = imagesWrapper.getElementsByClassName('img');
		currentImg   = images[currentIndex];
		previousImg  = images[previousIndex];
		nextImg      = images[nextIndex];
		$currentImg  = $(currentImg);
		$previousImg = $(previousImg);
		$nextImg     = $(nextImg);
		removed      = previousImg.getAttribute('data-id');
		
		appendImage  = document.createElement('img');
		appendImage.src = 'images/big-slide/' + removed + '.jpg';
		appendImage.className = 'block column img';
		appendImage.setAttribute('alt', 'Slideshow web resmi kementrian PU Sampang - Madura');
		appendImage.setAttribute('data-id', removed);
		
		$previousImg.stop().animate({
			marginLeft: -imgWidth
		}, speed, function() {
			imagesWrapper.removeChild(previousImg);
			imagesWrapper.appendChild(appendImage);
		});
		
		$currentImg.stop().animate({
			height: imgHeight,
			opacity: imgOpacity
		}, speed);
		
		$nextImg.stop().animate({
			height: activeHeight,
			opacity: 1
		}, speed);
		
		timeoutId = requestTimeout(sliding, timeout+speed);
	}
	
	timeoutId = requestTimeout(sliding, timeout);
}



// layout object
var Homepage = (function() {
	var newsSlide = document.getElementById('news-slide'),
		bigSlide  = document.getElementById('big-slide');
	
	return {
		newsSlide : newsSlide,
		bigSlide  : bigSlide
	};
})();



// run script
NewsScroller({
	node  : Homepage.newsSlide,
	shown : 3,
	speed : 400
});

Slideflow({
	node    : Homepage.bigSlide,
	speed   : 1000,
	timeout : 3000
});