jQuery(function ($) {

    $(".sidebar-dropdown > a").click(function() {
      $(".sidebar-submenu").slideUp(200);
      if ( $(this).parent().hasClass("active") ) {
          $(".sidebar-dropdown").removeClass("active");
          $(this).parent().removeClass("active");
      }else{
        $(".sidebar-dropdown").removeClass("active");
        $(this).next(".sidebar-submenu").slideDown(200);
        $(this).parent().addClass("active");
      }
    });
  $("#close-sidebar").click(function() {$(".page-wrapper").removeClass("toggled");});
  $("#show-sidebar").click(function() {$(".page-wrapper").addClass("toggled");});
});
document.querySelector('.sidebar-wrapper .sidebar-header .user-info i').onclick = (ev)=>{
  //Abrir modal de definições da conta do usuarios
}
document.querySelector('#logout-button').onclick = (ev)=>{
  ev.preventDefault();
  window.location.href="/res/logout.php";
}
