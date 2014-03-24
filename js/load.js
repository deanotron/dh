(function() {
  var setBulletinHei;

  setBulletinHei = function() {
    var bulletin, height, self;
    self = this;
    bulletin = document.getElementById('site-bulletin');
    height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    return bulletin.style.height = height;
  };

  document.addEventListener('DOMContentLoaded', setBulletinHei);

}).call(this);
