$		 = jQuery
Module	 = {}
Module or= {}


###
	Clay, we need to setup a style guide so that our code is consistent.. there are a few things
	that I like from your style, but a couple things are bugging me.
	
	Notes for future discussion of style guide:
	-	never use root as variable name, always set root = this at the beginning of the document..
		this is a node convention to allow root to be window in the browser and process for the server
	-	the line break right after defining a function really breaks readability for me.  I like spaces after
		the end of blocks, but at the beginning it creates confusing space
	-	I like your method of lining up variables in a block, I usually don't do it out of laziness but this
		can be kept
	-
	
###

###
	DEAN - SOUNDS GOOD, AS LONG AS I CAN LINE UP MY VARS :-)
###

# MOBILE MENU

class MobileMenu

	constructor : ( element ) ->

		@defaults =

			element		: $ element 
			root		: $ window
			state		: 'ready'

	setState : ( state ) ->	 @defaults.state = state
	getState : () -> return @defaults.state

	debounce : ( fn, delay ) ->

		delay or= 100
		timer	 = null

		return ->

			context = this
			args	= arguments 
			start	= -> fn.apply( context, args )

			clearTimeout( timer )
			timer = setTimeout( start, delay )

	monitor : ( opts ) ->

		screenWidth = $( window ).width()
		breakpoint	= 768
		ul			= opts.element.find 'ul'
		icon		= opts.element.find 'a.icon'	

		console.log '==== WIN WIDTH', screenWidth

		actions = 

			collapse : ->

				icon.remove()
				opts.element.addClass 'state-collapsed'
				opts.element.prepend  '<a class="icon menu-hidden" href=""><span></span></a>'

				ul.css 
					width			: screenWidth
					opacity 		: 1
					visibility  	: 'visible'

				console.log '==== COLLAPSE MENU ===='

			expand	 : ->

				icon.remove()
				opts.element.removeClass 'state-collapsed'
			 
				console.log '==== EXPAND MENU ===='

		if screenWidth <= breakpoint then actions[ 'collapse' ]()
		if screenWidth >  breakpoint then actions[ 'expand' ]()

	onResize : -> 

		self	  = this
		fn		  = -> self.monitor( self.defaults ) 
		debounced = @debounce( fn, 250 )

		if @getState() is 'ready'

			debounced()
			@setState( 'complete' )

		if @getState() is 'complete'

			@defaults.root.on 'resize', debounced 
	
	
	onClick : ->

		state = 'closed'

		@defaults.element.on 'click', 'a.icon', ( e ) ->

			e.preventDefault()

			self   = $ this
			parent = self.parent()

			if state is 'closed'

				parent.find( 'ul' ).removeClass()
				parent.find( 'ul' ).addClass 'state-visible'

				state = 'open'

			else if state is 'open'

				parent.find( 'ul' ).removeClass()
				parent.find( 'ul' ).addClass 'state-hidden'

				state = 'closed'

	offClick : ->

		icon = @defaults.element.find 'a.icon'

		icon.off 'click'


	init : ->

		@onResize()
		@onClick()


# ACCORIDAN

