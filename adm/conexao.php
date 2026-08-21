	<?php
//variaveis de conexao
	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$dbname = "loja";


	try {

		$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=UTF8", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $erro) {
		header("Ocorreu o seguinte erro: " . $erro->getMessage());
	}

	?>