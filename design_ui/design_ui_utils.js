let formCadMaterial = document.querySelector('#formCadMaterial');
function prepareEventForms(event){
    event.stopPropagation();
    event.preventDefault();
}
formCadMaterial.addEventListener('submit',async ev=>{
    
    prepareEventForms(ev);
    document.querySelector('#qtd_atual').min = document.querySelector('#qtd_minima').value;
    // document.querySelector('#onlyminustorage').dispatchEvent(new Event('click'));
    
    if(!formCadMaterial.checkValidity()){
        formCadMaterial.classList.add('was-validated');
    }else{
        try{
            formCadMaterial.classList.remove('was-validated');
          let cad=  await cadNewMaterial(getSerialized());
          
          await $("#addItemEstoqueModal").modal('hide');
          setTimeout(ev=>{
             if(cad.Id) alert('cadastrado com sucesso! id: [ '+cad.Id+" ]");
            formCadMaterial.reset();
        },500);
            let xx = await getMaterials();
            let itemAppend = xx[xx.length-1];
            let styleProp =`style="cursor:pointer"`; 
            if(parseFloat(itemAppend[2]) < parseFloat(itemAppend[3])) {
                itemAppend[1] =  `<span class="text-danger font-weight-bold text-uppercase">${itemAppend[1]}</span>`
            }
            itemAppend[7]= 
                `
                    <span><i ${styleProp} class='fa fa-edit text-warning fa-2x' onclick="openEditStorage(${itemAppend[0]})"></i></span>&ensp;
                    <span><i ${styleProp} class='fa fa-trash text-danger fa-2x' onclick="openDeleteStorage(${itemAppend[0]})"></i></span>
                `
            tabelamateriais.rows.add([itemAppend]).draw();
            tabelamateriais.page('last').draw('page');
          return true;

        }catch(error){
            console.log(error)
            alert('material não pôde ser cadastrado!: Erro: '+JSON.stringify(error));
        }
    }
});

let cancelCadMateriaisBtn = document.querySelector('#cancelCadMateriaisBtn');
cancelCadMateriaisBtn.onclick = async ev=>{
    formCadMaterial.reset();
}
function newCmpDisciplina(){
    return document.querySelector(".camposDaDisciplina").appendChild(
        document.querySelector(".cmpDisciplina").cloneNode(true)
    );
}
function removeUltimaDisciplina(){
    let disciplinasCampos =document.querySelectorAll(".cmpDisciplina");
    if(disciplinasCampos.length == 1) return false;
    disciplinasCampos[disciplinasCampos.length-1].outerHTML = "";
    return true;
}