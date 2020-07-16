/*
* debouncedresize: special jQuery event that happens once after a window resize
*
* latest version and complete README available on Github:
* https://github.com/louisremi/jquery-smartresize/blob/master/jquery.debouncedresize.js
*
* Copyright 2011 @louis_remi
* Licensed under the MIT license.
*/
jQuery(function($){
$(window).load(function(){ 

var $event = $.event,
$special,
resizeTimeout;

$special = $event.special.debouncedresize = {
	setup: function() {
		$( this ).on( "resize", $special.handler );
	},
	teardown: function() {
		$( this ).off( "resize", $special.handler );
	},
	handler: function( event, execAsap ) {
		// Save the context
		var context = this,
			args = arguments,
			dispatch = function() {
				// set correct event type
				event.type = "debouncedresize";
				$event.dispatch.apply( context, args );
			};

		if ( resizeTimeout ) {
			clearTimeout( resizeTimeout );
		}

		execAsap ?
			dispatch() :
			resizeTimeout = setTimeout( dispatch, $special.threshold );
	},
	threshold: 250
};

// ======================= imagesLoaded Plugin ===============================
// https://github.com/desandro/imagesloaded

// $('#my-container').imagesLoaded(myFunction)
// execute a callback when all images have loaded.
// needed because .load() doesn't work on cached images

// callback function gets image collection as argument
//  this is the container

// original: MIT license. Paul Irish. 2010.
// contributors: Oren Solomianik, David DeSandro, Yiannis Chatzikonstantinou

// blank image data-uri bypasses webkit log warning (thx doug jones)
var BLANK = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';

$.fn.imagesLoaded = function( callback ) {
	var $this = this,
		deferred = $.isFunction($.Deferred) ? $.Deferred() : 0,
		hasNotify = $.isFunction(deferred.notify),
		$images = $this.find('img').add( $this.filter('img') ),
		loaded = [],
		proper = [],
		broken = [];

	// Register deferred callbacks
	if ($.isPlainObject(callback)) {
		$.each(callback, function (key, value) {
			if (key === 'callback') {
				callback = value;
			} else if (deferred) {
				deferred[key](value);
			}
		});
	}

	function doneLoading() {
		var $proper = $(proper),
			$broken = $(broken);

		if ( deferred ) {
			if ( broken.length ) {
				deferred.reject( $images, $proper, $broken );
			} else {
				deferred.resolve( $images );
			}
		}

		if ( $.isFunction( callback ) ) {
			callback.call( $this, $images, $proper, $broken );
		}
	}

	function imgLoaded( img, isBroken ) {
		// don't proceed if BLANK image, or image is already loaded
		if ( img.src === BLANK || $.inArray( img, loaded ) !== -1 ) {
			return;
		}

		// store element in loaded images array
		loaded.push( img );

		// keep track of broken and properly loaded images
		if ( isBroken ) {
			broken.push( img );
		} else {
			proper.push( img );
		}

		// cache image and its state for future calls
		$.data( img, 'imagesLoaded', { isBroken: isBroken, src: img.src } );

		// trigger deferred progress method if present
		if ( hasNotify ) {
			deferred.notifyWith( $(img), [ isBroken, $images, $(proper), $(broken) ] );
		}

		// call doneLoading and clean listeners if all images are loaded
		if ( $images.length === loaded.length ){
			setTimeout( doneLoading );
			$images.unbind( '.imagesLoaded' );
		}
	}

	// if no images, trigger immediately
	if ( !$images.length ) {
		doneLoading();
	} else {
		$images.bind( 'load.imagesLoaded error.imagesLoaded', function( event ){
			// trigger imgLoaded
			imgLoaded( event.target, event.type === 'error' );
		}).each( function( i, el ) {
			var src = el.src;

			// find out if this image has been already checked for status
			// if it was, and src has not changed, call imgLoaded on it
			var cached = $.data( el, 'imagesLoaded' );
			if ( cached && cached.src === src ) {
				imgLoaded( el, cached.isBroken );
				return;
			}

			// if complete is true and browser supports natural sizes, try
			// to check for image status manually
			if ( el.complete && el.naturalWidth !== undefined ) {
				imgLoaded( el, el.naturalWidth === 0 || el.naturalHeight === 0 );
				return;
			}

			// cached images don't fire load sometimes, so we reset src, but only when
			// dealing with IE, or image is complete (loaded) and failed manual check
			// webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
			if ( el.readyState || el.complete ) {
				el.src = BLANK;
				el.src = src;
			}
		});
	}

	return deferred ? deferred.promise( $this ) : $this;
};

var Grid = (function() {

		// list of items
	var $grid = $( '.og-grid' ),
		// the items
		$items = $grid.children( 'li' ),
		// current expanded item's index
		current = -1,
		// position (top) of the expanded item
		// used to know if the preview will expand in a different row
		previewPos = -1,
		// extra amount of pixels to scroll the window
		scrollExtra = 0,
		// extra margin when expanded (between preview overlay and the next items)
		marginExpanded = 10,
		$window = $( window ), winsize,
		$body = $( 'html, body' ),
		// transitionend events
		transEndEventNames = {
			'WebkitTransition' : 'webkitTransitionEnd',
			'MozTransition' : 'transitionend',
			'OTransition' : 'oTransitionEnd',
			'msTransition' : 'MSTransitionEnd',
			'transition' : 'transitionend'
		},
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		// support for csstransitions
		support = Modernizr.csstransitions,
		// default settings
		settings = {
			minHeight : 500,
			speed : 350,
			easing : 'ease'
		};

	function init( config ) {
		
		// the settings..
		settings = $.extend( true, {}, settings, config );

		// preload all images
		$grid.imagesLoaded( function() {

			// save item´s size and offset
			saveItemInfo( true );
			// get window´s size
			getWinSize();
			// initialize some events
			initEvents();

		} );

	}

	// add more items to the grid.
	// the new items need to appended to the grid.
	// after that call Grid.addItems(theItems);
	function addItems( $newitems ) {

		$items = $items.add( $newitems );

		$newitems.each( function() {
			var $item = $( this );
			$item.data( {
				offsetTop : $item.offset().top,
				height : $item.height()
			} );
		} );

		initItemsEvents( $newitems );

	}

	// saves the item´s offset top and height (if saveheight is true)
	function saveItemInfo( saveheight ) {
		$items.each( function() {
			var $item = $( this );
			$item.data( 'offsetTop', $item.offset().top );
			if( saveheight ) {
				$item.data( 'height', $item.height() );
			}
		} );
	}

	function initEvents() {
		
		// when clicking an item, show the preview with the item´s info and large image.
		// close the item if already expanded.
		// also close if clicking on the item´s cross
		initItemsEvents( $items );
		
		// on window resize get the window´s size again
		// reset some values..
		$window.on( 'debouncedresize', function() {
			
			scrollExtra = 0;
			previewPos = -1;
			// save item´s offset
			saveItemInfo();
			getWinSize();
			var preview = $.data( this, 'preview' );
			if( typeof preview != 'undefined' ) {
				hidePreview();
			}

		} );

	}

	function initItemsEvents( $items ) {
		$items.on( 'click', 'span.og-close', function() {
			hidePreview();
			return false;
		} ).children( 'a' ).on( 'click', function(e) {

			var $item = $( this ).parent();
			// check if item already opened
			current === $item.index() ? hidePreview() : showPreview( $item );
			return false;

		} );
				
		
		
		$items.on( 'click', '.og-preview-image', function() {
			
			$('.og-lightbox-overlay').addClass('og-show');
			$('.og-lightbox-overlay').append('<div class="og-loading"></div>');
			$('.og-lightbox-overlay').append('<img class="og-fullimage" style="opacity:0;" src="' + $(this).data('fullsrc') + '">');
			$('.og-fullimage').load(function(){
				$('.og-fullimage').css('opacity','1');	
			});
			
		});
		
		$('.og-close-overlay').click(function(){
			
			$('.og-lightbox-overlay').removeClass('og-show');
			$('.og-fullimage').remove();
			$('.og-lightbox-overlay .og-loading').remove();
			
		});
		
	}

	function getWinSize() {
		winsize = { width : $window.width(), height : $window.height() };
	}

	function showPreview( $item ) {

		var preview = $.data( this, 'preview' ),
			// item´s offset top
			position = $item.data( 'offsetTop' );

		scrollExtra = 0;

		// if a preview exists and previewPos is different (different row) from item´s top then close it
		if( typeof preview != 'undefined' ) {

			// not in the same row
			if( previewPos !== position ) {
				// if position > previewPos then we need to take te current preview´s height in consideration when scrolling the window
				if( position > previewPos ) {
					scrollExtra = preview.height;
				}
				hidePreview();
			}
			// same row
			else {
				preview.update( $item );
				return false;
			}
			
		}

		// update previewPos
		previewPos = position;
		// initialize new preview for the clicked item
		preview = $.data( this, 'preview', new Preview( $item ) );
		// expand preview overlay
		preview.open();

	}

	function hidePreview() {
		current = -1;
		var preview = $.data( this, 'preview' );
		if(preview){
			preview.close();
			$.removeData( this, 'preview' );
		}
	}

	// the preview obj / overlay
	function Preview( $item ) {
		this.$item = $item;
		this.expandedIdx = this.$item.index();
		this.create();
		this.update();
	}
	

	Preview.prototype = {
	
		create : function() {
	
			// create Preview structure:
			this.$title = $( '<h3></h3>' );
			this.$description = $( '<p></p>' );
			this.$href = $( '<a href="#"></a>' );
			this.$extra1 = $( '<div class="extra1"><div>' );
			this.$extra2 = $( '<div class="extra2"><div>' );
			this.$extra3 = $( '<div class="extra3"><div>' );
			this.$extra4 = $( '<div class="extra4"><div>' );
			this.$extra5 = $( '<div class="extra5"><div>' );
			this.$facebook = $( '<div class="ff-facebook"><div>' );
			this.$twitter = $( '<div class="ff-twitter"><div>' );
			this.$linkedin = $( '<div class="ff-linkedin"><div>' );
			this.$pinterest = $( '<div class="ff-pinterest"><div>' ); 
			this.$details = $( '<div class="og-details"></div>' ).append( this.$title, this.$description, this.$facebook, this.$twitter, this.$linkedin, this.$pinterest, this.$href );
			this.$extra = $( '<div class="og-extra"></div>' ).append( this.$extra1, this.$extra2, this.$extra3, this.$extra4, this.$extra5 );
			this.$loading = $( '<div class="og-loading"></div>' );
			this.$fullimage = $( '<div class="og-fullimg"></div>' ).append( this.$loading ).append( this.$imageUrl );
			this.$fullvideo = $( '<div class="og-video"></div>' );
			this.$fullaudio = $( '<div class="og-audio"></div>' );	
			this.$closePreview = $( '<span class="og-close"></span>' );
			this.$previewInner = $( '<div class="og-expander-inner"></div>' ).append( this.$closePreview, this.$fullimage, this.$fullvideo, this.$fullaudio, this.$details, this.$extra );
			
			this.$previewEl = $( '<div class="og-expander"></div>' ).append( this.$previewInner );
			// append preview element to the item
			this.$item.append( this.getEl() );
			// set the transitions for the preview and the item
			if( support ) {
				this.setTransition();
			}
		},
		update : function( $item ) {

			if( $item ) {
				this.$item = $item;
			}
			
			// if already expanded remove class "og-expanded" from current item and add it to new item
			if( current !== -1 ) {
				var $currentItem = $items.eq( current );
				$currentItem.removeClass( 'og-expanded' );
				this.$item.addClass( 'og-expanded' );
				// position the preview correctly
				this.positionPreview();
			}

			// update current value
			current = this.$item.index();
			
			
			// update preview´s content
			var $itemEl = this.$item.children( 'a' ),
				eldata = {
					href : $itemEl.attr( 'href' ),
					target : $itemEl.data( 'linktarget' ),
					label : $itemEl.data( 'buttonlabel' ),
					largesrc : $itemEl.data( 'largesrc' ),
					title : $itemEl.data( 'title' ),
					description : $itemEl.data( 'description' ),
					format: $itemEl.data( 'format' ),
					video : this.$item.children( '.ff-video-container' ).html(),
					audio : this.$item.children( '.ff-audio-container' ).html(),
					extraIcon1 : $itemEl.data( 'extra-icon-1' ),
					extraLabel1 : $itemEl.data( 'extra-label-1' ),
					extraValue1 : $itemEl.data( 'extra-value-1' ),
					extraIcon2 : $itemEl.data( 'extra-icon-2' ),
					extraLabel2 : $itemEl.data( 'extra-label-2' ),
					extraValue2 : $itemEl.data( 'extra-value-2' ),
					extraIcon3 : $itemEl.data( 'extra-icon-3' ),
					extraLabel3 : $itemEl.data( 'extra-label-3' ),
					extraValue3 : $itemEl.data( 'extra-value-3' ),
					extraIcon4 : $itemEl.data( 'extra-icon-4' ),
					extraLabel4 : $itemEl.data( 'extra-label-4' ),
					extraValue4 : $itemEl.data( 'extra-value-4' ),
					extraIcon5 : $itemEl.data( 'extra-icon-5' ),
					extraLabel5 : $itemEl.data( 'extra-label-5' ),
					extraValue5 : $itemEl.data( 'extra-value-5' ),
					facebook : $itemEl.data( 'facebook' ),
					twitter : $itemEl.data( 'twitter' ),
					linkedin : $itemEl.data( 'linkedin' ),
					pinterest : $itemEl.data( 'pinterest' )		
				};
			
			if (eldata.format == 'image' || eldata.format == '') {
				$( '.og-fullimg' ).show();
				$( '.og-video' ).hide();
				$( '.og-audio' ).hide();
				var formaticon = '<span class="ff-icon-pictures6"></span>';
			}
			
			if (eldata.format == 'video') {
				$( '.og-video' ).empty();
				$( '.og-video' ).append(eldata.video);
				$( '.og-fullimg' ).hide();
				$( '.og-video' ).show();
				$( '.og-audio' ).hide();
				var formaticon = '<span class="ff-icon-play10"></span>';
			}
			
			if (eldata.format == 'audio') {
				$( '.og-audio' ).empty();
				$( '.og-audio' ).append(eldata.audio);
				$( '.og-fullimg' ).hide();
				$( '.og-video' ).hide();
				$( '.og-audio' ).show();
				var formaticon = '<span class="ff-icon-music9"></span>';
			}
			
			
			this.$title.html( formaticon + ' ' + eldata.title );
			this.$description.html( eldata.description );
			
			// Empty Previous data
			this.$extra1.empty();
			this.$extra2.empty();
			this.$extra3.empty();
			this.$extra4.empty();
			this.$extra5.empty();
			
			if(eldata.extraValue1) {
			this.$extra1.html( '<span class="extralabel-icon ' + eldata.extraIcon1 + '"></span> <span class="extralabel"> ' + eldata.extraLabel1 + '</span>' + '<div class="extravalue">' + eldata.extraValue1 + '</div> ' );
			}else{
			this.$extra1.html();
			}
			
			if(eldata.extraValue2) {
			this.$extra2.html( '<span class="extralabel-icon ' + eldata.extraIcon2 + '"></span> <span class="extralabel"> ' + eldata.extraLabel2 + '</span>' + '<div class="extravalue">' + eldata.extraValue2 + '</div> ' );
			}else{
			this.$extra2.html();
			}
			
			if(eldata.extraValue3) {
			this.$extra3.html( '<span class="extralabel-icon ' + eldata.extraIcon3 + '"></span> <span class="extralabel"> ' + eldata.extraLabel3 + '</span>' + '<div class="extravalue">' + eldata.extraValue3 + '</div> ' );
			}else{
			this.$extra3.html();
			}
			
			if(eldata.extraValue4) {
			this.$extra4.html( '<span class="extralabel-icon ' + eldata.extraIcon4 + '"></span> <span class="extralabel"> ' + eldata.extraLabel4 + '</span>' + '<div class="extravalue">' + eldata.extraValue4 + '</div> ' );
			}else{
			this.$extra4.html();
			}
			
			if(eldata.extraValue5) {
			this.$extra5.html( '<span class="extralabel-icon ' + eldata.extraIcon5 + '"></span> <span class="extralabel"> ' + eldata.extraLabel5 + '</span>' + '<div class="extravalue">' + eldata.extraValue5 + '</div> ' );
			}else{
			this.$extra5.html();
			}
			
			// Empty previous data
			this.$href.empty();
			
			if(eldata.href != ''){
				this.$href.css( 'display', 'inline-block' );
				this.$href.attr( 'href', eldata.href );
				this.$href.attr( 'target', eldata.target );
				this.$href.addClass( 'ff-link' );
				this.$href.append( eldata.label );
			}else{
				this.$href.css( 'display', 'none' );
				this.$href.empty();
			}
			
			
			// Empty Previous data
			this.$facebook.empty();
			this.$twitter.empty();
			this.$linkedin.empty();
			this.$pinterest.empty();
			
			if (eldata.href != '' && eldata.facebook != '') {
				
				this.$facebook.append('<a href="https://www.facebook.com/sharer/sharer.php?u=' + $itemEl.attr( 'href' ) + '" target="_blank" class="ff-icon-facebook10"></a>');
				
			}else{
				
				this.$facebook.empty();
				
			}
			
			if (eldata.href != '' && eldata.twitter != '') {
				
				this.$facebook.append('<a href="http://twitter.com/home?status=' + $itemEl.attr( 'href' ) + '" target="_blank" class="ff-icon-twitter8"></a>');
				
			}else{
				
				this.$twitter.empty();
				
			}
			
			if (eldata.href != '' && eldata.linkedin != '') {
				
				this.$facebook.append('<a href="http://www.linkedin.com/shareArticle?mini=true&url=' + $itemEl.attr( 'href' ) + '" target="_blank" class="ff-icon-linkedin5"></a>');
				
			}else{
				
				this.$linkedin.empty();
				
			}
			
			if (eldata.href != '' && eldata.pinterest != '') {
				
				this.$facebook.append('<a href="http://pinterest.com/pin/create/button/?url=' + $itemEl.attr( 'href' ) + '" target="_blank" class="ff-icon-pinterest5"></a>');
				
			}else{
				
				this.$pinterest.empty();
				
			}

			var self = this;
			
			// remove the current image in the preview
			if( typeof self.$largeImg != 'undefined' ) {
				self.$largeImg.remove();
			}

			// preload large image and add it to the preview
			// for smaller screens we don´t display the large image (the media query will hide the fullimage wrapper)
			if( self.$fullimage.is( ':visible' ) ) {
				this.$loading.show();
				$( '<img/>' ).load( function() {
					var $img = $( this );
					if( $img.attr( 'src' ) === self.$item.children('a').data( 'largesrc' ) ) {
						self.$loading.hide();
						self.$fullimage.find( 'img' ).remove();
						self.$largeImg = $img.fadeIn( 350 );
						self.$fullimage.append( self.$largeImg );
					}
				} ).attr( 'src', eldata.largesrc ).attr('class', 'og-preview-image').attr('data-fullsrc', self.$item.children('a').data( 'fullsrc' ));	
			}

		},
		open : function() {

			setTimeout( $.proxy( function() {	
				// set the height for the preview and the item
				this.setHeights();
				// scroll to position the preview in the right place
				this.positionPreview();
			}, this ), 25 );

		},
		close : function() {

			var self = this,
				onEndFn = function() {
					if( support ) {
						$( this ).off( transEndEventName );
					}
					self.$item.removeClass( 'og-expanded' );
					self.$previewEl.remove();
				};

			setTimeout( $.proxy( function() {

				if( typeof this.$largeImg !== 'undefined' ) {
					this.$largeImg.fadeOut( 'fast' );
				}
				this.$previewEl.css( 'height', 0 );
				// the current expanded item (might be different from this.$item)
				var $expandedItem = $items.eq( this.expandedIdx );
				$expandedItem.css( 'height', $expandedItem.data( 'height' ) ).on( transEndEventName, onEndFn );

				if( !support ) {
					onEndFn.call();
				}

			}, this ), 25 );
			
			return false;

		},
		calcHeight : function() {

			var heightPreview = winsize.height - this.$item.data( 'height' ) - marginExpanded,
				itemHeight = winsize.height;

			if( heightPreview < settings.minHeight ) {
				heightPreview = settings.minHeight;
				itemHeight = settings.minHeight + this.$item.data( 'height' ) + marginExpanded;
			}

			this.height = heightPreview;
			this.itemHeight = itemHeight;

		},
		setHeights : function() {

			var self = this,
				onEndFn = function() {
					if( support ) {
						self.$item.off( transEndEventName );
					}
					self.$item.addClass( 'og-expanded' );
				};

			this.calcHeight();
			this.$previewEl.css( 'height', this.height );
			this.$item.css( 'height', this.itemHeight ).on( transEndEventName, onEndFn );

			if( !support ) {
				onEndFn.call();
			}

		},
		positionPreview : function() {

			// scroll page
			// case 1 : preview height + item height fits in window´s height
			// case 2 : preview height + item height does not fit in window´s height and preview height is smaller than window´s height
			// case 3 : preview height + item height does not fit in window´s height and preview height is bigger than window´s height
			var position = this.$item.data( 'offsetTop' ),
				previewOffsetT = this.$previewEl.offset().top - scrollExtra,
				scrollVal = this.height + this.$item.data( 'height' ) + marginExpanded <= winsize.height ? position : this.height < winsize.height ? previewOffsetT - ( winsize.height - this.height ) : previewOffsetT;
			
			$body.animate( { scrollTop : scrollVal }, settings.speed );

		},
		setTransition  : function() {
			this.$previewEl.css( 'transition', 'height ' + settings.speed + 'ms ' + settings.easing );
			this.$item.css( 'transition', 'height ' + settings.speed + 'ms ' + settings.easing );
		},
		getEl : function() {
			return this.$previewEl;
		}
	}

	return { 
		init : init,
		addItems : addItems
	};

})();


$(function() {
	
	Grid.init();

});



});
});