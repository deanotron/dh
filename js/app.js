/*
	MAIN APP
*/


(function() {
  var currentPage, getTransitionRoot, init, root, siteScrollPos, transitionPop, transitionStack, transitionTo,
    __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  root = this;

  root.app = {};

  /*
  
  
  	SHOW and HIDE the purchase form with some opacity and menu shifting
  	
  	
  	----------    OVERLAY    --------------------
  */


  transitionStack = ['site'];

  currentPage = 'site';

  siteScrollPos = 0;

  getTransitionRoot = function(page) {
    if (page === 'site') {
      return $('#site-root');
    } else if (page === 'purchase') {
      return $('#purchase-root');
    } else if (page === 'terms') {
      return $('#terms-root');
    }
  };

  transitionTo = function(page) {
    var $from, $to, f, f2;
    $from = getTransitionRoot(currentPage);
    $to = getTransitionRoot(page);
    console.log("TRANSITION FROM TO ", currentPage, page);
    if (currentPage === 'site') {
      siteScrollPos = $(window).scrollTop();
    }
    if (page === 'site') {
      $('.navigation').show();
      $('#menu-purchase').show();
      $('#back-nav').hide();
    } else {
      $('.navigation').hide();
      $('#menu-purchase').hide();
      $('#back-nav').show();
    }
    $from.css('opacity', 0);
    f = function() {
      $from.hide();
      $to.show();
      if (page === 'site') {
        return $(window).scrollTop(siteScrollPos);
      } else {
        return $(window).scrollTop(0);
      }
    };
    setTimeout(f, 500);
    f2 = function() {
      return $to.css('opacity', 1);
    };
    setTimeout(f2, 800);
    if (__indexOf.call(transitionStack, page) < 0) {
      transitionStack.push(page);
    }
    return currentPage = page;
  };

  window.transitionTo = transitionTo;

  transitionPop = function() {
    transitionStack.pop();
    return transitionTo(_.last(transitionStack));
  };

  init = function(app) {
    console.log("APP INIT page xx", $('body').hasClass('account-page'));
    $(document).load().scrollTop(0);
    $(window).scrollTop(0);
    app.mod = Module;
    app.mod.onScroll();
    app.accordian = new AccordianArchitect(app, '.slat');
    app.accordian.architect();
    app.accordian.init();
    app.menu = new MobileMenu('nav.navigation');
    app.menu.init();
    console.log("ON ACCOUNT Page ??? ", $('body').hasClass('account-page'));
    if ($('body').hasClass('account-page')) {
      setupAccountPage();
      return setupPremiumDomainPage();
    } else {
      setupPortalHandlers();
      setupProductChoice();
      setupPremiumDomainPage();
      setupFormSubmit();
      setupMailerSignup();
      return setupIntroScrim();
    }
  };

  $(document).on('ready', function() {
    return init(root.app);
  });

}).call(this);
