/* FaithBridge Academy — slider, header, drawer, reveal, counters. */
(function () {
	'use strict';

	/* Sticky header + back-to-top. */
	var header = document.getElementById( 'fbaHeader' );
	var totop = document.getElementById( 'fbaToTop' );
	function onScroll() {
		var y = window.scrollY || 0;
		if ( header ) {
			header.classList.toggle( 'scrolled', y > 40 );
		}
		if ( totop ) {
			totop.classList.toggle( 'show', y > 700 );
		}
	}
	window.addEventListener( 'scroll', onScroll, { passive: true } );
	onScroll();
	if ( totop ) {
		totop.addEventListener( 'click', function () {
			window.scrollTo( { top: 0, behavior: 'smooth' } );
		} );
	}

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
		var dotsWrap = document.getElementById( 'fbaSliderDots' );
		var dots = [];
		var current = 0;
		var timer = null;
		var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		slides.forEach( function ( s, idx ) {
			var b = document.createElement( 'button' );
			b.setAttribute( 'role', 'tab' );
			b.setAttribute( 'aria-selected', idx === 0 ? 'true' : 'false' );
			b.setAttribute( 'aria-label', 'Slide ' + ( idx + 1 ) );
			if ( idx === 0 ) {
				b.classList.add( 'active' );
			}
			b.addEventListener( 'click', function () {
				go( idx );
				play();
			} );
			dotsWrap.appendChild( b );
			dots.push( b );
		} );

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
			timer = window.setInterval( function () { go( current + 1 ); }, 10000 );
		}

		function stop() {
			if ( timer ) {
				window.clearInterval( timer );
				timer = null;
			}
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
