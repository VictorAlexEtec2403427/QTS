<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETEC Games</title>


</head>
<body>

   

      <p>Cadastro de Games</p>  


   <form name="form1" method="post" action="cad_game.php" enctype="multipart/form-data">

       
          <label>Nome do Game</label>
          <input type="text" id="nome" name="nome" required>
        
         <label>Plataforma</label>
            <select id="plataforma" name="plataforma">
              <option selected>Selecione uma opção:</option>
              <option>PlayStation 4</option>
              <option>PlayStation 5</option>
              <option>Xbox One</option>
			  <option>Xbox 360</option>
            </select>
        
	
          <label>Preço</label>
         <input type="text" id="preco" name="preco"  required >
       
        <label>Novidade</label>
          <select id="novidade" name="novidade" required>
            <option selected>Informe se o produto é novidade</option>
            <option>S</option>
            <option>N</option>
          </select> 
       
          <label>Selecione a Imagem</label>
          <input type="file" id="arquivo" name="arquivo">
        
          <button type="submit" name="cadastrar">Cadastrar</button>
        </div>
 
      </form>
    
  
	<?php
//chamar o arquivo de conexao
require_once "conexao.php";
try{
//verifica se o botão Cadastrar foi clicado
if(isset($_REQUEST["cadastrar"]))
	
{
    //se botão não estiver vazio receba os dados do formulario
    $nome = $_REQUEST["nome"];
    $plataforma = $_REQUEST["plataforma"];
    $preco = $_REQUEST["preco"];
    $novidade = $_REQUEST["novidade"];
	
	
	
		// CÓDIGO UPLOAD imagem
			//definindo timezone - data e hora
			date_default_timezone_set('America/Sao_Paulo');
			$data = date("d-m-Y");
			$time = date("H-i-s");

			
			//verifica o arquivo para upload
			$nomeimg =  $_FILES["arquivo"]["name"];
			$temp =     $_FILES["arquivo"]["tmp_name"]; /*caminho temporário do arquivo*/
			

			//verifica a extensao do arquivo
			$ext = pathinfo($nomeimg, PATHINFO_EXTENSION);

		
			//renomear o nome da imagem
			$novo_nomeimg = 'imagem' . '_' . $time .  '_'. $data . '.' . $ext;

			//Comando para mover o arquivo para a pasta img- atenção - a pasta img deverá estar em games
			$mover = move_uploaded_file($temp, 'img/' . $novo_nomeimg);


			//CRIANDO CAMINHO DO ARQUIVO
			$arquivo = 'img/' . $novo_nomeimg;
    
	
	

    //variavel com os dados de gravação na tabela
    $sql = $conn->prepare("INSERT INTO games(codgame, nome, plataforma, preco, arquivo, novidade)
                                          VALUES (:codgame, :nome, :plataforma, :preco, :arquivo, :novidade) ");
         
         //passagem de parametros para a tabela
        $sql->bindValue(':codgame',null);
        $sql->bindValue(':nome',$nome);
        $sql->bindValue(':plataforma',$plataforma);
        $sql->bindValue(':preco',$preco);
        $sql->bindValue(':arquivo', $arquivo);
		$sql->bindValue(':novidade', $novidade);
		
		
		
        
        //execução da query de inserção
        $sql->execute();
        //msg caso não ocorra erro
        echo "<script language=javascript>
        alert('Dados gravados com Sucesso !!');
        location.href = 'cad_game.php';
        </script>";	
    } //caso não executar captura o erro no sgbd
}catch (PDOException $erro) 
    {
        echo $erro->getMessage();
    }
    
//fecha o if 
?>

 <!-- Lista de Games Cadastrados -->
 <p>Games Cadastrados</p>  


<table>
  
    <tr>
      <th>Código do Game</th>
      <th>Nome do Game</th>
      <th>Plataforma</th>
      <th>Preço</th>
      <th>Imagem</th>
      <th>Novidade</th>
    </tr>
  
  
       <?php	
try{
	
	//cria a variavel consulta que ira armazenar resultado sql
	$consulta = $conn->prepare("SELECT * FROM games;");
	$consulta->execute();
	
	//codigo para consulta
	while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
	?>	
    <tr>
      <td><?php echo $row["codgame"]?></td>
      <td><?php echo $row["nome"]?></td>
      <td><?php echo $row["plataforma"]?></td>
      <td><?php echo $row["preco"]?></td>
      <td><img src="<?php echo $row["arquivo"]?>"></td>
	  <td><?php echo $row["novidade"]?></td>
    </tr>
 
<?php		
	}
	
}
catch (PDOException $erro) {
	echo $erro->getMessage();
}
?>
  
</table>
</div>


</body>
</html>