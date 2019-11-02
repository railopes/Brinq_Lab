<?php
  // session_start();
  $estaLogado = require_once("./class/logged.php");
  if(!$estaLogado){
    echo "<script>window.location.href='./'</script>";
    exit();
  }
  unset($_GET);
?>

  <body>
  <!-- table-responsive-sm table-responsive-md -->
    <table id="example" class="table table-hover table-bordr-bottom table-light " style="width:100%">

      <thead class="thead-dark">
        <tr role="row">
          <td colspan="6" class='text-center bg-dark text-light'>Usuarios</td>
        </tr>
        <tr>
          <th>ID</th>
          <th>usuario</th>
          <th>email</th>
          <th>perfil</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="5" class="text-center">
              <span id="loader-icon" class="text-primary"><i class="fa fa-spinner fa-pulse fa-3x"></i> Carregando ... </span>
          </td>
        </tr>

      </tbody>
    </table>
    <!-- </div> -->

    <style media="screen">
        div.container {
            width: 80%;
        }
        table tr td span i.fa {
          cursor: pointer;
        }
        table tr td span i.fa:hover{
          color: rgba(0,0,0,.4) !important;
        }
    </style>
    <script type="text/javascript">
    var currentRow = [],mydata = null,windowUserIn = null;
    var table;
    // const  myServerUrl = "umcbrinquedoteca.online";
    const  myServerUrl = "localhost";
    function edittableItem(id_table){
      window.localStorage.setItem("formEdit",currentRow);
    }

    async function getMetadata(){
      var mydata = await $.ajax(`http://${myServerUrl}/API-BrinqLab/users`);
      return mydata;

    }

    $('#editModal').on('show.bs.modal',e=>{
        function getAcessLevel(){
          let caseOptions = window.localStorage.formEdit.split(',')[3];
          switch(caseOptions){
            case 'Professor':
              return 1;
              break;
            case 'Monitor':
              return 2;
              break;
            case 'Coordenador':
              return 3;
              break;
          }
        }
        document.querySelector("#form_edit_user").reset();
        document.querySelector('#edit_name_').value = window.localStorage.formEdit.split(',')[1];
        document.querySelector('#edit_mail_').value = window.localStorage.formEdit.split(',')[2];
        document.querySelector('#edit_acesso_').value = getAcessLevel();
    })
    async function deletItem(_id){
      if(confirm(`Deseja realmente Exluir o Usário: ${_id}`)){
      let response = await $.ajax({
        method:'post',
        url:`http://${myServerUrl}/API-BrinqLab/user/delete/${_id}`
      });
      if(response.afected_rows == true){
        alert("Usuario Excluido com sucesso!");
        await initializeTable();
      }
    }
    }

    async function _run(){
    mydata = await getMetadata();
    await mydata;
    mydata.forEach(ar=>{
      var cSpan = document.createElement('span');
      var i = document.createElement('i');
        i.setAttribute('class','fa fa-pencil text-warning fa-2x');
        i.setAttribute('onclick',`edittableItem('${ar[0]}')`);
        i.setAttribute('data-toggle','modal');
        i.setAttribute('data-target','#editModal');
        cSpan.appendChild(i);
        cSpan.append(' ');
      var i2 = document.createElement('i');
        i2.setAttribute('class','fa fa-trash text-danger fa-2x');
        i2.setAttribute('onclick',`deletItem('${ar[0]}')`);
      cSpan.appendChild(i2);
        ar.push(cSpan.outerHTML);
      });
      return mydata;
    }
  async function initializeTable(){
    let aTabela;
    // dom: '<fl<t>iBp>',
      async function iniciarTabela(){
        let dadosAtuais =  await _run();
        return ( 
          $('#example').DataTable({
                  dom: '<fl<t>iBp>',
                  responsive:true,
                  destroy:true,
                  scrollY:true,
                  lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "Completo"]],
                  language:{url:"http://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"},
                  buttons: [
                      {
                        extend: 'excelHtml5',
                        exportOptions: { columns: [0,1,2,3] }
                      },
                      {
                        extend: 'pdfHtml5',
                        className:`pdf_button_${windowUserIn}`,
                        exportOptions: { columns: [0,1,2,3] }
                      }
                    ],
                  columnDefs: [{targets:4,orderable: false}],
                  data:dadosAtuais
                }).on('init',async function(evElm){
                    return $(`#${evElm.target.id}`).DataTable();
                })
            );
      }
      _aTabela_ = await iniciarTabela();
      $('#example tbody').on( 'mouseenter', 'tr', function () {
          currentRow = this.innerText.split("\t");
      } );
      
      window.onresize = e=>{
        _aTabela_.draw();
        _aTabela_.columns.adjust();
      }
      return _aTabela_
    }
    function alterBtnDataTables(btn,newClasses,delClasses){
      try{
          let propBtn = btn.classList;
          propBtn.remove(delClasses);
          propBtn.add(newClasses);
          return true;
      }catch(Err){
        console.error(Err);
        return false;
      }
    }
    var abx = null;
    document.addEventListener('DOMContentLoaded',async function(ev) {
        let btnCmps = ['Excel','PDF']
        windowUserIn = 'usuarios';
        await setTimeout(async function(){
          abx = await initializeTable();
          await setTimeout(ev=>{
              abx.on('buttons-action', function ( e, buttonApi, dataTable, node, config ) {
                console.log(buttonApi.text());
              })
          },10);
        }, 2500);
        await abx;

        
      });
    </script>
  </body>