class AccordianArchitect

	constructor : ( app, element ) ->
		
		@element  = $ element
		@root	  = $ window
		@body	  = $ 'body'
		@state	  = ''
		@app	  = app

		@defaults =
			bulletin				: $ '#site-bulletin'
			slatHeight				: 96

	setState : ( state ) -> @state = state

	architect : ( options ) ->	 

		$.extend @defaults, options

		slats = @element
		opts  =
			opacity					: 0
			'margin-top'			: 64
			visibility				: 'hidden'
 
		slats.css opts 

		$.each slats, ( index, slat ) ->
		
			slat = $ slat
   			
			if index is 0
				slat.attr 'data-id',		"slat-#{index}"
				slat.attr 'data-state',		'expanded'
				slat.addClass 				'state-expanded'
				slat.attr 'data-height',	'*'
			else
				slat.attr 'data-id',		"slat-#{index}"
				slat.attr 'data-state',		'collapsed'
				slat.attr 'data-height',	'*'
	   
		@setState 'ready'

	renderData : ( id ) ->

		console.log '=== RENDER DATA', id

		clearTimeout( _ID )

		root		= $ "[data-id=\"#{id}\"]" 
		tmps		= new TemplateArchitect
		header		= $ '#site-header'
		button		= root.find( '.slat-header' ).find 'a.button'
		body		= ''
		toRender	= ''   

		toRender = switch
			when id is 'slat-0' then Templates.Features
			when id is 'slat-1' then Templates.Buy

		fn = ( data ) -> $( this.template( data ) ).insertAfter( root.find '.slat-header' )

		tmps.add "#{id}", 'slat-content', toRender, fn

		render = ->

			tmps.build "#{id}", 'slat-content'

			root.removeClass   'state-collapsed'
			root.addClass	   'state-expanded'
			root.attr		   'data-state', 'expanded'

			# INIT STREAM
			$( '.stream-container' ).stream { center: true, width: '100%', controls: true, nav: false }
	
		# RENDER AND THEN SCROLL
		render()

		opts = 

			scrollTo	: root.offset().top - header.height()
			ease		: Power2.easeIn
			# onComplete  : render

		tween = new TimelineMax()	 
		tween.to( window, 0.5, opts )

		f  = -> 

			body = root.find '.slat-body'	
			root.css 'max-height', "#{root.height()}px"

		_ID = window.setTimeout( f, 1000 )


	removeData : ( id ) ->

		self	= this
		root	= $ "[data-id=\"#{id}\"]" 
		parent	= root.find '.slat-body'
		head	= root.find '.slat-header'
		button	= head.find 'a.button'
		header	= $ '#site-header'
		tween	= new TimelineMax()
		delay	= 500

		remove = -> 

			root.removeClass	'state-expanded'
			root.addClass		'state-collapsed'
			root.attr			'data-state', 'collapsed'

			elastic = ->

				clearTimeout( timer )

				root.css 'max-height', ''
				button.text( button.attr 'data-text' )

				clear = -> parent.remove()
				timer = setTimeout( clear, 500 )

			opts =

				'max-height'	: head.height()
				ease			: Power1.easeIn
				onComplete		: elastic 

			tween.to( root, 0.5, opts )	 

		opts =

			scrollTo		: root.offset().top - header.height()
			ease			: Circ.easeOut
			onComplete		: remove


		tween.to( window, 0.5, opts )
	
	
	expand : ( slat ) ->
		console.log '=== RENDER DATA', slat

		clearTimeout( _ID )
		self 		= this 
		content		= slat.find '.content'
		header		= $ '#site-header'
		button		= slat.find( '.slat-header' ).find 'a.button'
		body		= slat.find '.slat-body'

		render = ->
			slat.removeClass   'state-collapsed'
			slat.addClass	   'state-expanded'
			slat.attr		   'data-state', 'expanded'

			# INIT STREAM
			$( '.stream-container' ).stream { center: true, width: '100%', controls: true, nav: false }

			if slat.attr( 'id' ) is 'slat-1'

				$( '.stream-container' ).stream( 'updateStreamHeight' )


		# RENDER AND THEN SCROLL
		render()

		opts = 
			scrollTo	 : slat.offset().top - header.height()
			ease		: Power2.easeIn
			# onComplete  : render
	
		tween = new TimelineMax()	 
		tween.to( window, 0.5, opts )

		f = -> 
			body = root.find '.slat-body'	
			# slat.css 'max-height', "#{slat.height()}px"
			button.find( 'span' ).text( 'close' )

		_ID = setTimeout( f, 1000 )			
	
	collapse : ( slat ) ->
		self	= this
		content = slat.find '.content'
		body	= slat.find '.slat-body'
		head	= slat.find '.slat-header'
		button	= head.find 'a.button'
		header	= $ '#site-header'
		tween	= new TimelineMax()
		delay	= 500

		remove = -> 
			slat.removeClass	'state-expanded'
			slat.addClass		'state-collapsed'
			slat.attr			'data-state', 'collapsed'

			elastic = ->
				slat.css 'max-height', ''
				button.find( 'span' ).text( 'open' )

			opts =
				'max-height'	: head.height()
				ease			: Power1.easeIn
				onComplete		: elastic 
			tween.to( slat, 0.5, opts )	 
			
		remove()
		
		# console.log "NO REMOVE -- Collapse only"
		# opts =
		#	scrollTo		: slat.offset().top - header.height()
		#	ease			: Circ.easeOut
		#	onComplete		: remove
		# tween.to( window, 0.5, opts )
	

	onClick : -> 
		self  = this
		slats = @element.find '.slat-header.slat-control'
		
		console.log "=== ASSIGN SLAT TOGGLE xx", @element.length, slats.length
		
		slats.on 'click', ( e ) ->
			e.preventDefault()
			e.stopPropagation()
			
			slat = $( this ).parent()
			state = slat.attr 'data-state' 
			
			console.log "SLAT state -- ", state
			if state is 'collapsed' then self.expand slat			 
			if state is 'expanded'	then self.collapse slat
			
		
		# animate up only on clicking the footers
		close_arrows = @element.find '.slat-footer.slat-control'
		close_arrows.on 'click', ( e ) ->
			e.preventDefault()
			e.stopPropagation()
			
			head = $( this ).parent().find('.slat-header')
			window.scrollToOffset(head.offset().top)
			
			
	onLoad : ->
 		
		body 			= $ 'body'
		productList 	= $ '.product-includes-list'

		opts =
			opacity		   : 1
			'margin-top'   : 0
			visibility	   : 'visible'

		if @state is 'ready' 

			intro = new TimelineMax()
			intro.to body, 1, { autoAlpha : 1, ease : Power1.easeOut }
			intro.staggerTo @element, 0.3, opts, 0.2

		if Modernizr.touch

			productList.addClass 'state-hidden' 
			@pricePackage()

	pricePackage : ->
		
		self 			 = this 
		streamContainer  = $ '.stream-container'
		streamItems 	 = streamContainer.find '.stream-item'
		productPrice 	 = $ '.product-price'
		productContainer = $( '.product-container' ).not '.hide-for-phone'
		marginTop 		 = 16
		slat 			 = streamContainer.closest '.slat'
		slatHeader 		 = slat.find '.slat-header' 

		productPrice.on 'click', ( e )->

			e.preventDefault()
			e.stopPropagation()
			
			nsib  = $( this ).next()
			psib  = $( this ).prev()
			total = 0
			 

			if nsib.hasClass 'state-hidden'

				nsib 
				.removeClass( 'state-hidden' )
				.addClass( 'state-visible' )

				psib.find( '.icon' )
				.removeClass( 'icon-arrow_down' )
				.addClass( 'icon-arrow_up' )

			else

				nsib
				.removeClass( 'state-visible' )
				.addClass( 'state-hidden' )

				psib.find( '.icon' )
				.removeClass( 'icon-arrow_up' )
				.addClass( 'icon-arrow_down' )


			if streamItems.eq( 0 )

				$.each productContainer, ( index, item )->

					itemHeight = $( item ).height()
					total 	  += itemHeight

				streamContainer.css 'height', '100%'

				slat.css 
					'max-height' : ( ( slatHeader.height() * 2 ) + total + marginTop ) + 100
					height 		 : ( ( slatHeader.height() * 2 ) + total + marginTop ) + 100

	

	setBulletinHei : ->

		self	 = this
		head 	 = $ '#site-header'
		headHei	 = head.height()
		bulletin = @defaults.bulletin
		browser  = $ '.browser-container'
		vcenter  = bulletin.find '.vert-center-parent'

		bulletin.css 'height', $( window ).height()
		browser.css  'height', $( window ).height()
		
		if $( window ).height() < 1080 and not Modernizr.touch 

			browser.css 'padding', 0 

			$( '.site-bulletin-image' ).css 'background-image', 'none'

		else 
			$( '.site-bulletin-image' ).attr 'style', ''

	mediaFader: ( mediaList ) ->	
		return  # NO mediaFader
		
		self 	  	= this 
		bulletin 	= $ '#site-bulletin'
		covers 	  	= []
		credits 	= []

		countLimit  = mediaList.length - 1;
		counter 	= 0

		$.each mediaList, ( index, item ) ->

			zindex = index + 2

			covers.push  "<div data-id='cover-#{index}'  class='site-bulletin-cover' style='background-image: url( #{item.photo} ); z-index:-#{zindex}'></div>"
			credits.push "<div data-id='credit-#{index}' class='site-bulletin-credits'>#{item.name} uses Folio <br/> <a class='button model-underline' target='_blank' href='http://#{item.url}'><span>#{item.url}</span></a></div>"

		# CLEAR
		$( '.site-bulletin-cover' ).remove()
		$( '.site-bulletin-credits' ).remove()

		# ADD TO PARENT
		bulletin
		.append( credits.join( '' ) )
		.append( covers.join( '' ) )
	
		# ROTATE THE REST OF THE ITEMS

		if not Modernizr.touch or $( window ).width() > 1024

			# SET-UP THE FIRST ITEMS
			TweenMax.to 	$( "[data-id='cover-#{counter}']" ), 0.5, { autoAlpha : 1 }
			TweenMax.fromTo $( "[data-id='credit-#{counter}']" ), 0.5, { bottom: '-144px' }, { bottom: '32px' }

			rotateDesktop = ->

				TweenMax.fromTo $( "[data-id='cover-#{counter}']" ), 1, { autoAlpha : 1 }, { autoAlpha :0 }
				TweenMax.fromTo $( "[data-id='credit-#{counter}']" ), 0.5, { bottom: '32px' }, { bottom: '-144px' }

				if   counter is countLimit then counter = 0 
				else counter++ 

				TweenMax.fromTo $( "[data-id='cover-#{counter}']" ), 1, { autoAlpha : 0 }, { autoAlpha : 1 }
				TweenMax.fromTo $( "[data-id='credit-#{counter}']" ), 0.5, { bottom: '-144px' }, { bottom: '32px' }

			setInterval	rotateDesktop, 5000

		if Modernizr.touch or $( window ).width() <= 1024 

			$( '.site-bulletin-credits' ).hide()

			# SET-UP THE FIRST ITEMS
			TweenMax.to $( "[data-id='cover-#{counter}']" ), 0.5, { autoAlpha : 1 }
		
			rotateMobile = ->

				TweenMax.fromTo $( "[data-id='cover-#{counter}']" ), 1, { autoAlpha : 1 }, { autoAlpha :0 }
			
				if   counter is countLimit then counter = 0 
				else counter++ 

				TweenMax.fromTo $( "[data-id='cover-#{counter}']" ), 1, { autoAlpha : 0 }, { autoAlpha : 1 }
			
			setInterval	rotateMobile, 5000


		console.log '=== FADER ITEMS', covers, credits 


	animateText : ->

		self	 	= this
		bulletin 	= @defaults.bulletin	
		name 	 	= bulletin.find '.product-name'
		synopsis 	= bulletin.find '.product-synopsis'
		text 		= 'Focus on your work, not your website.'
		chars 		= []
		index 		= 0

		$.each text.split( '' ), ( index, char ) ->

			chars.push "<span class='char-#{index}'>#{char}</span>"

		clearTimeout( typeID )

		type = ->
			if index < chars.length

				name.append chars[ index ]

				index += 1

				fn = setTimeout( type, 100 )

			if index is chars.length

				synopsis.css 'opacity', 1

		typeID = setTimeout( type, 1250 )

	
	init : ->
		self 		  = this
		bulletin 	  = @defaults.bulletin	
		synopsis 	  = bulletin.find '.product-synopsis'
		mediaFaderObj = [
			
			{ name : 'Sacha Hurley',  photo : 'img/img-cover-sachahurley.jpg', url : 'sachahurley.com' }
			{ name : 'Also Known As', photo : 'img/img-cover-aka.jpg', url : 'folio.alsoknownas.ca' } 
			{ name : 'Mark DeLong',   photo : 'img/img-cover-markdelong.jpg', url : 'markdelong.ca' } 

			]

		@setBulletinHei() 
		# @mediaFader( mediaFaderObj )
		
		synopsis.css 'opacity', 1

		@onLoad()
		@onClick()

		resizeFn = ->
			self.setBulletinHei() 
			self.mediaFader( mediaFaderObj )

		debounceResize = _.debounce resizeFn, 250 

		$( window ).on 'resize', debounceResize

			
		
