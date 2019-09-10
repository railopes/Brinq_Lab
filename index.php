<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>UMC-Brinquedoteca</title>
	<script src="utils.js"></script>
</head>
<body>
	<table>
		<tr class="bolota">
			<td>NOME</td>
			<td>SENHA</td>
			<td>ID</td>
		</tr>
		<tr class="bolota">
			<td>Antonio Rai F. Lopes</td>
			<td>railopes786</td>
			<td>010</td>
		</tr>
		<tr class="bolota">
			<td>renan F. Lopes</td>
			<td>renandoidao</td>
			<td>011</td>
		</tr>
	</table>
<script>
	function sendTable(){
		const minha_tabela = document.getElementsByTagName('table')[0];
		const jsonTable = tableToJson(minha_tabela);
		let http = {
			method:'POST',
			url:"http://localhost/exportexcel.php",
			body:jsonTable,
			header:null,
		}
		$ajax.request(http,(res)=>{
			/*
			console.log(JSON.parse(res.response));
			const {File} = JSON.parse(res.response)
			window.location.href = 'ftp://localhost/'+File;
			*/
			console.log(res.response);
		})

	}
</script>

<input type="button" value="SendMyHTML" onclick="sendTable();">

</body>
</html>