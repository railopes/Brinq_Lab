<?php
  // session_start();
  $estaLogado = require_once("./class/logged.php");
  if(!$estaLogado){
    echo "<script>window.location.href='/'</script>";
    exit();
  }else{
    if($_SESSION['profileVersion'] == 1 || $_SESSION['profileVersion'] == 2){
      echo "<script>alert('Voce não possui permissao para acessar esta pagina!')
        window.location.href = '/index.php'
      </script>";
      // header("Location: /index.php");
      // exit();
    }
  }
?>
<!DOCTYPE html>

<html lang="pt_BR" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title> Teste datatables </title>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js" charset="utf-8"></script> -->
    <script src="bootstrap\js\jquery-3.4.1.js" charset="utf-8"></script>
    <link rel="stylesheet" href="bootstrap/DataTables/DataTables-1.10.20/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/DataTables/datatables.min.css"/>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap\fontawesome\css\font-awesome.min.css">
    <!-- <link rel="stylesheet" href="bootstrap\DataTables\DataTables-1.10.20\css\jquery.dataTables.min.css"> -->
    <script src="bootstrap/DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="bootstrap/DataTables/datatables.min.js"></script>



  </head>

  <body>
    <table id="example" class="table  table-hover table-md table-light" style="width:100%">

      <thead class="thead-dark">
        <tr>
          <td colspan="5" class='text-center bg-dark text-light'>Usuarios</td>
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
    var currentRow = [],mydata = null;
    var table;
    function edittableItem(id_table){
      window.localStorage.setItem("formEdit",currentRow);
      console.log(id_table);
    }

    async function getMetadata(){
      var mydata = await $.ajax("/Api_v2/Tela_Usuario.php/");
      return mydata;

    }

    $('#editModal').on('show.bs.modal',e=>{
      document.querySelector('#exampleModalLabel').innerText = "Usuário: "+window.localStorage.getItem('formEdit').split(',')[1];

    })

    async function _run(){
    mydata = await getMetadata();
    await mydata;
    mydata.forEach(ar=>{
      var cSpan = document.createElement('span');
      var i = document.createElement('i');
        i.setAttribute('class','fa fa-pencil text-warning fa-2x');
        i.setAttribute('onclick',`edittableItem('${ar[0]}')`);
        // data-toggle="modal" data-target="#editModal
        i.setAttribute('data-toggle','modal');
        i.setAttribute('data-target','#editModal');
        cSpan.appendChild(i);
        cSpan.append(' ');
      var i2 = document.createElement('i');
        i2.setAttribute('class','fa fa-trash text-danger fa-2x');
        i2.setAttribute('onclick',`edittableItem('${ar[0]}')`);
      cSpan.appendChild(i2);
        ar.push(cSpan.outerHTML);
      })

        // document.querySelector('#loader-icon').outerHTML = '';

    }
 // lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "tudo"]] // dom: 'Bfrtip', //dom:'<fl<t>Bp>'
 // $(document).ready
    document.addEventListener('DOMContentLoaded',async function() {
        await  _run();
        setTimeout(function(){
        table = $('#example').DataTable({
          dom: '<fl<t>iBp>',
          responsive:true,
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
                exportOptions: { columns: [0,1,2,3] }
              }
            ],
          columnDefs: [{targets:4,orderable: false}],
          data:mydata
         });
       },1000);

        $('#example tbody').on( 'mouseenter', 'tr', function () {
            currentRow = this.innerText.split("\t");
        } );
        window.onresize = e=>{
           table.columns.adjust();
        }
      });


    </script>
  </body>
</html>
