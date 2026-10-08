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

	/* Desktop dropdown touch: first tap opens, second follows the parent link. */
	var dropParents = document.querySelectorAll( '#fbaNav .menu-item-has-children > a' );
	var touchMenu = window.matchMedia && window.matchMedia( '(hover: none)' ).matches;
	dropParents.forEach( function ( link ) {
		link.addEventListener( 'click', function ( e ) {
			var li = link.parentElement;
			if ( touchMenu && ! li.classList.contains( 'open' ) ) {
				e.preventDefault();
				closeDrops( li );
				li.classList.add( 'open' );
				link.setAttribute( 'aria-expanded', 'true' );
			}
		} );
	} );
	function closeDrops( except ) {
		document.querySelectorAll( '#fbaNav .menu-item-has-children.open' ).forEach( function ( o ) {
			if ( o !== except ) {
				o.classList.remove( 'open' );
				var oa = o.querySelector( ':scope > a' );
				if ( oa ) {
					oa.setAttribute( 'aria-expanded', 'false' );
				}
			}
		} );
	}

	/* Drawer accordions for submenu parents. */
	document.querySelectorAll( '#fbaDrawer .menu-item-has-children' ).forEach( function ( li ) {
		var link = li.querySelector( ':scope > a' );
		var btn = document.createElement( 'button' );
		btn.setAttribute( 'type', 'button' );
		btn.className = 'fba-drawer-toggle';
		btn.setAttribute( 'aria-label', 'Toggle submenu' );
		btn.setAttribute( 'aria-expanded', 'false' );
		btn.textContent = '+';
		btn.addEventListener( 'click', function () {
			var open = li.classList.toggle( 'open' );
			btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			if ( link ) {
				link.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			}
		} );
		li.appendChild( btn );
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
