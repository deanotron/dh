###
	jQuery Slider Plugin v1.0.0
	https://github.com/cmisura/stream.js
	
	Copyright 2014 Clayton Misura
	Released under the MIT license
###

do ($ = jQuery, window, document) ->

	pluginName = 'stream'

	defaults =

		center			: true
		controls		: true 
		nav				: true 
		overflow		: 'hidden'
		width			: 500


	# The actual plugin constructor
	class Plugin
		constructor: (@element, options) ->
  
			@settings				= $.extend {}, defaults, options
			@_defaults				= defaults
			@_name					= pluginName
			
			@streamItemsContainer	= $( @element ).find '.stream-items'
			@streamItems			= $( @element ).find '.stream-item'
			@streamLength			= @streamItems.length
			@streamWidth			= -> return ( @streamLength * @settings.width )	  
			
			@lastItem				= null

			@init()

		init: ->

			console.log '=== PLUGIN DEFAULTS / EXTENDED -->', defaults, @settings
			self = this 

			# IF THE DEFAULTS WIDTH IS 100% SET IT TO THE WIDTH OF THE PARENT CONTAINER 
			if @settings.width is '100%'

				@settings.width = $( @element ).width() 

			# PREVENT RUBBER BANDING
			# TURN OFF, PREVENT DEFAULT DISABLES SCROLLING
			# if Modernizr.touch 
				
			#	  $( document ).on 'touchmove', ( e ) -> e.preventDefault()

			# SET IT UP
			@buildStream()
			@setupStreamItems()
			@moveStream()
			@controlStreamDirection()


			# SHOW THE STREAM
			clearTimeout( ID )

			showItems = ->
				self.streamItemsContainer.css 'opacity', 1 
				$( 'body' ).find( '.stream-dots' ).css 'opacity', 1

			ID = window.setTimeout( showItems, 1000 )

		buildStream: ->

			console.log( '=== BUILD STREAM -->', @element )

			# SET THE WIDTH & OVERFLOW
			$( @element ).css 'width', @settings.width

			$( @element ).css
				'overflow-x'	: @settings.overflow
				'overflow-y'	: 'hidden'

			# CENTER THE CONTAINER AND/OR CREATE NAV
			if @settings.center	 then @centerStream()
			if @settings.nav	 then @setupStreamNav()

		centerStream: ->

			console.log( '=== CENTER STREAM' )

			$( @element ).addClass 'state-centered'			 

		setupStreamItems: ->

			console.log( '=== SETUP STREAM' )

			self			= this
			streamLength	= @streamLength - 1

			@streamItemsContainer.css 'width', @streamWidth()  

			$.each @streamItems , ( index, streamItem ) ->
				
				streamItem = $ streamItem

				# SET GENERAL PROPERTIES
				opts =

					width	 : self.settings.width
					# height	 : streamItem.height()

				streamItem.css( opts )
				streamItem.attr 'data-height', streamItem.height()
				streamItem.attr 'data-index', index
				
				# SET SPECIFIC PROPERTIES
				if index is		0 then streamItem.attr 'data-focus', 'true' 
				if index isnt	0 then streamItem.attr 'data-focus', 'false'
				# if index is	  streamLength	  then streamItem.addClass 'stream-terminus'

		setupStreamNav: ->

			self		 = this 
			streamLength = @streamLength - 1
			container	 = $( 'body' ).find @element

			$( '<div class="stream-dots" />' ).insertBefore( container )

			for i in [ 0..streamLength ]
				
				$( "<a class='stream-dot' href='#' data-index='#{i}'><span></span></a>" ).appendTo( '.stream-dots' )

			$( '.stream-dot' ).eq( 0 ).addClass 'state-active'

			unless @settings.center

				$( '.stream-dots' ).css 'text-align', 'left'

		updateStreamHeight : ( currentItem ) ->

			unless currentItem

				currentItem = $( '.stream-item' ).eq( 0 )

			self 		 = this
			evalHeight 	 = currentItem.height() + 44 
			slat 		 = $( @element ).closest '.slat'
			productPrice = slat.find '.product-includes-list'

			console.log '=== UPDATE STREAM', evalHeight

			if Modernizr.touch

				productPrice
				.removeClass( 'state-visible' )
				.addClass 'state-hidden'

				productPrice.find( '.icon' )
				.removeClass( 'icon-arrow_down' )
				.addClass( 'icon-arrow_up' )

				slat.css
					height  		: 'auto'
					'max-height'	: '100%'

				$( @element ).css 'height', evalHeight 

			else

				$( @element ).css 'height', evalHeight 
			
			console.log "UPDATE STREAM HEIGHT :: ", @lastItem
			# at the end scroll to the top	-- but only on slide not for open
			if @lastItem
				target = $( @element ).parent().parent().parent().offset().top
				window.scrollToOffset(target)
			
			@lastItem = currentItem


		moveStream : ( action, destination ) ->

			self			= this
			streamLength	= @streamLength - 1
			
			updateNav = ->

					currentItem		= $ '*[data-focus="true"]'
					nextIndex		= parseInt currentItem.attr( 'data-index' )
					dots			= $( '.stream-dot' ) 
					dot				= $( '.stream-dots' ).find "[data-index='#{nextIndex}']"  

					dots.removeClass 'state-active'
					dot.addClass 'state-active'

			moveTo = 

				next: ->

					currentItem		= $ '*[data-focus="true"]'
					nextItem		= currentItem.next()
					index			= parseInt currentItem.attr( 'data-index' )
					nextIndex		= parseInt nextItem.attr( 'data-index' )

					unless index is streamLength 

						location	= nextItem.position().left 
						currentItem.attr	'data-focus', 'false'
						nextItem.attr		'data-focus', 'true'

						self.streamItemsContainer.css 'transform', "translate3d( -#{location}px, 0, 0 )"

						f = -> 	self.updateStreamHeight( nextItem )

						setTimeout( f, 500 )
				
						if self.settings.nav then updateNav()

					else return

				prev: ->

					currentItem		= $ '*[data-focus="true"]'
					prevItem		= currentItem.prev()
					index			= parseInt currentItem.attr( 'data-index' ) 

					unless index is 0 

						location = prevItem.position().left 

						currentItem.attr	'data-focus', 'false'
						prevItem.attr		'data-focus', 'true'

						self.streamItemsContainer.css 'transform', "translate3d( -#{location}px, 0, 0 )"

						f = -> self.updateStreamHeight( prevItem )

						setTimeout( f, 500 )

						if self.settings.nav then updateNav()

					else return

				teleport: ( endpoint ) ->


					currentItem		= $ '*[data-focus="true"]'
					teleportItem	= self.streamItemsContainer.find "[data-index='#{endpoint}']"  
					location		= teleportItem.position().left	

					currentItem.attr	'data-focus', 'false'
					teleportItem.attr	'data-focus', 'true'

					self.streamItemsContainer.css 'transform', "translate3d( -#{location}px, 0, 0 )"

					f = -> 	self.updateStreamHeight( nextItem )

					setTimeout( f, 500 )

			if action is 'next'		then moveTo.next()
			if action is 'prev'		then moveTo.prev()
			if action is 'teleport' then moveTo.teleport( destination )


		controlStreamDirection : ->

			self = this 
			dots = $( 'body' ).find '.stream-dots .stream-dot'
			
			# NEXT AND PREVIOUS CONTROLS
			if @settings.controls

				$( '.stream-controller' ).on 'click', ( e ) ->

					console.log '=== STREAM DIRECTION ', e

					e.preventDefault()
					e.stopPropagation()

					button = $( this )

					if button.hasClass( 'next-item' ) then self.moveStream( 'next' )
					if button.hasClass( 'prev-item' ) then self.moveStream( 'prev' )
					if button.hasClass( 'prev-item-two' )
						self.moveStream( 'prev' )
						self.moveStream( 'prev' )


			# DOT NAVIGATION
			if @settings.nav 

				$( 'body' ).on 'click', '.stream-dot', ( e ) ->

					e.preventDefault()
					e.stopPropagation()

					dot		= $( this )
					index	= parseInt dot.attr( 'data-index' )

					dots.removeClass	'state-active'
					dot.addClass		'state-active'

					self.moveStream( 'teleport', index )

			 # TOUCH DEVICES
			#if Modernizr.touch
				
				# INIT TOUCHES[]
				# touches = []

				# $( @element ).on 'touchstart', ( e ) ->

				# 	# e.preventDefault()
				# 	e.stopPropagation()

				# 	# RESET TOUCHES[] ON START
				# 	touches = []
				
				# $( @element ).on 'touchmove', ( e ) ->

				# 	# e.preventDefault()
				# 	e.stopPropagation()

				# 	boundry		= $( this )
				# 	element		= boundry.offset()
				# 	touch		= e.originalEvent.touches[0] or e.originalEvent.changedTouches[0]
				# 	x			= touch.pageX - element.left;
				# 	y			= touch.pageY - element.top;

				# 	# STOP TOUCHMOVE FROM FIRING OUTSIDE ELE BOUNDRIES
				# 	if x < boundry.width() and x > 0

				# 		if y < boundry.height() and y > 0 

				# 			touches.push( touch.pageX )


				# $( @element ).on 'touchend', ( e ) ->

				# 	# e.preventDefault()	
				# 	e.stopPropagation()
				  
				# 	end = touches.length - 1

				# 	# EVAL TOUCHES DIRECTION ON END
				# 	if touches[ end ] > touches[ 0 ] then self.moveStream( 'prev' )
				# 	else self.moveStream( 'next' )
	
					
	$.fn[pluginName] = (options) ->
		@each ->
			if !$.data(@, "plugin_#{pluginName}")
				$.data(@, "plugin_#{pluginName}", new Plugin(@, options))
			else
				stream = $.data(@, "plugin_#{pluginName}")
				
				if options in ['next', 'prev']
					stream.moveStream( options )

				if options is 'updateStreamHeight'
					stream.updateStreamHeight()

