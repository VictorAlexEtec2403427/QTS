
<?php
require_once "conexao.php";

// ==========================================
// CADASTRAR GAME
// ==========================================

if (isset($_POST["cadastrar"])) {

    try {

        // Receber dados do formulário
        $nome = trim($_POST["nome"]);
        $plataforma = $_POST["plataforma"];
        $preco = $_POST["preco"];
        $novidade = $_POST["novidade"];

        // Verificar campos obrigatórios
        if (empty($nome) || empty($plataforma) || $preco === "") {
            throw new Exception("Preencha todos os campos obrigatórios!");
        }

        // Verificar se uma imagem foi enviada
        if (
            !isset($_FILES["arquivo"]) ||
            $_FILES["arquivo"]["error"] !== UPLOAD_ERR_OK
        ) {
            throw new Exception("Selecione uma imagem válida!");
        }

        // Pasta onde as imagens serão armazenadas
        $pasta = "img/";

        // Criar pasta caso não exista
        if (!is_dir($pasta)) {
            mkdir($pasta, 0755, true);
        }

        // Verificar extensão da imagem
        $ext = strtolower(
            pathinfo($_FILES["arquivo"]["name"], PATHINFO_EXTENSION)
        );

        $extensoesPermitidas = ["jpg", "jpeg", "png", "gif", "webp"];

        if (!in_array($ext, $extensoesPermitidas)) {
            throw new Exception("Formato de imagem não permitido!");
        }

        // Verificar se o arquivo realmente é uma imagem
        if (getimagesize($_FILES["arquivo"]["tmp_name"]) === false) {
            throw new Exception("O arquivo enviado não é uma imagem!");
        }

        // Gerar nome único para a imagem
        $novo_nomeimg = uniqid("game_", true) . "." . $ext;

        // Caminho completo da imagem
        $arquivo = $pasta . $novo_nomeimg;

        // Mover imagem para a pasta img
        if (!move_uploaded_file(
            $_FILES["arquivo"]["tmp_name"],
            $arquivo
        )) {
            throw new Exception("Erro ao enviar a imagem!");
        }

        // Inserir dados no banco de dados
        // codgame é auto incremento
        $sql = $conn->prepare("
            INSERT INTO games
            (nome, plataforma, preco, arquivo, novidade)
            VALUES
            (:nome, :plataforma, :preco, :arquivo, :novidade)
        ");

        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":plataforma", $plataforma);
        $sql->bindValue(":preco", $preco);
        $sql->bindValue(":arquivo", $arquivo);
        $sql->bindValue(":novidade", $novidade);

        $sql->execute();

        echo "<script>
            alert('Game cadastrado com sucesso!');
            window.location.href = 'cadastrar_games.php';
        </script>";

        exit();

    } catch (Exception $erro) {

        echo "<script>
            alert(" . json_encode($erro->getMessage()) . ");
        </script>";

    } catch (PDOException $erro) {

        echo "Erro no banco de dados: " . htmlspecialchars($erro->getMessage());

    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Games</title>

    <link rel="stylesheet" href="./css/bootstrap.min.css">

</head>

<body>

    <!-- CABEÇALHO -->
    <header>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

            <div class="container-fluid justify-content-center">

                <a class="navbar-brand" href="#">

                    <img
                        src="./imagens/logo.png"
                        class="bg-dark"
                        alt="ETEC games"
                    >

                </a>

            </div>

        </nav>

    </header>


    <!-- FORMULÁRIO DE CADASTRO -->
    <section class="container mt-5">

        <p class="fs-1 text-center">
            Cadastro de Games
        </p>

        <div class="row justify-content-center">

            <div class="col-md-12 col-lg-6">

                <form
                    class="row g-3"
                    name="form1"
                    method="post"
                    action="cadastrar_games.php"
                    enctype="multipart/form-data"
                >

                    <div class="col-md-12">

                        <label for="nome" class="form-label">
                            Nome do Game
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="nome"
                            name="nome"
                            required
                        >

                    </div>


                    <div class="col-md-12">

                        <label for="plataforma" class="form-label">
                            Plataforma
                        </label>

                        <select
                            id="plataforma"
                            class="form-select"
                            name="plataforma"
                            required
                        >

                            <option value="">
                                Selecione uma opção:
                            </option>

                            <option value="Playstation 4">
                                Playstation 4
                            </option>

                            <option value="Playstation 5">
                                Playstation 5
                            </option>

                            <option value="Xbox One">
                                Xbox One
                            </option>

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label for="preco" class="form-label">
                            Preço
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="preco"
                            name="preco"
                            step="0.01"
                            min="0"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label for="novidade" class="form-label">
                            Novidade
                        </label>

                        <select
                            id="novidade"
                            class="form-select"
                            name="novidade"
                            required
                        >

                            <option value="S">S</option>
                            <option value="N">N</option>

                        </select>

                    </div>


                    <div class="col-md-12">

                        <label for="arquivo" class="form-label">
                            Selecionar a Imagem
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            id="arquivo"
                            name="arquivo"
                            accept="image/*"
                            required
                        >

                    </div>


                    <div class="col-12 text-center">

                        <button
                            type="submit"
                            class="btn btn-primary px-5"
                            name="cadastrar"
                        >

                            Cadastrar

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>


    <!-- LISTAGEM DOS GAMES -->
    <div class="container mt-5 mb-5">

        <h2 class="text-center mb-4">
            Games Cadastrados
        </h2>

        <div class="table-responsive">

            <table class="table table-bordered table-striped text-center align-middle">

                <thead>

                    <tr class="table-dark">

                        <th>Código do Game</th>

                        <th>Nome do Game</th>

                        <th>Plataforma</th>

                        <th>Preço</th>

                        <th>Imagem</th>

                        <th>Novidade</th>

                    </tr>

                </thead>


                <tbody>

                    <?php

                    try {

                        // Consultar todos os games
                        $consulta = $conn->prepare("
                            SELECT * FROM games ORDER BY codgame DESC
                        ");

                        $consulta->execute();

                        // Verificar se existem registros
                        if ($consulta->rowCount() > 0) {

                            // Percorrer os registros
                            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {

                    ?>

                                <tr>

                                    <td>
                                        <?php echo htmlspecialchars($row["codgame"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row["nome"]); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row["plataforma"]); ?>
                                    </td>

                                    <td>
                                        R$ <?php echo number_format(
                                            (float)$row["preco"],
                                            2,
                                            ",",
                                            "."
                                        ); ?>
                                    </td>

                                    <td>

                                        <img
                                            src="<?php echo htmlspecialchars($row["arquivo"]); ?>"
                                            alt="Imagem do game"
                                            class="img-fluid"
                                            width="80"
                                        >

                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row["novidade"]); ?>
                                    </td>

                                </tr>

                    <?php

                            }

                        } else {

                    ?>

                            <tr>

                                <td colspan="6">
                                    Nenhum game cadastrado.
                                </td>

                            </tr>

                    <?php

                        }

                    } catch (PDOException $erro) {

                        echo "<tr>
                            <td colspan='6'>
                                Erro ao consultar os games.
                            </td>
                        </tr>";

                    }

                    ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- BOOTSTRAP -->
    <script src="./js/bootstrap.bundle.min.js"></script>

</body>

</html>
