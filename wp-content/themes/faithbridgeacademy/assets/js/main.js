/* FaithBridge Academy — slider, header, drawer, reveal, counters. */
(function () {
	'use strict';

	/* Sticky header state. */
	var header = document.getElementById( 'fbaHeader' );
	function onScroll() {
		if ( header ) {
			header.classList.toggle( 'scrolled', window.scrollY > 40 );
		}
	}
	window.addEventListener( 'scroll', onScroll, { passive: true } );
	onScroll();

	/* Mobile drawer. */
	var burger = document.getElementById( 'fbaBurger' );
	var drawer = document.getElementById( 'fbaDrawer' );
	var overlay = document.getElementById( 'fbaDrawerOverlay' );
	var closeBtn = document.getElementById( 'fbaDrawerClose' );
	function setDrawer( open ) {
		document.body.classList.toggle( 'fba-drawer-open', open );
		if ( burger ) {
			burger.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		}
	}
	if ( burger ) {
		burger.addEventListener( 'click', function () { setDrawer( true ); } );
	}
	if ( closeBtn ) {
		closeBtn.addEventListener( 'click', function () { setDrawer( false ); } );
	}
	if ( overlay ) {
		overlay.addEventListener( 'click', function () { setDrawer( false ); } );
	}
	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key ) {
			setDrawer( false );
		}
	} );

	/* Hero slider. */
	var slider = document.getElementById( 'fbaSlider' );
	if ( slider ) {
		var slides = slider.querySelectorAll( '.fba-slide' );
		var dots = slider.querySelectorAll( '.fba-slider-dots button' );
		var prev = slider.querySelector( '.fba-slider-prev' );
		var next = slider.querySelector( '.fba-slider-next' );
		var current = 0;
		var timer = null;
		var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		function go( i ) {
			current = ( i + slides.length ) % slides.length;
			slides.forEach( function ( s, idx ) {
				var on = idx === current;
				s.classList.toggle( 'active', on );
				s.setAttribute( 'aria-hidden', on ? 'false' : 'true' );
				if ( on ) {
					s.removeAttribute( 'inert' );
				} else {
					s.setAttribute( 'inert', '' );
				}
			} );
			dots.forEach( function ( d, idx ) {
				var on = idx === current;
				d.classList.toggle( 'active', on );
				d.setAttribute( 'aria-selected', on ? 'true' : 'false' );
			} );
		}

		function play() {
			if ( reduceMotion ) {
				return;
			}
			stop();
			timer = window.setInterval( function () { go( current + 1 ); }, 7000 );
		}

		function stop() {
			if ( timer ) {
				window.clearInterval( timer );
				timer = null;
			}
		}

		dots.forEach( function ( d ) {
			d.addEventListener( 'click', function () {
				go( parseInt( d.getAttribute( 'data-slide' ), 10 ) );
				play();
			} );
		} );
		if ( prev ) {
			prev.addEventListener( 'click', function () { go( current - 1 ); play(); } );
		}
		if ( next ) {
			next.addEventListener( 'click', function () { go( current + 1 ); play(); } );
		}
		slider.addEventListener( 'mouseenter', stop );
		slider.addEventListener( 'mouseleave', play );
		play();
	}

	/* Reveal on scroll. */
	var revealEls = document.querySelectorAll( '.reveal' );
	if ( 'IntersectionObserver' in window ) {
		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'visible' );
					io.unobserve( entry.target );
				}
			} );
		}, { threshold: 0.12 } );
		revealEls.forEach( function ( el ) { io.observe( el ); } );
	} else {
		revealEls.forEach( function ( el ) { el.classList.add( 'visible' ); } );
	}

	/* Animated counters. */
	var counters = document.querySelectorAll( '.fba-stat-num[data-count]' );
	if ( 'IntersectionObserver' in window ) {
		var cio = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( ! entry.isIntersecting ) {
					return;
				}
				var el = entry.target;
				cio.unobserve( el );
				var target = parseInt( el.getAttribute( 'data-count' ), 10 );
				var suffix = el.getAttribute( 'data-suffix' ) || '+';
				var start = null;
				var dur = 1400;
				function tick( ts ) {
					if ( ! start ) {
						start = ts;
					}
					var p = Math.min( ( ts - start ) / dur, 1 );
					var eased = 1 - Math.pow( 1 - p, 3 );
					el.textContent = Math.round( eased * target ) + suffix;
					if ( p < 1 ) {
						window.requestAnimationFrame( tick );
					}
				}
				window.requestAnimationFrame( tick );
			} );
		}, { threshold: 0.4 } );
		counters.forEach( function ( el ) { cio.observe( el ); } );
	} else {
		counters.forEach( function ( el ) {
			el.textContent = el.getAttribute( 'data-count' ) + ( el.getAttribute( 'data-suffix' ) || '+' );
		} );
	}
} )();
