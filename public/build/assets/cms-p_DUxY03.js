$(document).ready(function() {
  var currentLocation = window.location.href;
  $("#sidebar-menu li").each(function() {
    var menuItem = $(this);
    var menuLink = menuItem.find("a");
    $(menuLink).each(function() {
      linkLocation = $(this).attr("href");
      if (linkLocation === currentLocation) {
        $(this).parents(".nav-item").addClass("active");
        $(this).addClass("active");
        menuItem.find(".dropdown-toggle.nav-link, .dropdown-menu").addClass("show");
      }
    });
  });
  if ($("#blockSubmit").length) {
    $(window).scroll(function() {
      var scrollTop = $(window).scrollTop();
      if (scrollTop >= $("#blockSubmit").offset().top + $("#blockSubmit").height()) {
        $("#blockSubmitFixed").css("display", "block");
      } else {
        $("#blockSubmitFixed").css("display", "none");
      }
    });
  }
});
