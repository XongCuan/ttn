$(document).ready(function () {

    var currentLocation = window.location.href; // Lấy đường dẫn của trang hiện tại
    // Duyệt qua từng phần tử li trong menu
    $("#sidebar-menu li").each(function() {
        var menuItem = $(this);
        var menuLink = menuItem.find("a");
        $(menuLink).each(function() {
            linkLocation = $(this).attr('href');
            // So sánh đường dẫn của menu item với đường dẫn của trang hiện tại
            if (linkLocation === currentLocation) {
                $(this).parents('.nav-item').addClass('active');
                $(this).addClass('active');
                menuItem.find(".dropdown-toggle.nav-link, .dropdown-menu").addClass("show");
            }
        });
    });

    if($("#blockSubmit").length){
        $(window).scroll(function() {

            var scrollTop = $(window).scrollTop();
    
            if (scrollTop >= $("#blockSubmit").offset().top + $("#blockSubmit").height()) {
                $("#blockSubmitFixed").css('display', 'block');
            }else{
                $("#blockSubmitFixed").css('display', 'none');
            }
        });
    }
});