<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();

include 'header.php';
include 'menu.php';
/**
 * esta tela nao é a melhor forma de apresentar um erro, isto será feito com validator do jquery
 */
?>
<div><h1 class=""><small></small></h1></div>

<div class="container">

        <h5 style="color:red">Nome ou telefone já cadastrados<h5>
        <a href="http://localhost/GerenciadorUsuarios/cadastrarUsuario.php">Volte a tela de cadastro</a>
</div>
<?php
include 'footer.php';
?>