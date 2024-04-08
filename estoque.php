<!doctype html>
<html lang="pt-br" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Estetica</title>
  <link rel="stylesheet" href="estoque.css">
  <link rel="shortcut icon" href="img/senacMG.ico" type="image/x-icon">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      display: flex;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #004384; /* Altere a cor de fundo conforme necessário */
    }
    .container {
      width: 80%;
      max-width: 1200px;
      padding: 20px;
      color: black;
      background-color: #fff; /* Altere a cor de fundo conforme necessário */
      border-radius: 10px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.3); /* Ajuste o valor da sombra conforme necessário */
    }
    .input-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }
    .input-container > div {
      width: calc(20% - 10px);
      margin-bottom: 10px;
    }
    .input-container input[type="text"],
    .input-container input[type="date"] {
      width: calc(100% - 10px);
      padding: 10px;
      border: 1px solid black; /* Cor da borda padrão do Bootstrap */
      border-radius: .25rem;
      box-sizing: border-box;
      background-color: #fff; /* Background branco */
      color: black; /* Cor do texto preto */
    }
    .input-container button {
      width: calc(20% - 10px);
      padding: 10px;
      border: none;
      border-radius: .25rem;
      background-color: rgb(194, 128, 5); /* Cor de fundo padrão do Bootstrap */
      color: #fff; /* Cor do texto padrão do Bootstrap */
      cursor: pointer;
    }
    .input-container button:hover {
      background-color: #0056b3; /* Cor de fundo do hover padrão do Bootstrap */
    }
    .tabela {
      margin-top: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #007bff;
      color: #fff;
    }
  </style>
</head>
<body>
<header>
  <div class="logo"></div>
  <label class="titulo" for="titulo">Controle De Estoque</label>
  <div class="foto">
    <div class="foto2"></div>
  </div>
  <div class="conta">
        <?php
        // Inicie a sessão
        session_start();
        
        // Verifique se o nome do usuário está na sessão
        if (isset($_SESSION['Nome'])) {
            echo "Bem-vindo, " . $_SESSION['Nome'] . "!";
        } else {
            echo "Usuário não autenticado.";
        }
        ?>
    </div>
</header>
<br><br><br>
  <div class="container">
    <div class="input-container">
      <div>
        <p>Produto:</p>
        <input type="text" name="nome_produto" id="nome_produto" maxlength="45">
      </div>
      <div>
        <p>Quantidade:</p>
        <input type="text" name="quantidade_produto" id="quantidade_produto" maxlength="3">
      </div>
      <div>
        <p>Lote:</p>
        <input type="text" name="lote_produto" id="lote_produto" maxlength="5">
      </div>
      <div>
        <p>Curso:</p>
        <input type="text" name="curso" id="curso">
      </div>
      <div>
        <p>Data de Validade</p>
        <input class="validade" type="text" name="data_validade" id="data_validade" placeholder="dd/mm/aaaa" maxlength="10">
      </div>
      <button class="adicionar btn-warning" type="button" name="btnAjax" id="btnAjax">Inserir</button>
    </div>
    <div class="mensagem" name="mensagem" id="mensagem"></div>
  </div>
  <br><br>
  <div class="container">
    <div class="tabela">
    <table class="table table-striped">
          <th>ProdutoDescri</th>
          <th>ProdutoQtd</th>
          <th>ProdutoValidade</th>
          <th>ProdutoLote</th>
          <th>Curso</th>
          <th>--------</th>
        <?php require_once("./PDO/carregaTarefas.php"); ?>
      </table>
    </div>
  </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
  //Coloca a data atual no placeholder da data de validade
    var inputValidade = document.getElementById('data_validade');
    var dataAtual = new Date();
    var dia = String(dataAtual.getDate()).padStart(2, '0');
    var mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // Janeiro é 0!
    var ano = dataAtual.getFullYear();
    var dataFormatada = dia + '/' + mes + '/' + ano;
    inputValidade.placeholder = dataFormatada;


    //coloca uma "/" depois de dois digitos e coloca outra barra depois de 5 digitos
    inputValidade.addEventListener('input', function() {
    var valor = inputValidade.value;
    if (valor.length === 2 && valor.indexOf('/') === -1) {
        inputValidade.value += '/';
    } else if (valor.length === 5 && valor.lastIndexOf('/') === 2) {
        inputValidade.value += '/';
    }
});
});
</script>
</html>

<script>

// AJAX

  $(document).ready(function(){
    $('#btnAjax').click(function(){
      let mensagem = document.getElementById('mensagem');
      var Nome = $('#nome_produto').val();
      var Lote= $('#lote_produto').val();
      var Quantidade= $('#quantidade_produto').val();
      var Validade= $('#data_validade').val();
      var Curso= $('#curso').val();
      $.post("./PDO/bindValue.php",{
        nome: Nome,
        lote: Lote,
        quantidade: Quantidade,
        validade: Validade,
        curso: Curso,
      })
      .done(function(resposta) {
        mensagem.innerHTML = resposta
        // window.location.href = 'estoque.php'; //
      })
    })
  })
</script>