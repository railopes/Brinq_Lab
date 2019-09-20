function ocult_parent(sender){
	const toOcult = sender.parentNode;
	toOcult.style.display = 'none';
}

function tableToJson(table) {
	var data = [];
	var headers = [];
	for (var i=0; i<table.rows[0].cells.length; i++) {
	 headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi,'');
	}
	// go through cells
	for (var i=1; i<table.rows.length; i++) {
		var tableRow = table.rows[i]; var rowData = {};
		for (var j=0; j<tableRow.cells.length; j++) {
			rowData[ headers[j] ] = tableRow.cells[j].innerHTML;
		}
	data.push(rowData);
	}
	return data;
}

const $ajax = {
    response:{},
    request:function(http,execute){
        var xhr = new XMLHttpRequest();
        if(execute == undefined || execute == null || typeof execute != 'function' ){throw new Error("callback function not defined")}
        xhr.onreadystatechange = function(){
            if(this.readyState == 4 && (this.status == 200 || this.status == 201)){
				
				$ajax.response = {
					res:this.response,
					resType:this.responseType,
					resText:this.responseText,
					isValid:(this.statusText == 'OK') ? true :false,
					status:this.status,
				}
				execute(this,$ajax.response);
            }
        }
        const {body,method,url} = http;
        try{ xhr.onload = http.loading() }catch(e){}
        xhr.open(method,url);
        xhr.send(JSON.stringify(body));
    }
}
function nextItem(currentNumber){
	
}
const makeGridView =(content,divDestiny)=>{
    const {dataTable} = content;
    const headers = Object.keys(dataTable[0])
	let table = document.createElement('table');
	let linha = document.createElement('tr');
	headers.forEach((e,idx)=>{
		
		let th = document.createElement('th');
		th.innerHTML = e.toUpperCase();
		linha.appendChild(th);
		table.appendChild(linha);
	});
	dataTable.forEach((currentLine)=>{
		let row = document.createElement('tr');
		headers.forEach((campo)=>{
			let column = document.createElement('td');
			column.innerHTML = currentLine[campo];
			row.appendChild(column);
		});
		table.appendChild(row);
	});
	divDestiny.innerHTML = '';
	divDestiny.appendChild(table);
}
