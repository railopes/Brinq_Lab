function procuraMaterialTipo(columnIndex,selectedvalue){
    return (selectedvalue ?
            tabelamateriais.column(columnIndex).search(selectedvalue).draw():
            tabelamateriais.column(columnIndex).search("").draw()
        );
}
let onlyuso = document.querySelector('#onlyUso');
document.querySelector('#filtroTipoMaterial').addEventListener('change',event=>{
    var tmp$$ = document.querySelector('#filtroTipoMaterial').value;
    document.querySelector('#filtroTipoMaterial').value = "";
    onlyuso.dispatchEvent(new Event('click'));
    document.querySelector('#filtroTipoMaterial').value = tmp$$;
    onlyuso.dispatchEvent(new Event('click'));
});
let onlyminustorage = document.querySelector('#onlyminustorage');

onlyminustorage.onclick = function(){
    
    let classes = onlyminustorage.classList;
    if(classes.contains("fa-toggle-off")){
        onlyminustorage.classList.replace("fa-toggle-off","fa-toggle-on");
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
        
                var qtd_min = parseFloat( data[3] ) || 0;
                var qtd_atual = parseFloat(data[2]) || 0;
                return qtd_atual < qtd_min;
            }
        );
        tabelamateriais.draw();
    }else{
        onlyminustorage.classList.replace("fa-toggle-on","fa-toggle-off");
        $.fn.dataTable.ext.search.pop();
        tabelamateriais.search("").draw();
    }
}
onlyuso.onclick = function(ev){
    ev.preventDefault();
    let valorProcurado = document.querySelector('#filtroTipoMaterial').value
    let classes = onlyuso.classList;
    if(classes.contains("fa-toggle-off")){
        onlyuso.classList.replace("fa-toggle-off","fa-toggle-on");
        procuraMaterialTipo(5,valorProcurado);
    }else{
        onlyuso.classList.replace("fa-toggle-on","fa-toggle-off");
        procuraMaterialTipo(5,"");
    }
}
function openEditStorage(){

    $("#addItemEstoqueModal").modal('show');
}