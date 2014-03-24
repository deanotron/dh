(function() {
  var AnimationArchitect, root;

  AnimationArchitect = (function() {
    function AnimationArchitect() {
      this.animations = {};
      this.run = false;
      this.vendors = {
        webkit: '-webkit-',
        gecko: '-moz-',
        msie: '-ms-',
        opera: '-o-'
      };
      console.log('===  | AnimationArchitect -> isModern | hasAttribute | ', this.isModern());
    }

    AnimationArchitect.prototype.isModern = function() {
      if (Modernizr.csstransforms3d) {
        return true;
      } else {
        return false;
      }
    };

    AnimationArchitect.prototype.create = function(name, element, duration, attributes, ease, delay, callback) {
      var opts;
      if (!this.animations[name]) {
        this.animations[name] = [];
      }
      element = element instanceof jQuery ? element : $(element);
      duration || (duration = 1);
      attributes || (attributes = {});
      ease || (ease = 'linear');
      delay || (delay = 0);
      callback || (callback = void 0);
      opts = {
        element: element,
        duration: duration,
        attributes: attributes,
        ease: ease,
        delay: delay,
        callback: callback
      };
      this.animations[name].push(opts);
      return console.log('===  | AnimationArchitect -> Create | @animations | ', this.animations);
    };

    AnimationArchitect.prototype.animate = function(name, element, update, delay) {
      var animationFrame, attribute, axis, i, propertiesList, property, runAnimation, runComplete, set, timeoutID, transform, transitionList, value, vendor, _i, _len, _ref, _ref1;
      clearTimeout(timeoutID);
      if (this.animations[name]) {
        if (typeof delay !== 'undefined') {
          this.animations[name][0].delay = delay;
        }
        if (typeof update !== 'undefined' && typeof update === 'object') {
          $.extend(this.animations[name][0].attributes, update);
        }
        if (typeof update !== 'undefined' && typeof update === 'number') {
          this.animations[name][0].delay = update;
        }
        if (element) {
          if (typeof element === 'string') {
            element = this.animations[name][0].element = $(element);
            console.log('St', element);
          }
          if (element instanceof jQuery) {
            $.extend(this.animations[name][0].attributes, element);
            console.log('$', element);
          } else {
            this.animations[name][0].element = $(element);
          }
        }
        _ref = this.animations[name];
        for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
          set = _ref[i];
          if (this.isModern()) {
            animationFrame = window.AnimationFrame();
            transitionList = [];
            propertiesList = {};
            axis = {
              x: 0,
              y: 0,
              z: 0
            };
            animationFrame.cancel(runAnimation);
            _ref1 = set.attributes;
            for (attribute in _ref1) {
              value = _ref1[attribute];
              if (attribute === 'left') {
                axis.x = "-" + set.attributes.left;
                delete set.attributes['left'];
              }
              if (attribute === 'right') {
                axis.x = "" + set.attributes.right;
                delete set.attributes['right'];
              }
              if (attribute === 'top') {
                axis.y = "-" + set.attributes.top;
                delete set.attributes['top'];
              }
              if (attribute === 'bottom') {
                axis.y = "" + set.attributes.bottom;
                delete set.attributes['bottom'];
              }
            }
            transform = "translate3d( " + axis.x + ", " + axis.y + ", " + axis.z + " )";
            if (bowser.webkit) {
              vendor = this.vendors.webkit;
            }
            if (bowser.gecko) {
              vendor = this.vendors.gecko;
            }
            if (bowser.msie) {
              vendor = this.vendors.msie;
            }
            if (bowser.opera) {
              vendor = this.vendors.opera;
            }
            set.attributes["" + vendor + "transform"] = transform;
            for (property in set.attributes) {
              transitionList.push("" + property + " " + set.duration + "ms " + set.ease + " " + set.delay + "ms");
            }
            set.attributes["" + vendor + "transition"] = transitionList.join();
            runAnimation = function() {
              return set.element.css(set.attributes);
            };
            if (set.callback) {
              runComplete = function() {
                return set.callback();
              };
            }
            animationFrame.request(runAnimation);
            if (set.callback) {
              timeoutID = window.setTimeout(runComplete, set.duration + set.delay);
            }
          } else {
            set.element.animate(set.attributes, set.time, set.ease, set.callback);
          }
        }
        return console.log('=== | AnimationArchitect -> set | Name | ', this.animations[name], transitionList);
      }
    };

    return AnimationArchitect;

  })();

  root = typeof exports !== "undefined" && exports !== null ? exports : window;

  root.AnimationArchitect = AnimationArchitect;

}).call(this);
