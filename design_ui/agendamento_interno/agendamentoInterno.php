<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agendamento. Interno</title>
    <!-- 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/fh-3.1.6/sc-2.0.1/sl-1.3.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/fh-3.1.6/sc-2.0.1/sl-1.3.1/datatables.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
     -->
</head>
<body>
    
    <!-- O professor: faz login e vai pro formulario com a chave/token :usuario+datahora+senha -->
    <!-- coluna: externo [true,falseW] -->
    <!-- alertar estoque baixo nome em vermleho nasd listas. -->
    <!-- Campos Externo: [Diff: Responsavel,nomeInsti,RG responsavel, Nº alunos, Eliminar Externos: [materiais,dsiciplina]] -->
    <!-- campos interno: materiais,disciplina,decricao,dataEHoraInci -range,id -->
    <div class="">
    <?php require_once("createAgendamento.html");?>
    <div id="calendario" class="col-12">
        <!-- <span class="user-role" contentEditable="false"><i class="fa fa-user"></i>Coordenador</span> -->
            <!-- table#agenda.table.table-stripped.table-hover>(tr>thead>th*6)+tbody-->
        <table id="agenda" class="table table-responsive table-light">
            <tr>
                <thead class='thead thead-dark text-center'>
                        <!-- a.id_agenda, u.nome,a.nomeInstituicao ,a.RG, a.total_alunos, a.data_hora  -->
                    <th>id</th>
                    <th>usuario</th>
                    <th>Instituição</th>
                    <th>RG</th>
                    <th>Nº alunos</th>
                    <th>Horario</th>
                    <th>Ações</th>
                </thead>
            </tr>
            <tbody></tbody>
        </table>
    </div>
