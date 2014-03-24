/*
	jQuery Slider Plugin v1.0.0
	https://github.com/cmisura/stream.js
	
	Copyright 2014 Clayton Misura
	Released under the MIT license
*/


(function() {
  (function($, window, document) {
    var Plugin, defaults, pluginName;
    pluginName = 'stream';
    defaults = {
      center: true,
      controls: true,
      nav: true,
      overflow: 'hidden',
      width: 500
    };
    Plugin = (function() {
      function Plugin(element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.streamItemsContainer = $(this.element).find('.stream-items');
        this.streamItems = $(this.element).find('.stream-item');
        this.streamLength = this.streamItems.length;
        this.streamWidth = function() {
          return this.streamLength * this.settings.width;
        };
        this.lastItem = null;
        this.init();
      }

      Plugin.prototype.init = function() {
        var ID, self, showItems;
        console.log('=== PLUGIN DEFAULTS / EXTENDED -->', defaults, this.settings);
        self = this;
        if (this.settings.width === '100%') {
          this.settings.width = $(this.element).width();
        }
        this.buildStream();
        this.setupStreamItems();
        this.moveStream();
        this.controlStreamDirection();
        clearTimeout(ID);
        showItems = function() {
          self.streamItemsContainer.css('opacity', 1);
          return $('body').find('.stream-dots').css('opacity', 1);
        };
        return ID = window.setTimeout(showItems, 1000);
      };

      Plugin.prototype.buildStream = function() {
        console.log('=== BUILD STREAM -->', this.element);
        $(this.element).css('width', this.settings.width);
        $(this.element).css({
          'overflow-x': this.settings.overflow,
          'overflow-y': 'hidden'
        });
        if (this.settings.center) {
          this.centerStream();
        }
        if (this.settings.nav) {
          return this.setupStreamNav();
        }
      };

      Plugin.prototype.centerStream = function() {
        console.log('=== CENTER STREAM');
        return $(this.element).addClass('state-centered');
      };

      Plugin.prototype.setupStreamItems = function() {
        var self, streamLength;
        console.log('=== SETUP STREAM');
        self = this;
        streamLength = this.streamLength - 1;
        this.streamItemsContainer.css('width', this.streamWidth());
        return $.each(this.streamItems, function(index, streamItem) {
          var opts;
          streamItem = $(streamItem);
          opts = {
            width: self.settings.width
          };
          streamItem.css(opts);
          streamItem.attr('data-height', streamItem.height());
          streamItem.attr('data-index', index);
          if (index === 0) {
            streamItem.attr('data-focus', 'true');
          }
          if (index !== 0) {
            return streamItem.attr('data-focus', 'false');
          }
        });
      };

      Plugin.prototype.setupStreamNav = function() {
        var container, i, self, streamLength, _i;
        self = this;
        streamLength = this.streamLength - 1;
        container = $('body').find(this.element);
        $('<div class="stream-dots" />').insertBefore(container);
        for (i = _i = 0; 0 <= streamLength ? _i <= streamLength : _i >= streamLength; i = 0 <= streamLength ? ++_i : --_i) {
          $("<a class='stream-dot' href='#' data-index='" + i + "'><span></span></a>").appendTo('.stream-dots');
        }
        $('.stream-dot').eq(0).addClass('state-active');
        if (!this.settings.center) {
          return $('.stream-dots').css('text-align', 'left');
        }
      };

      Plugin.prototype.updateStreamHeight = function(currentItem) {
        var evalHeight, productPrice, self, slat, target;
        if (!currentItem) {
          currentItem = $('.stream-item').eq(0);
        }
        self = this;
        evalHeight = currentItem.height() + 44;
        slat = $(this.element).closest('.slat');
        productPrice = slat.find('.product-includes-list');
        console.log('=== UPDATE STREAM', evalHeight);
        if (Modernizr.touch) {
          productPrice.removeClass('state-visible').addClass('state-hidden');
          productPrice.find('.icon').removeClass('icon-arrow_down').addClass('icon-arrow_up');
          slat.css({
            height: 'auto',
            'max-height': '100%'
          });
          $(this.element).css('height', evalHeight);
        } else {
          $(this.element).css('height', evalHeight);
        }
        console.log("UPDATE STREAM HEIGHT :: ", this.lastItem);
        if (this.lastItem) {
          target = $(this.element).parent().parent().parent().offset().top;
          window.scrollToOffset(target);
        }
        return this.lastItem = currentItem;
      };

      Plugin.prototype.moveStream = function(action, destination) {
        var moveTo, self, streamLength, updateNav;
        self = this;
        streamLength = this.streamLength - 1;
        updateNav = function() {
          var currentItem, dot, dots, nextIndex;
          currentItem = $('*[data-focus="true"]');
          nextIndex = parseInt(currentItem.attr('data-index'));
          dots = $('.stream-dot');
          dot = $('.stream-dots').find("[data-index='" + nextIndex + "']");
          dots.removeClass('state-active');
          return dot.addClass('state-active');
        };
        moveTo = {
          next: function() {
            var currentItem, f, index, location, nextIndex, nextItem;
            currentItem = $('*[data-focus="true"]');
            nextItem = currentItem.next();
            index = parseInt(currentItem.attr('data-index'));
            nextIndex = parseInt(nextItem.attr('data-index'));
            if (index !== streamLength) {
              location = nextItem.position().left;
              currentItem.attr('data-focus', 'false');
              nextItem.attr('data-focus', 'true');
              self.streamItemsContainer.css('transform', "translate3d( -" + location + "px, 0, 0 )");
              f = function() {
                return self.updateStreamHeight(nextItem);
              };
              setTimeout(f, 500);
              if (self.settings.nav) {
                return updateNav();
              }
            } else {

            }
          },
          prev: function() {
            var currentItem, f, index, location, prevItem;
            currentItem = $('*[data-focus="true"]');
            prevItem = currentItem.prev();
            index = parseInt(currentItem.attr('data-index'));
            if (index !== 0) {
              location = prevItem.position().left;
              currentItem.attr('data-focus', 'false');
              prevItem.attr('data-focus', 'true');
              self.streamItemsContainer.css('transform', "translate3d( -" + location + "px, 0, 0 )");
              f = function() {
                return self.updateStreamHeight(prevItem);
              };
              setTimeout(f, 500);
              if (self.settings.nav) {
                return updateNav();
              }
            } else {

            }
          },
          teleport: function(endpoint) {
            var currentItem, f, location, teleportItem;
            currentItem = $('*[data-focus="true"]');
            teleportItem = self.streamItemsContainer.find("[data-index='" + endpoint + "']");
            location = teleportItem.position().left;
            currentItem.attr('data-focus', 'false');
            teleportItem.attr('data-focus', 'true');
            self.streamItemsContainer.css('transform', "translate3d( -" + location + "px, 0, 0 )");
            f = function() {
              return self.updateStreamHeight(nextItem);
            };
            return setTimeout(f, 500);
          }
        };
        if (action === 'next') {
          moveTo.next();
        }
        if (action === 'prev') {
          moveTo.prev();
        }
        if (action === 'teleport') {
          return moveTo.teleport(destination);
        }
      };

      Plugin.prototype.controlStreamDirection = function() {
        var dots, self;
        self = this;
        dots = $('body').find('.stream-dots .stream-dot');
        if (this.settings.controls) {
          $('.stream-controller').on('click', function(e) {
            var button;
            console.log('=== STREAM DIRECTION ', e);
            e.preventDefault();
            e.stopPropagation();
            button = $(this);
            if (button.hasClass('next-item')) {
              self.moveStream('next');
            }
            if (button.hasClass('prev-item')) {
              self.moveStream('prev');
            }
            if (button.hasClass('prev-item-two')) {
              self.moveStream('prev');
              return self.moveStream('prev');
            }
          });
        }
        if (this.settings.nav) {
          return $('body').on('click', '.stream-dot', function(e) {
            var dot, index;
            e.preventDefault();
            e.stopPropagation();
            dot = $(this);
            index = parseInt(dot.attr('data-index'));
            dots.removeClass('state-active');
            dot.addClass('state-active');
            return self.moveStream('teleport', index);
          });
        }
      };

      return Plugin;

    })();
    return $.fn[pluginName] = function(options) {
      return this.each(function() {
        var stream;
        if (!$.data(this, "plugin_" + pluginName)) {
          return $.data(this, "plugin_" + pluginName, new Plugin(this, options));
        } else {
          stream = $.data(this, "plugin_" + pluginName);
          if (options === 'next' || options === 'prev') {
            stream.moveStream(options);
          }
          if (options === 'updateStreamHeight') {
            return stream.updateStreamHeight();
          }
        }
      });
    };
  })(jQuery, window, document);

}).call(this);
