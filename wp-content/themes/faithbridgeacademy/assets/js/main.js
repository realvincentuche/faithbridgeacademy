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

	/* Hero slider: autoplay + swipe (touch) + keyboard arrows. */
	var slider = document.getElementById( 'fbaSlider' );
	if ( slider ) {
		var slides = slider.querySelectorAll( '.fba-slide' );
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

		function step( dir ) {
			go( current + dir );
			play();
		}

		slider.addEventListener( 'mouseenter', stop );
		slider.addEventListener( 'mouseleave', play );

		/* Touch swipe. */
		var touchX = null;
		slider.addEventListener( 'touchstart', function ( e ) {
			if ( e.changedTouches && e.changedTouches.length ) {
				touchX = e.changedTouches[0].clientX;
			}
		}, { passive: true } );
		slider.addEventListener( 'touchend', function ( e ) {
			if ( null === touchX || ! e.changedTouches || ! e.changedTouches.length ) {
				return;
			}
			var dx = e.changedTouches[0].clientX - touchX;
			touchX = null;
			if ( Math.abs( dx ) < 40 ) {
				return;
			}
			step( dx < 0 ? 1 : -1 );
		}, { passive: true } );
		slider.addEventListener( 'touchcancel', function () { touchX = null; }, { passive: true } );

		/* Keyboard arrows when the hero is on screen (desktop). */
		document.addEventListener( 'keydown', function ( e ) {
			if ( 'ArrowRight' !== e.key && 'ArrowLeft' !== e.key ) {
				return;
			}
			var tag = e.target && e.target.tagName ? e.target.tagName.toLowerCase() : '';
			if ( 'input' === tag || 'textarea' === tag || 'select' === tag || ( e.target && e.target.isContentEditable ) ) {
				return;
			}
			var r = slider.getBoundingClientRect();
			if ( r.bottom < 0 || r.top > window.innerHeight ) {
				return;
			}
			e.preventDefault();
			step( 'ArrowRight' === e.key ? 1 : -1 );
		} );

		play();
	}

	/* Life band video popup. */
	var playBtn = document.getElementById( 'fbaPlayBtn' );
	var videoModal = document.getElementById( 'fbaVideoModal' );
	var videoClose = document.getElementById( 'fbaVideoClose' );
	var videoFrame = document.getElementById( 'fbaVideoFrame' );
	var videoUrl = 'https://www.youtube.com/embed/_NXIpq2LkL0?autoplay=1&rel=0';
	function openVideo() {
		if ( ! videoModal || ! videoFrame ) {
			return;
		}
		videoFrame.setAttribute( 'src', videoUrl );
		videoModal.removeAttribute( 'hidden' );
		document.body.style.overflow = 'hidden';
		if ( videoClose ) {
			videoClose.focus();
		}
	}
	function closeVideo() {
		if ( ! videoModal || ! videoFrame ) {
			return;
		}
		videoFrame.setAttribute( 'src', '' );
		videoModal.setAttribute( 'hidden', '' );
		document.body.style.overflow = '';
		if ( playBtn ) {
			playBtn.focus();
		}
	}
	if ( playBtn ) {
		playBtn.addEventListener( 'click', openVideo );
	}
	if ( videoClose ) {
		videoClose.addEventListener( 'click', closeVideo );
	}
	if ( videoModal ) {
		videoModal.addEventListener( 'click', function ( e ) {
			if ( e.target === videoModal ) {
				closeVideo();
			}
		} );
	}
	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key && videoModal && ! videoModal.hasAttribute( 'hidden' ) ) {
			closeVideo();
		}
	} );

	/* Application multi-step form. */
	var applyForm = document.getElementById( 'fbaApplyForm' );
	if ( applyForm ) {
		var steps = Array.prototype.slice.call( applyForm.querySelectorAll( '.fba-step' ) );
		var dots = Array.prototype.slice.call( applyForm.querySelectorAll( '[data-step-dot]' ) );
		var idx = 0;

		function show( i ) {
			idx = Math.max( 0, Math.min( steps.length - 1, i ) );
			steps.forEach( function ( s, k ) { s.classList.toggle( 'active', k === idx ); } );
			dots.forEach( function ( d, k ) { d.classList.toggle( 'active', k <= idx ); } );
			if ( idx === steps.length - 1 ) {
				buildReview();
			} else {
				var box = document.getElementById( 'fbaReview' );
				if ( box ) {
					box.innerHTML = '';
				}
			}
			applyForm.scrollIntoView( { behavior: 'smooth', block: 'start' } );
		}

		function validStep() {
			var ok = true;
			var fields = steps[idx].querySelectorAll( 'input[required], select[required]' );
			fields.forEach( function ( f ) {
				var bad = ! f.value || ( 'checkbox' === f.type && ! f.checked );
				f.classList.toggle( 'invalid', !! bad );
				if ( bad ) {
					ok = false;
				}
			} );
			if ( 2 === idx ) {
				var any = applyForm.querySelectorAll( 'input[name="fba_programmes[]"]:checked' ).length > 0;
				if ( ! any ) {
					ok = false;
				}
			}
			return ok;
		}

		var fbaRate = 1500;
		var rateEl = document.querySelector( '[data-fba-rate]' );
		if ( rateEl ) {
			fbaRate = Number( rateEl.getAttribute( 'data-fba-rate' ) ) || 1500;
		}
		function money( n ) {
			return '$' + Number( n ).toLocaleString( 'en-US' );
		}
		function moneyNgn( n ) {
			var v = Math.ceil( Number( n ) * fbaRate / 1000 ) * 1000;
			return '₦' + v.toLocaleString( 'en-US' );
		}
		function curIsNgn() {
			return document.body.classList.contains( 'fba-cur-ngn' );
		}

		window.fbaRebuildReview = function () {
			var box = document.getElementById( 'fbaReview' );
			if ( ! box || ! box.innerHTML ) {
				return;
			}
			buildReview();
		};
		function buildReview() {
			var box = document.getElementById( 'fbaReview' );
			if ( ! box ) {
				return;
			}
			var esc = function ( s ) {
				return String( s == null ? '' : s )
					.replace( /&/g, '&amp;' )
					.replace( /</g, '&lt;' )
					.replace( />/g, '&gt;' )
					.replace( /"/g, '&quot;' )
					.replace( /'/g, '&#39;' );
			};
			var val = function ( name ) {
				var f = applyForm.querySelector( '[name="' + name + '"]' );
				return f ? esc( f.value ) : '';
			};
			var styleEl = applyForm.querySelector( 'input[name="fba_style"]:checked' );
			var style = styleEl ? styleEl.value : 'group';
			var ngn = curIsNgn();
			var boxes = applyForm.querySelectorAll( 'input[name="fba_programmes[]"]:checked' );
			var names = [];
			var total = 0;
			boxes.forEach( function ( b ) {
				var fee = Number( 'one' === style ? b.getAttribute( 'data-one' ) : b.getAttribute( 'data-group' ) ) || 0;
				total += fee;
				var label = esc( b.getAttribute( 'data-title' ) || b.value );
				names.push( label + ' (' + ( ngn ? moneyNgn( fee ) : money( fee ) ) + ')' );
			} );
			var sessSel = applyForm.querySelector( '#fbaSession' );
			var sess = sessSel ? esc( sessSel.options[sessSel.selectedIndex].text ) : '';
			box.innerHTML = '<dl>'
				+ '<dt>Applicant</dt><dd>' + val( 'fba_name' ) + ' · ' + val( 'fba_phone' ) + '</dd>'
				+ '<dt>Ward</dt><dd>' + val( 'fba_ward_name' ) + ' · ' + val( 'fba_ward_dob' ) + ' · ' + val( 'fba_ward_class' ) + '</dd>'
				+ '<dt>Programmes</dt><dd>' + names.join( ', ' ) + '</dd>'
				+ '<dt>Style</dt><dd>' + ( 'one' === style ? 'One-on-one' : 'Group class' ) + '</dd>'
				+ '<dt>Session</dt><dd>' + sess + '</dd>'
				+ '<dt>Total</dt><dd class="total">' + ( ngn ? moneyNgn( total ) : money( total ) ) + '</dd>'
				+ '</dl>';
		}

		applyForm.querySelectorAll( '[data-next]' ).forEach( function ( b ) {
			b.addEventListener( 'click', function () {
				if ( validStep() ) {
					show( idx + 1 );
				}
			} );
		} );
		applyForm.querySelectorAll( '[data-prev]' ).forEach( function ( b ) {
			b.addEventListener( 'click', function () { show( idx - 1 ); } );
		} );

		applyForm.querySelectorAll( 'input[name="fba_programmes[]"], input[name="fba_style"]' ).forEach( function ( el ) {
			el.addEventListener( 'change', function () {
				var box = document.getElementById( 'fbaReview' );
				if ( box && box.innerHTML ) {
					buildReview();
				}
			} );
		} );

		var kindRadios = applyForm.querySelectorAll( 'input[name="fba_kind"]' );
		var sponsorRow = applyForm.querySelector( '.fba-sponsor-only' );
		kindRadios.forEach( function ( r ) {
			r.addEventListener( 'change', function () {
				var sponsor = 'sponsor' === applyForm.querySelector( 'input[name="fba_kind"]:checked' ).value;
				if ( sponsorRow ) {
					sponsorRow.hidden = ! sponsor;
				}
			} );
		} );
	}

	/* Sponsorship calculator: duration x children, or free amount. */
	var spForm = document.getElementById( 'fbaSponsorForm' );
	if ( spForm ) {
		var spTotal = document.getElementById( 'fbaSpTotal' );
		function ngn( n ) {
			return '₦' + Number( n ).toLocaleString( 'en-US' );
		}
		function spUpdate() {
			var catEl = spForm.querySelector( 'input[name="fba_sp_category"]:checked' );
			var cat = catEl ? catEl.value : 'bible';
			var durEl = spForm.querySelector( 'input[name="fba_sp_duration"]:checked' );
			var dur = durEl ? durEl.value : 'session';
			var plan = spForm.querySelector( '.fba-sp-plan' );
			var gen = spForm.querySelector( '.fba-sp-general' );
			var acad = spForm.querySelector( '.fba-sp-academic-only' );
			var total = 0;
			if ( 'general' === cat ) {
				if ( plan ) { plan.hidden = true; }
				if ( gen ) { gen.hidden = false; }
				var amtEl = spForm.querySelector( '#fbaSpAmount' );
				total = amtEl ? ( Number( amtEl.value ) || 0 ) : 0;
			} else {
				if ( plan ) { plan.hidden = false; }
				if ( gen ) { gen.hidden = true; }
				if ( acad ) { acad.style.display = 'academic' === cat ? '' : 'none'; }
				var kidsEl = spForm.querySelector( '#fbaSpChildren' );
				var kids = kidsEl ? ( parseInt( kidsEl.value, 10 ) || 1 ) : 1;
				var per = 0;
				if ( 'bible' === cat ) {
					per = Number( 'year' === dur ? spForm.getAttribute( 'data-bible-year' ) : spForm.getAttribute( 'data-bible-session' ) ) || 0;
				} else {
					per = Number( 'year' === dur ? spForm.getAttribute( 'data-academic-year' ) : spForm.getAttribute( 'data-academic-session' ) ) || 0;
				}
				total = per * kids;
			}
			if ( spTotal ) {
				spTotal.textContent = ngn( total );
			}
		}
		spForm.querySelectorAll( 'input[name="fba_sp_category"], input[name="fba_sp_duration"]' ).forEach( function ( el ) {
			el.addEventListener( 'change', spUpdate );
		} );
		var spKids = spForm.querySelector( '#fbaSpChildren' );
		if ( spKids ) {
			spKids.addEventListener( 'change', spUpdate );
		}
		var spAmt = spForm.querySelector( '#fbaSpAmount' );
		if ( spAmt ) {
			spAmt.addEventListener( 'input', spUpdate );
		}
		spUpdate();
	}

	/* Currency switcher: usd|ngn select, persisted in a cookie. */
	var curSel = document.getElementById( 'fbaCurrency' );
	function setCurrency( cur ) {
		cur = 'ngn' === cur ? 'ngn' : 'usd';
		document.body.classList.toggle( 'fba-cur-ngn', 'ngn' === cur );
		document.body.classList.toggle( 'fba-cur-usd', 'ngn' !== cur );
		if ( curSel && curSel.value !== cur ) {
			curSel.value = cur;
		}
		document.querySelectorAll( '.fba-check-fee' ).forEach( function ( el ) {
			el.textContent = 'ngn' === cur ? el.getAttribute( 'data-fee-ngn' ) : el.getAttribute( 'data-fee-usd' );
		} );
		if ( 'function' === typeof window.fbaRebuildReview ) {
			window.fbaRebuildReview();
		}
		try {
			document.cookie = 'fba_currency=' + cur + '; path=/; max-age=31536000; SameSite=Lax';
		} catch ( e ) {}
	}
	if ( curSel ) {
		curSel.addEventListener( 'change', function () { setCurrency( curSel.value ); } );
	}

	/* FAQ accordion. */
	document.querySelectorAll( '.fba-faq-item' ).forEach( function ( item ) {
		var btn = item.querySelector( '.fba-faq-q' );
		var panel = item.querySelector( '.fba-faq-a' );
		if ( ! btn || ! panel ) {
			return;
		}
		btn.addEventListener( 'click', function () {
			var open = item.classList.toggle( 'open' );
			btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			var glyph = btn.querySelector( 'span[aria-hidden="true"]' );
			if ( glyph ) {
				glyph.textContent = open ? '–' : '+';
			}
			if ( open ) {
				panel.removeAttribute( 'hidden' );
			} else {
				panel.setAttribute( 'hidden', '' );
			}
		} );
	} );

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
