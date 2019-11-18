const server_url = "umcbrinquedoteca.online";
// const server_url = "localhost";
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

  //sidebarMenu InVisivel
  $("#close-sidebar").click(async function() {
    await drawDatatable();
    $(".page-wrapper").removeClass("toggled");
    await drawDatatable();
  });

  //sidebarMenu visivel
  $("#show-sidebar").click(async function() {
    await drawDatatable();
    $(".page-wrapper").addClass("toggled");
    await drawDatatable();
  });
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
function serializeEditModal(){
  // {body:{name:'',pass:'',mail:'',access:0}}
  let inputEdit = document.querySelectorAll(
    '#form_edit_user .form-row .form-group input, #form_edit_user .form-row .form-group select'
  );
  let endReq = {body:{}};
  let entryKeyPairs = [];
  inputEdit.forEach(elm=>{
    if(elm.value != '' && elm.value != null ){
      entryKeyPairs.push({field:elm.id,val:elm.value});
    }
  });
  console.log(entryKeyPairs);
  entryKeyPairs.forEach(currentElm =>{
    if(currentElm.field == 'edit_pass_') {
      endReq.body['pass'] = currentElm.val;
    };
    if(currentElm.field == 'edit_name_') {endReq.body['name'] = currentElm.val};
    if(currentElm.field == 'edit_mail_') {endReq.body['mail'] = currentElm.val};
    if(currentElm.field == 'edit_acesso_') {endReq.body['access'] = currentElm.val};
  });
  return endReq;
  // alert(endReq);
  // console.log(endReq);
  // return;
}
document.querySelector("#form_edit_user").onsubmit = async function(_ev_){
  // alert("Ola_mundo_editoe!");
  let form_edit_user_close= document.querySelector("#form_edit_user");
   if (form_edit_user.checkValidity() == true){
     let _id = window.localStorage.formEdit.split(',')[0];

     let objectReq = await serializeEditModal();

     let reqBody =JSON.stringify(objectReq);
     _ev_.preventDefault();
     let resp = await $.ajax({
       method:'post',
       url:`http://${server_url}/API-BrinqLab/user/update/${_id}`,
       data:reqBody,
       success:async function(reponseEv){
         if(reponseEv.afected_rows == true){
           $("#editModal").modal('hide');
           await initializeTable();
           alert("usuario alterado com sucesso!");
         }
       },
       error: function(e){
        alert(e.Error);
       }
     });

   }

}
document.querySelector('#form_cad_user').onsubmit = async function(EV){
  var toSend=[];

  if(document.querySelector('#form_cad_user').checkValidity() == true){
    var inputCad = document.querySelectorAll(
      '#form_cad_user .form-row .form-group input, #form_cad_user .form-row .form-group select'
    );
    inputCad.forEach((elm)=>{
      toSend.push({field:elm.id,val:elm.value});
    });
  }
 var final = {body:{name:'',pass:'',mail:'',access:0}};
  toSend.forEach((elm)=>{
      switch ( elm.field){
        case '_name_':
          final.body.name = elm.val;
          break;
        case '_acesso_':
          final.body.access = elm.val;
          break;
        case '_pass_':
          final.body.pass = elm.val;
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
    url: `http://${server_url}/API-BrinqLab/users/add`,
    data: final_v2,
    success:async function(rsp){
      if(rsp.userId > 0){
          var myrtabela = new $.fn.dataTable.Api( "#example" );
          var novosDados;
          await initializeTable();
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
function gotouser(){
  window.location.href="/home.php/?t=usuarios";
}
function gotoestoque(){
  window.location.href="/home.php/?t=estoque";
}
function gotoagenda(){
  window.location.href = '/home.php/?t=agenda';
}

function drawDatatable(){
  try{

    let _hasTable = new $.fn.dataTable.Api( "#example" );
      _hasTable.draw();
      _hasTable.columns.adjust();
    return true;
    }catch(e){
      return e;
    }
}

let sidebar_toogle = document.querySelectorAll(".sideBar_modification");
sidebar_toogle.forEach(side_bar_btn=>{
  side_bar_btn.addEventListener('click',async ev=>{
    await setTimeout(async function(){
      ev.stopPropagation();
      ev.preventDefault();
      let ctype = await drawDatatable();
      console.log(`datatable has modified ${new Date().toLocaleDateString()} params Is ${ctype}`);
    },270);
  })
})
