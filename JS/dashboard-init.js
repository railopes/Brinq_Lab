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

document.querySelector("#cad_user_cancel_btn").onclick =ev=>{
  ev.preventDefault();
  document.querySelector("#form_cad_user").classList.remove("was-validated");
  document.querySelector("#form_cad_user").reset();
}
document.querySelector("#form_cad_user_close").onclick =ev=>{
  ev.preventDefault();
  document.querySelector("#form_cad_user").classList.remove("was-validated");
  document.querySelector("#form_cad_user").reset();

}

(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

document.querySelector('#form_cad_user').onsubmit = async function(EV){
  var toSend=[];

  if(document.querySelector('#form_cad_user').checkValidity() == true){
    var inputCad = document.querySelectorAll(
      '#form_cad_user .form-row .form-group input, #form_cad_user .form-row .form-group select'
    );
    inputCad.forEach((elm)=>{
      toSend.push({field:elm.id,val:elm.value});
      // toSend.push({elm.id:elm.value});
    });
  }
   var final = {body:{name:'',pass_:'',mail:'',access:0}};
  toSend.forEach((elm)=>{
      switch ( elm.field){
        case '_name_':
          final.body.name = elm.val;
          break;
        case '_acesso_':
          final.body.access = elm.val;
          break;
        case '_pass_':
          final.body.pass_ = elm.val;
          break;
        case '_mail_':
          final.body.mail = elm.val;
          break;
      }
  });
  EV.preventDefault();
  var final_v2 = JSON.stringify(final);
    $.ajax({
    type: "POST",
    url: "/Api_v2/Tela_Usuario.php/?type=cad",
    data: final_v2,
    success:async function(rsp){
      if(rsp.userId > 0){
          var myrtabela = new $.fn.dataTable.Api( "#example" );
          var novosDados;
          await setTimeout(async function(){
            novosDados = await $.ajax("/Api_v2/Tela_Usuario.php/");
            await novosDados;
              myrtabela.data = novosDados;
              var ITEM = novosDados[novosDados.length-1];
              var cSpan = document.createElement('span');
              var i = document.createElement('i');
                i.setAttribute('class','fa fa-pencil text-warning fa-2x');
                i.setAttribute('onclick',`edittableItem('${ITEM[0]}')`);
                i.setAttribute('data-toggle','modal');
                i.setAttribute('data-target','#editModal');
                cSpan.appendChild(i);
                cSpan.append(' ');
              var i2 = document.createElement('i');
                i2.setAttribute('class','fa fa-trash text-danger fa-2x');
                i2.setAttribute('onclick',`edittableItem('${ITEM[0]}')`);
              cSpan.appendChild(i2);
              ITEM.push(cSpan.outerHTML);
              myrtabela.row.add(ITEM).draw();
          },1000)
          $("#addModal").modal('hide');
          console.log($("#addModal").modal)
          document.querySelector("#form_cad_user").classList.remove("was-validated");
          document.querySelector("#form_cad_user").reset();
          $("#alert_finish").modal('show');
      }else{
        $("#addModal").modal('hide');
        document.querySelector("#form_cad_user").classList.remove("was-validated");
        document.querySelector("#form_cad_user").reset();
        // $("#alert_finish").modal('show');
        alert("Usuário ou email já cadastrados!");
      }

    }
  });


}
