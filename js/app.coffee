###
	MAIN APP
###

root = this
root.app = {} 


###


	SHOW and HIDE the purchase form with some opacity and menu shifting
	
	
	----------    OVERLAY    --------------------
	
###
transitionStack = ['site']
currentPage = 'site'
siteScrollPos = 0

getTransitionRoot = (page) ->
	if page is 'site'
		return $('#site-root')
	else if page is 'purchase'
		return $('#purchase-root')
	else if page is 'terms'
		return $('#terms-root')

transitionTo = (page) ->
	$from = getTransitionRoot(currentPage)
	$to = getTransitionRoot(page)
	
	console.log "TRANSITION FROM TO ", currentPage, page
	
	if currentPage is 'site'
		siteScrollPos = $(window).scrollTop()
	
	if page is 'site'
		$('.navigation').show()
		$('#menu-purchase').show()
		$('#back-nav').hide()
	else
		$('.navigation').hide()
		$('#menu-purchase').hide()
		$('#back-nav').show()
		
	$from.css 'opacity', 0
		
	# transition
	f = -> 
		$from.hide()
		$to.show()
		if page is 'site'
			$(window).scrollTop(siteScrollPos)
		else
			$(window).scrollTop(0)
	setTimeout f, 500
	
	f2 = ->
		$to.css 'opacity', 1
	setTimeout f2, 800
	
	unless page in transitionStack
		transitionStack.push page
		
	currentPage = page

window.transitionTo = transitionTo

transitionPop = ->
	transitionStack.pop()
	transitionTo(_.last(transitionStack))






init = (app) ->
	console.log "APP INIT page xx", $('body').hasClass('account-page')
	
	# force back to the top -- for some reason attempts to set it are blocked
	# if mousewheel was used, revert to 0
	$(document).load().scrollTop(0)
	$(window).scrollTop(0)  # iphone ?
	
	
	
	app.mod = Module
	app.mod.onScroll()    
	
	app.accordian = new AccordianArchitect( app, '.slat' )
	app.accordian.architect()
	app.accordian.init()
	
	app.menu = new MobileMenu( 'nav.navigation' )   
	app.menu.init()
	
	console.log "ON ACCOUNT Page ??? ", $('body').hasClass('account-page')
	if $('body').hasClass('account-page')
		setupAccountPage()
		setupPremiumDomainPage()
	else
		setupPortalHandlers()
		setupProductChoice()
		setupPremiumDomainPage()
		setupFormSubmit()
		setupMailerSignup()
		setupIntroScrim()
	

$(document).on 'ready', -> init(root.app)
# window.onload = ->
# 	$('html').animate({scrollTop:0}, 1);
# 	$('body').animate({scrollTop:0}, 1);
	