</div>
</body>
<script>
    const apiurl = "http://localhost/API/";
    const newChildDatatable =D=>{
        // console.log("D:");
        // Regex Capture entre tags html (p)em texto --> new RegExp(/\<p.+\>\"(.+)\"<\/p.+/gm)
        // console.log(D);
        let stng = document.createElement('strong');
        stng.innerHTML = (D[6]);
        console.log(D[8]);
        let p8 = (D[8].length > 0)?D[8].join(","):"Não possui!";
        

        let hideText = stng.querySelector('p.sr-only').innerText;
        return `
            <div class='container-fluid text-dark'>

                <div class="row">
                    <div class="col-3 text-right"><h6 class="text-dark">${D[0]} - Detalhes:</h6></div>
                    <div class="col-3 font-weight-bold">Descricao</div>
                    <div class="col-3 font-weight-bold">Disciplinas</div>
                    <div class="col-3 font-weight-bold">Materiais</div>
                </div>
                <div class="row">
                    <div class="col-3">&ensp;</div>
                    <div class="col-3">${hideText.replace(/\"/g,'')}</div>
                    <div class="col-3">${D[7].replace(/\,/gm,", ")}</div>
                    <div class="col-3">${p8}</div>
                </div>
            </div>
        `
    }
    
    
    const genButton =(id,f,S)=>{
        return `<span onclick="${f}(${id})"><i class='fa ${S}'></i></span>`
    }
    function refreshDados(){
        tabelaAgenda.ajax.reload();
    }
    async function mostraDados(id){
        async function getRowData(){
            let dados = await fetch(`${apiurl}/calendar/item/${id}`);
            let novos = await dados.json();
            novos = novos.data[0];
            novos[5] = new Date(novos[5]).toLocaleString();
            return novos;  
        }
        let response = await getRowData();
        return response;
        
    }
    async function cancelaAgenda(agendaid){
        try{
            let response = await fetch(`${apiurl}/agenda/cancel/${agendaid}`,{
                "method":"post"
            });
            let resp = await response.json();
            console.log(resp);
            if(resp.Success){
                tabelaAgenda.ajax.reload();
                alert('Agendamento cancelado com sucesso!');
            }
        }catch(err){
            alert(`não foi possivel cancelar:${err}`);
        }
    }
    async function confirmaAgenda(agendaId){
        try{
            let resp = await fetch(`${apiurl}/agenda/auth/${agendaId}`,{
                    "method":"post"
                })
            let response = await resp.json();
            if(response.Success){
                alert("sala Agendada com successo!");
                tabelaAgenda.ajax.reload();
            }
        }catch(e){
            alert(`não foi possivel cancelar:${e}`);
        }
        
    }
    let tabelaAgenda = null;
    (async function(){
        // let agenda = await fetch("http://localhost/API/calendar");
       tabelaAgenda = await $('#agenda').DataTable({
            lengthChange: false,
            pageLength:5,
            order: [5, 'asc' ],
            dom:'f<"#modo">Btp',
            scrollX:true,
            ajax:{
                url:"http://localhost/API/agenda",
                dataSrc:function(dados){
                    
                    dados.data.forEach(dado=>{
                        let ExtButtons = '';
                        // mostraDados
                        // `<p aria-hiddena="true" class='sr-only'>${JSON.stringify(dado)}</p>`+
                        let agendaStatus = dado[dado.length-1];
                        // console.log(agendaStatus)
                        
                        let userRole = document.querySelector('.user-role').innerText;
                        function roleHasPermission(){
                            if(userRole == 'Monitor' || userRole == 'Professor') return false;
                            if(userRole == 'Coordenador') return true;
                            return false;

                        }
                        
                        //0 -> em aberto / 1 -> cancelado  /2 -> confirmado
                        switch(parseInt(agendaStatus)){
                            case 2:
                            ExtButtons = (roleHasPermission())?
                                "<br><span class='badge badge-sm badge-success'><i class='fa fa-check'></i></span>&ensp;"+
                                genButton(dado[0],"cancelaAgenda",'fa-times-rectangle tgd fa-lg icon-general-dt'):
                                "&ensp;<span class='badge badge-sm badge-success'><i class='fa fa-check'></i></span>&ensp;";
                                break;
                            case 1:
                                ExtButtons = 
                                    "&ensp;<span class='badge badge-sm badge-danger '><i class='fa fa-times'></i></span>"
                                break;
                            default:
                            case 0:
                            ExtButtons = 
                                (roleHasPermission())?
                                '<br>'+
                                genButton(dado[0],"confirmaAgenda",'fa-check-square tgs fa-lg icon-general-dt')+'&ensp;'+
                                genButton(dado[0],"cancelaAgenda",'fa-times-rectangle tgd fa-lg icon-general-dt'):
                                "&ensp;<span class='badge badge-pill badge-warning '><i class='fa fa-warning'></i> Em aberto</span>";
                                break;
                        }   
                        
                        dado[6] = (
                            `<p aria-hiddena="true" class='sr-only'>${JSON.stringify(dado[6])}</p>`+
                            genButton(dado[0],"",'fa-eye-slash fa-lg icon-Control-Dt icon-general-dt')+
                            ExtButtons
                        )
                        dado[5] = new Date(dado[5]).toLocaleString();
                    })
                    return dados.data
                },

            },
            columnDefs:[
                {
                    targets:[-1],
                    orderable:false
                }
            ],
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: { columns: [0,1,2,3,4,5] }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: { columns: [0,1,2,3,4,5] }
                }
            ],
        })
        /* <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-primary" name="button">
            <i class="fa fa-user-plus"></i> Cadastrar
        </button>
        */
        document.querySelector("#modo").innerHTML = 
            `<button type='button' class='btn btn-primary mb-2' onclick='refreshDados()'><i class='fa fa-refresh'></i></button>`;
        $('#agenda tbody').on('click','i.icon-Control-Dt',function(elm){
            var tr = $(this).closest('tr');
            var row = tabelaAgenda.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');

            }else {
                // Open this row
                try{
                    let oldTr = document.querySelector('#agenda tbody').querySelector('.shown');
                    if(oldTr !== null){
                        let oldRow = tabelaAgenda.row(oldTr);
                        oldRow.child.hide();
                        console.log(oldTr instanceof HTMLTableRowElement,oldTr.classList.toggle('shown'));
                    }
                }catch(e){
                    console.log("{ meu erro: "+e+"}")
                }

                row.child( newChildDatatable(row.data()) ).show();
                tr.addClass('shown');
            }
            
        })
        
    })()
</script>
<style>

.icon-general-dt{
    padding: 2px 2px;
    cursor:pointer;
    color: #868e96;
}
.icon-general-dt.tgd:hover::before{
    font-size: x-large;
    color: #dc3545;
    content:"\f00d"
}
.icon-general-dt.tgs:hover::before{
    font-size: large;
    color:  #28a745;
    content:"\f00c"
}
.icon-Control-Dt{
    
    font-size:'56pt' !important;
    color:#868e96;
}
.icon-Control-Dt:hover::before{
    font-size: 16pt;
    color:#17a2b8 !important;
    content:"\f06e" 
}

table>tbody>tr>td[colspan="7"]{
    background-color:rgba(223, 234, 245, 0.7) !important;
}
table>tbody>tr>td>span.badge{
    cursor: pointer;
}



</style>
</html>