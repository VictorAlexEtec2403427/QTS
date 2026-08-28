<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid justify-content-center">
                <a class="navbar-brand" href="#"> 
                    <img src="./imagens/logo.png" class="bg-dark" alt="ETEC games"> 
                </a>
            </div>
        </nav>
    </header>
    
    <section class="container mt-5">
        <p class="fs-1 text-center">Cadastro de Games</p>
        
        <!-- Linha centralizada para conter o formulário com largura controlada -->
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-6">
                <form class="row g-3" name="form1" method="post" action="cadastrar_games.php" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label for="inputEmail4" class="form-label">Nome do Game</label>
                        <input type="text" class="form-control" id="inputEmail4" name="nome">
                    </div>
                    <div class="col-md-12">
                        <label for="inputState" class="form-label">Plataforma</label>
                        <select id="inputState" class="form-select" name="plataforma">
                            <option selected>Selecione uma opção:</option>
                            <option>Playstation 4</option>
                            <option>Playstation 5</option>
                            <option>Xbox One</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">Preço</label>
                        <input type="number" class="form-control" id="inputCity" name="preco">
                    </div>
                    <div class="col-md-6">
                        <label for="inputStateNovidade" class="form-label">Novidade</label>
                        <select id="inputStateNovidade" class="form-select" name="novidade">
                            <option selected>S</option>
                            <option>N</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="inputZip" class="form-label">Selecionar a Imagem</label>
                        <input type="file" class="form-control" id="inputZip" name="arquivo">
                    </div>
                    <div class="col-3 text-center">
                        <button type="submit" class="btn btn-primary px-5" name="cadastrar">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
    <script src="../games/js/bootstrap.min.js"></script>
</body>
</html>

<?php
    //chamar o arquivo de conexao
    require_once "conexao.php";
    try{
        //verifica se o botão Cadastrar foi clicado
        if(isset($_REQUEST["cadastrar"])){

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
            location.href = 'cadastrar_games.php';
            </script>";	
        }
    }catch (PDOException $erro){ //caso não executar captura o erro no sgbd
        echo $erro->getMessage();
    }

//fecha o if 
?>