# HEADER 

Module.onScroll = ->

	root		= $ window 
	header		= $ '#site-header'
	delay		= 500
	
	console.log "BOUNDS /2"

	root.on 'scroll', ( e ) ->

		if !Modernizr.touch

			# DOES IT EXIST 
			if $( '.feature-container' ).length

				features		= $( 'body' ).find '.feature-container'
				bounds			= root.scrollTop() + ( root.height() / 2 )	
				parent			= $( '.feature-container' ).parents( '.slat' )
				top				= parent.position().top 
				bottom			= parent.position().top + parent.outerHeight( true ) 

				firstFeature	= features.eq( 0 ).offset().top

				for i in [ 0..features.length ]

					if i	  <= features.length - 1 then current = features.eq( i ).offset().top 
					if i + 1  <= features.length - 1 then next = features.eq( i + 1 ).offset().top 

					currentMedia = features.eq( i ).find 'img.feature-image'

					# IF THERE'S NOT ANOTHER FEATURE
					# USE THE BOTTOM OF THE PARENT ELEMENT AS THE BOUNDS
					if i + 1  is features.length - 1 then next = bottom

					# KEEP THE FIRST SLIDE ACITVE 
					# IF IT'S FURTHER DOWN THE PAGE
					if bounds <= firstFeature and bounds < next	 

						features.eq( 0 ).addClass 'state-active'	

					if bounds >= current and bounds < next

						features.eq( i ).addClass 'state-active'

						# if currentMedia.attr( 'data-media' )
						# 
						# 	unless currentMedia.attr( 'data-src' ) then currentMedia.attr 'data-src', currentMedia.attr( 'src' )
						# 	currentMedia.attr 'src', currentMedia.attr( 'data-media' )

					else

						features.eq( i ).removeClass 'state-active'

						if currentMedia.attr( 'data-src' )

							currentMedia.attr 'src', currentMedia.attr( 'data-src' )


		if root.scrollTop() > 1 then header.addClass 'is-scrolling'
		if root.scrollTop() < 1 then header.removeClass 'is-scrolling'

			# # DO SOMETHING WHEN SCROLL Stops
			# fn = -> header.removeClass 'is-scrolling'

			# clearTimeout( $.data( this, 'scrollTimer' ) )
			# $.data( this, 'scrollTimer', setTimeout( fn, delay ) )




root						= exports ? window 
root.AccordianArchitect		= AccordianArchitect 
root.MobileMenu				= MobileMenu
root.Module					= Module
	

