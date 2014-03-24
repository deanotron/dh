(function() {
  var TemplateArchitect, root;

  TemplateArchitect = (function() {
    function TemplateArchitect() {
      this.templates = {};
    }

    TemplateArchitect.prototype.add = function(id, name, template, callback) {
      var opts;
      if (!this.templates[name]) {
        this.templates[name] = [];
      }
      opts = {
        id: id,
        template: _.template(template),
        callback: callback
      };
      this.templates[name].push(opts);
      return console.log('=== TEMPLATES ===>', this.templates);
    };

    TemplateArchitect.prototype.remove = function(id, name) {
      var remnants, template, _i, _len, _ref;
      remnants = [];
      if (this.templates[name]) {
        _ref = this.templates[name];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          template = _ref[_i];
          if (template.id !== id) {
            remnants.push(template);
          }
        }
        if (remnants.length === 0) {
          return delete this.templates[name];
        } else {
          return this.templates[name] = remnants;
        }
      }
    };

    TemplateArchitect.prototype.build = function(id, name, data) {
      var model, set, setName, sets, _i, _len, _ref;
      model = {
        model: data
      };
      _ref = this.templates;
      for (setName in _ref) {
        sets = _ref[setName];
        if (!(sets !== null)) {
          return false;
        }
        if (setName === name) {
          for (_i = 0, _len = sets.length; _i < _len; _i++) {
            set = sets[_i];
            console.log(id, name, model);
            set.callback(model);
          }
        }
      }
    };

    return TemplateArchitect;

  })();

  root = typeof exports !== "undefined" && exports !== null ? exports : window;

  root.TemplateArchitect = TemplateArchitect;

}).call(this);
