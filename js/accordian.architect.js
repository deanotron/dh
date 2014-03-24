(function() {
  var $, AccordianArchitect, MobileMenu, Module, root;

  $ = jQuery;

  Module = {};

  Module || (Module = {});

  /*
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
  */


  /*
  	DEAN - SOUNDS GOOD, AS LONG AS I CAN LINE UP MY VARS :-)
  */


  MobileMenu = (function() {
    function MobileMenu(element) {
      this.defaults = {
        element: $(element),
        root: $(window),
        state: 'ready'
      };
    }

    MobileMenu.prototype.setState = function(state) {
      return this.defaults.state = state;
    };

    MobileMenu.prototype.getState = function() {
      return this.defaults.state;
    };

    MobileMenu.prototype.debounce = function(fn, delay) {
      var timer;
      delay || (delay = 100);
      timer = null;
      return function() {
        var args, context, start;
        context = this;
        args = arguments;
        start = function() {
          return fn.apply(context, args);
        };
        clearTimeout(timer);
        return timer = setTimeout(start, delay);
      };
    };

    MobileMenu.prototype.monitor = function(opts) {
      var actions, breakpoint, icon, screenWidth, ul;
      screenWidth = $(window).width();
      breakpoint = 768;
      ul = opts.element.find('ul');
      icon = opts.element.find('a.icon');
      console.log('==== WIN WIDTH', screenWidth);
      actions = {
        collapse: function() {
          icon.remove();
          opts.element.addClass('state-collapsed');
          opts.element.prepend('<a class="icon menu-hidden" href=""><span></span></a>');
          ul.css({
            width: screenWidth,
            opacity: 1,
            visibility: 'visible'
          });
          return console.log('==== COLLAPSE MENU ====');
        },
        expand: function() {
          icon.remove();
          opts.element.removeClass('state-collapsed');
          return console.log('==== EXPAND MENU ====');
        }
      };
      if (screenWidth <= breakpoint) {
        actions['collapse']();
      }
      if (screenWidth > breakpoint) {
        return actions['expand']();
      }
    };

    MobileMenu.prototype.onResize = function() {
      var debounced, fn, self;
      self = this;
      fn = function() {
        return self.monitor(self.defaults);
      };
      debounced = this.debounce(fn, 250);
      if (this.getState() === 'ready') {
        debounced();
        this.setState('complete');
      }
      if (this.getState() === 'complete') {
        return this.defaults.root.on('resize', debounced);
      }
    };

    MobileMenu.prototype.onClick = function() {
      var state;
      state = 'closed';
      return this.defaults.element.on('click', 'a.icon', function(e) {
        var parent, self;
        e.preventDefault();
        self = $(this);
        parent = self.parent();
        if (state === 'closed') {
          parent.find('ul').removeClass();
          parent.find('ul').addClass('state-visible');
          return state = 'open';
        } else if (state === 'open') {
          parent.find('ul').removeClass();
          parent.find('ul').addClass('state-hidden');
          return state = 'closed';
        }
      });
    };

    MobileMenu.prototype.offClick = function() {
      var icon;
      icon = this.defaults.element.find('a.icon');
      return icon.off('click');
    };

    MobileMenu.prototype.init = function() {
      this.onResize();
      return this.onClick();
    };

    return MobileMenu;

  })();

  AccordianArchitect = (function() {
    function AccordianArchitect(app, element) {
      this.element = $(element);
      this.root = $(window);
      this.body = $('body');
      this.state = '';
      this.app = app;
      this.defaults = {
        bulletin: $('#site-bulletin'),
        slatHeight: 96
      };
    }

    AccordianArchitect.prototype.setState = function(state) {
      return this.state = state;
    };

    AccordianArchitect.prototype.architect = function(options) {
      var opts, slats;
      $.extend(this.defaults, options);
      slats = this.element;
      opts = {
        opacity: 0,
        'margin-top': 64,
        visibility: 'hidden'
      };
      slats.css(opts);
      $.each(slats, function(index, slat) {
        slat = $(slat);
        if (index === 0) {
          slat.attr('data-id', "slat-" + index);
          slat.attr('data-state', 'expanded');
          slat.addClass('state-expanded');
          return slat.attr('data-height', '*');
        } else {
          slat.attr('data-id', "slat-" + index);
          slat.attr('data-state', 'collapsed');
          return slat.attr('data-height', '*');
        }
      });
      return this.setState('ready');
    };

    AccordianArchitect.prototype.renderData = function(id) {
      var body, button, f, fn, header, opts, render, root, tmps, toRender, tween, _ID;
      console.log('=== RENDER DATA', id);
      clearTimeout(_ID);
      root = $("[data-id=\"" + id + "\"]");
      tmps = new TemplateArchitect;
      header = $('#site-header');
      button = root.find('.slat-header').find('a.button');
      body = '';
      toRender = '';
      toRender = (function() {
        switch (false) {
          case id !== 'slat-0':
            return Templates.Features;
          case id !== 'slat-1':
            return Templates.Buy;
        }
      })();
      fn = function(data) {
        return $(this.template(data)).insertAfter(root.find('.slat-header'));
      };
      tmps.add("" + id, 'slat-content', toRender, fn);
      render = function() {
        tmps.build("" + id, 'slat-content');
        root.removeClass('state-collapsed');
        root.addClass('state-expanded');
        root.attr('data-state', 'expanded');
        return $('.stream-container').stream({
          center: true,
          width: '100%',
          controls: true,
          nav: false
        });
      };
      render();
      opts = {
        scrollTo: root.offset().top - header.height(),
        ease: Power2.easeIn
      };
      tween = new TimelineMax();
      tween.to(window, 0.5, opts);
      f = function() {
        body = root.find('.slat-body');
        return root.css('max-height', "" + (root.height()) + "px");
      };
      return _ID = window.setTimeout(f, 1000);
    };

    AccordianArchitect.prototype.removeData = function(id) {
      var button, delay, head, header, opts, parent, remove, root, self, tween;
      self = this;
      root = $("[data-id=\"" + id + "\"]");
      parent = root.find('.slat-body');
      head = root.find('.slat-header');
      button = head.find('a.button');
      header = $('#site-header');
      tween = new TimelineMax();
      delay = 500;
      remove = function() {
        var elastic, opts;
        root.removeClass('state-expanded');
        root.addClass('state-collapsed');
        root.attr('data-state', 'collapsed');
        elastic = function() {
          var clear, timer;
          clearTimeout(timer);
          root.css('max-height', '');
          button.text(button.attr('data-text'));
          clear = function() {
            return parent.remove();
          };
          return timer = setTimeout(clear, 500);
        };
        opts = {
          'max-height': head.height(),
          ease: Power1.easeIn,
          onComplete: elastic
        };
        return tween.to(root, 0.5, opts);
      };
      opts = {
        scrollTo: root.offset().top - header.height(),
        ease: Circ.easeOut,
        onComplete: remove
      };
      return tween.to(window, 0.5, opts);
    };

    AccordianArchitect.prototype.expand = function(slat) {
      var body, button, content, f, header, opts, render, self, tween, _ID;
      console.log('=== RENDER DATA', slat);
      clearTimeout(_ID);
      self = this;
      content = slat.find('.content');
      header = $('#site-header');
      button = slat.find('.slat-header').find('a.button');
      body = slat.find('.slat-body');
      render = function() {
        slat.removeClass('state-collapsed');
        slat.addClass('state-expanded');
        slat.attr('data-state', 'expanded');
        $('.stream-container').stream({
          center: true,
          width: '100%',
          controls: true,
          nav: false
        });
        if (slat.attr('id') === 'slat-1') {
          return $('.stream-container').stream('updateStreamHeight');
        }
      };
      render();
      opts = {
        scrollTo: slat.offset().top - header.height(),
        ease: Power2.easeIn
      };
      tween = new TimelineMax();
      tween.to(window, 0.5, opts);
      f = function() {
        body = root.find('.slat-body');
        return button.find('span').text('close');
      };
      return _ID = setTimeout(f, 1000);
    };

    AccordianArchitect.prototype.collapse = function(slat) {
      var body, button, content, delay, head, header, remove, self, tween;
      self = this;
      content = slat.find('.content');
      body = slat.find('.slat-body');
      head = slat.find('.slat-header');
      button = head.find('a.button');
      header = $('#site-header');
      tween = new TimelineMax();
      delay = 500;
      remove = function() {
        var elastic, opts;
        slat.removeClass('state-expanded');
        slat.addClass('state-collapsed');
        slat.attr('data-state', 'collapsed');
        elastic = function() {
          slat.css('max-height', '');
          return button.find('span').text('open');
        };
        opts = {
          'max-height': head.height(),
          ease: Power1.easeIn,
          onComplete: elastic
        };
        return tween.to(slat, 0.5, opts);
      };
      return remove();
    };

    AccordianArchitect.prototype.onClick = function() {
      var close_arrows, self, slats;
      self = this;
      slats = this.element.find('.slat-header.slat-control');
      console.log("=== ASSIGN SLAT TOGGLE xx", this.element.length, slats.length);
      slats.on('click', function(e) {
        var slat, state;
        e.preventDefault();
        e.stopPropagation();
        slat = $(this).parent();
        state = slat.attr('data-state');
        console.log("SLAT state -- ", state);
        if (state === 'collapsed') {
          self.expand(slat);
        }
        if (state === 'expanded') {
          return self.collapse(slat);
        }
      });
      close_arrows = this.element.find('.slat-footer.slat-control');
      return close_arrows.on('click', function(e) {
        var head;
        e.preventDefault();
        e.stopPropagation();
        head = $(this).parent().find('.slat-header');
        return window.scrollToOffset(head.offset().top);
      });
    };

    AccordianArchitect.prototype.onLoad = function() {
      var body, intro, opts, productList;
      body = $('body');
      productList = $('.product-includes-list');
      opts = {
        opacity: 1,
        'margin-top': 0,
        visibility: 'visible'
      };
      if (this.state === 'ready') {
        intro = new TimelineMax();
        intro.to(body, 1, {
          autoAlpha: 1,
          ease: Power1.easeOut
        });
        intro.staggerTo(this.element, 0.3, opts, 0.2);
      }
      if (Modernizr.touch) {
        productList.addClass('state-hidden');
        return this.pricePackage();
      }
    };

    AccordianArchitect.prototype.pricePackage = function() {
      var marginTop, productContainer, productPrice, self, slat, slatHeader, streamContainer, streamItems;
      self = this;
      streamContainer = $('.stream-container');
      streamItems = streamContainer.find('.stream-item');
      productPrice = $('.product-price');
      productContainer = $('.product-container').not('.hide-for-phone');
      marginTop = 16;
      slat = streamContainer.closest('.slat');
      slatHeader = slat.find('.slat-header');
      return productPrice.on('click', function(e) {
        var nsib, psib, total;
        e.preventDefault();
        e.stopPropagation();
        nsib = $(this).next();
        psib = $(this).prev();
        total = 0;
        if (nsib.hasClass('state-hidden')) {
          nsib.removeClass('state-hidden').addClass('state-visible');
          psib.find('.icon').removeClass('icon-arrow_down').addClass('icon-arrow_up');
        } else {
          nsib.removeClass('state-visible').addClass('state-hidden');
          psib.find('.icon').removeClass('icon-arrow_up').addClass('icon-arrow_down');
        }
        if (streamItems.eq(0)) {
          $.each(productContainer, function(index, item) {
            var itemHeight;
            itemHeight = $(item).height();
            return total += itemHeight;
          });
          streamContainer.css('height', '100%');
          return slat.css({
            'max-height': ((slatHeader.height() * 2) + total + marginTop) + 100,
            height: ((slatHeader.height() * 2) + total + marginTop) + 100
          });
        }
      });
    };

    AccordianArchitect.prototype.setBulletinHei = function() {
      var browser, bulletin, head, headHei, self, vcenter;
      self = this;
      head = $('#site-header');
      headHei = head.height();
      bulletin = this.defaults.bulletin;
      browser = $('.browser-container');
      vcenter = bulletin.find('.vert-center-parent');
      bulletin.css('height', $(window).height());
      browser.css('height', $(window).height());
      if ($(window).height() < 1080 && !Modernizr.touch) {
        browser.css('padding', 0);
        return $('.site-bulletin-image').css('background-image', 'none');
      } else {
        return $('.site-bulletin-image').attr('style', '');
      }
    };

    AccordianArchitect.prototype.mediaFader = function(mediaList) {
      var bulletin, countLimit, counter, covers, credits, rotateDesktop, rotateMobile, self;
      return;
      self = this;
      bulletin = $('#site-bulletin');
      covers = [];
      credits = [];
      countLimit = mediaList.length - 1;
      counter = 0;
      $.each(mediaList, function(index, item) {
        var zindex;
        zindex = index + 2;
        covers.push("<div data-id='cover-" + index + "'  class='site-bulletin-cover' style='background-image: url( " + item.photo + " ); z-index:-" + zindex + "'></div>");
        return credits.push("<div data-id='credit-" + index + "' class='site-bulletin-credits'>" + item.name + " uses Folio <br/> <a class='button model-underline' target='_blank' href='http://" + item.url + "'><span>" + item.url + "</span></a></div>");
      });
      $('.site-bulletin-cover').remove();
      $('.site-bulletin-credits').remove();
      bulletin.append(credits.join('')).append(covers.join(''));
      if (!Modernizr.touch || $(window).width() > 1024) {
        TweenMax.to($("[data-id='cover-" + counter + "']"), 0.5, {
          autoAlpha: 1
        });
        TweenMax.fromTo($("[data-id='credit-" + counter + "']"), 0.5, {
          bottom: '-144px'
        }, {
          bottom: '32px'
        });
        rotateDesktop = function() {
          TweenMax.fromTo($("[data-id='cover-" + counter + "']"), 1, {
            autoAlpha: 1
          }, {
            autoAlpha: 0
          });
          TweenMax.fromTo($("[data-id='credit-" + counter + "']"), 0.5, {
            bottom: '32px'
          }, {
            bottom: '-144px'
          });
          if (counter === countLimit) {
            counter = 0;
          } else {
            counter++;
          }
          TweenMax.fromTo($("[data-id='cover-" + counter + "']"), 1, {
            autoAlpha: 0
          }, {
            autoAlpha: 1
          });
          return TweenMax.fromTo($("[data-id='credit-" + counter + "']"), 0.5, {
            bottom: '-144px'
          }, {
            bottom: '32px'
          });
        };
        setInterval(rotateDesktop, 5000);
      }
      if (Modernizr.touch || $(window).width() <= 1024) {
        $('.site-bulletin-credits').hide();
        TweenMax.to($("[data-id='cover-" + counter + "']"), 0.5, {
          autoAlpha: 1
        });
        rotateMobile = function() {
          TweenMax.fromTo($("[data-id='cover-" + counter + "']"), 1, {
            autoAlpha: 1
          }, {
            autoAlpha: 0
          });
          if (counter === countLimit) {
            counter = 0;
          } else {
            counter++;
          }
          return TweenMax.fromTo($("[data-id='cover-" + counter + "']"), 1, {
            autoAlpha: 0
          }, {
            autoAlpha: 1
          });
        };
        setInterval(rotateMobile, 5000);
      }
      return console.log('=== FADER ITEMS', covers, credits);
    };

    AccordianArchitect.prototype.animateText = function() {
      var bulletin, chars, index, name, self, synopsis, text, type, typeID;
      self = this;
      bulletin = this.defaults.bulletin;
      name = bulletin.find('.product-name');
      synopsis = bulletin.find('.product-synopsis');
      text = 'Focus on your work, not your website.';
      chars = [];
      index = 0;
      $.each(text.split(''), function(index, char) {
        return chars.push("<span class='char-" + index + "'>" + char + "</span>");
      });
      clearTimeout(typeID);
      type = function() {
        var fn;
        if (index < chars.length) {
          name.append(chars[index]);
          index += 1;
          fn = setTimeout(type, 100);
        }
        if (index === chars.length) {
          return synopsis.css('opacity', 1);
        }
      };
      return typeID = setTimeout(type, 1250);
    };

    AccordianArchitect.prototype.init = function() {
      var bulletin, debounceResize, mediaFaderObj, resizeFn, self, synopsis;
      self = this;
      bulletin = this.defaults.bulletin;
      synopsis = bulletin.find('.product-synopsis');
      mediaFaderObj = [
        {
          name: 'Sacha Hurley',
          photo: 'img/img-cover-sachahurley.jpg',
          url: 'sachahurley.com'
        }, {
          name: 'Also Known As',
          photo: 'img/img-cover-aka.jpg',
          url: 'folio.alsoknownas.ca'
        }, {
          name: 'Mark DeLong',
          photo: 'img/img-cover-markdelong.jpg',
          url: 'markdelong.ca'
        }
      ];
      this.setBulletinHei();
      synopsis.css('opacity', 1);
      this.onLoad();
      this.onClick();
      resizeFn = function() {
        self.setBulletinHei();
        return self.mediaFader(mediaFaderObj);
      };
      debounceResize = _.debounce(resizeFn, 250);
      return $(window).on('resize', debounceResize);
    };

    return AccordianArchitect;

  })();

  Module.onScroll = function() {
    var delay, header, root;
    root = $(window);
    header = $('#site-header');
    delay = 500;
    console.log("BOUNDS /2");
    return root.on('scroll', function(e) {
      var bottom, bounds, current, currentMedia, features, firstFeature, i, next, parent, top, _i, _ref;
      if (!Modernizr.touch) {
        if ($('.feature-container').length) {
          features = $('body').find('.feature-container');
          bounds = root.scrollTop() + (root.height() / 2);
          parent = $('.feature-container').parents('.slat');
          top = parent.position().top;
          bottom = parent.position().top + parent.outerHeight(true);
          firstFeature = features.eq(0).offset().top;
          for (i = _i = 0, _ref = features.length; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
            if (i <= features.length - 1) {
              current = features.eq(i).offset().top;
            }
            if (i + 1 <= features.length - 1) {
              next = features.eq(i + 1).offset().top;
            }
            currentMedia = features.eq(i).find('img.feature-image');
            if (i + 1 === features.length - 1) {
              next = bottom;
            }
            if (bounds <= firstFeature && bounds < next) {
              features.eq(0).addClass('state-active');
            }
            if (bounds >= current && bounds < next) {
              features.eq(i).addClass('state-active');
            } else {
              features.eq(i).removeClass('state-active');
              if (currentMedia.attr('data-src')) {
                currentMedia.attr('src', currentMedia.attr('data-src'));
              }
            }
          }
        }
      }
      if (root.scrollTop() > 1) {
        header.addClass('is-scrolling');
      }
      if (root.scrollTop() < 1) {
        return header.removeClass('is-scrolling');
      }
    });
  };

  root = typeof exports !== "undefined" && exports !== null ? exports : window;

  root.AccordianArchitect = AccordianArchitect;

  root.MobileMenu = MobileMenu;

  root.Module = Module;

}).call(this);
