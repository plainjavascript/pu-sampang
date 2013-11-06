function dom(element) {

	function byId(str) {
		return document.getElementById(str);
	}
	
	
	function byClass(str) {
		if ( element ) {
			return element.getElementsByClassName(str);
		} else {
			return document.getElementsByClassName(str);
		}
	}
	
	
	function byTag(str) {
		if ( element ) {
			return element.getElementsByTagName(str);
		} else {
			return document.getElementsByTagName(str);
		}
	}
	
	
	function qs(str) {
		if ( element ) {
			return element.querySelector(str);
		} else {
			return document.querySelector(str);
		}
	}
	
	
	function qsa(str) {
		if ( element ) {
			return element.querySelectorAll(str);
		} else {
			return document.querySelectorAll(str);
		}
	}
	
	
	function on(type, func) {
		element.addEventListener(type, func, false);
	}
	
	
	function off(type, func) {
		element.removeEventListener(type, func, false);
	}
	
	
	function click(func) {
		element.addEventListener('click', func, false);
	}
	
	
	function mouseup(func) {
		element.addEventListener('mouseup', func, false);
	}
	
	
	function mousedown(func) {
		element.addEventListener('mousedown', func, false);
	}
	
	
	function keyup(func) {
		element.addEventListener('keyup', func, false);
	}
	
	
	function keydown(func) {
		element.addEventListener('keydown', func, false);
	}
	
	
	function focus(func) {
		element.addEventListener('focus', func, false);
	}
	
	
	function blur(func) {
		element.addEventListener('blur', func, false);
	}
	
	
	function change(func) {
		element.addEventListener('change', func, false);
	}
	
	
	function submit(func) {
		element.addEventListener('submit', func, false);
	}
	
	
	
	return {
		byId		: byId,
		byClass		: byClass,
		byTag		: byTag,
		qs			: qs,
		qsa			: qsa,
		on			: on,
		off			: off,
		click		: click,
		mouseup		: mouseup,
		mousedown	: mousedown,
		keyup		: keyup,
		keydown		: keydown,
		focus		: focus,
		blur		: blur,
		change		: change,
		submit		: submit
	};

}