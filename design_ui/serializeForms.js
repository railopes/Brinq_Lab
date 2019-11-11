



class serializeForm{
    constructor(){
        function protoSerialize(){
            HTMLFormElement.prototype.serialize = function(){
                let formElement =  this;
                let formAllCamps = Array.from(formElement.querySelectorAll('input,select'));
                let response ={};
                formAllCamps.forEach((campo,i)=>{
                    if(campo.value!=null && campo.value != ""){
                        if(Object.keys(response).includes(campo.name||campo.id)){
                            let campoNome = campo.name||campo.id;
                            let valorAnterior = response[campoNome];
                            if(Array.isArray(response[campoNome])){
                                response[campoNome].push(campo.value);
                            }else{
                                response[campoNome] = [];
                                response[campoNome].push(valorAnterior,campo.value);
                            }
                            
                        }else{
                            response[campo.name||campo.id] = campo.value;
                        }
                    }
                    
                });
                
                if(Object.keys(response).length == 0) return null;
                return {body:response};
            }
        } 
        if(!HTMLFormElement.prototype.serialize) protoSerialize();         
    }
}
function valideFormulario(formulario) {
    if(!formulario.checkValidity()) formulario.classList.toggle("was-validated");
}
// $('#addItemEstoqueModal').on('hidden.bs.modal',ev=>{
//     let isForm = document.querySelector('form');
//     isForm.classList.remove('was-validated');
//     isForm.reset()
// })
let myformSerialize = new serializeForm();

async function getMaterials(){
    let apiurl = "localhost/API";
    let materials = await fetch(`http://${apiurl}/materiais`);
    return await materials.json();
}
async function cadNewMaterial(send){
    
    
	let resp = await fetch(`http://${apiurl}/materiais/add`,{
        body:JSON.stringify(send),
        method:'post'
    });
    return await resp.json();
    
}
function getSerialized(){
    return document.querySelector('form').serialize();
}
