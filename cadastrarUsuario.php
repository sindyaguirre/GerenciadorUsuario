<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();

if (isset($_POST['btCadastrar'])) {
    $arrayResponse = $objUsuario->queryInsert($_POST);
    echo '<script type="text/javascript">alert("' . $arrayResponse['msg'] . '");</script>';

    if ($arrayResponse['status'] == true) {
        if(isset($_POST))
        unset($_POST);
        //header('location: /' . ROOT . '/listarUsuarios.php');
       // die;
    }
}

if (isset($_POST['btAlterar'])) {

    //utilizar funcao default
    $arrayResponse = $objUsuario->queryUpdate($_POST);
    
    if(isset($usuario))
    unset($usuario);

    echo '<script type="text/javascript">alert("' . $arrayResponse['msg'] . '");</script>';
    if ($arrayResponse['status'] == true) {
        //header('location: /' . ROOT . '/listarUsuarios.php');
    }
}

if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'edit':
            $arrayReturn = $objUsuario->querySeleciona($_GET['func']);
            $usuario = $arrayReturn['arrayDados'];

            break;
    }
}

include 'header.php';
include 'menu.php';
?>

<div><h1 class=""><small><?php echo TITULO_USUARIO; ?></small></h1></div>

<div id="formulario">

    <form id="formCadastro" name="formCadastro" action="" method="post">
        <div class="container">
            <div class="">

                <label>Nome: </label><br>
                <input type="text" id="crud_nome" name="crud_nome" required="required" 
                value="<?= isset($usuario['crud_nome']) ? $usuario['crud_nome'] : "" ?>"><br>

                <label>Telefone: </label><br>
                <input type="text" id="crud_fone_celular" name="crud_fone_celular" required="required" 
                value="<?= isset($usuario['crud_fone_celular']) ? $usuario['crud_fone_celular'] : "" ?>"><br>

                <label>UF: </label><br>
                <select name="crud_uf" id="crud_uf">
                    <?php
                    foreach ($objFuncoes->listarEstados(2) as $key => $value) {
                        $selected = isset($usuario['crud_uf']) && $usuario['crud_uf'] == $key ? "selected='true'" : false;
                        ?>
                        <option <?= $selected ?> value="<?= $key ?>"><?= $value ?></option>
                    <?php } ?>
                </select>
                <label>Cidade: </label><br>
                <input type="text" id="crud_cidade" name="crud_cidade" required="required" value="<?= isset($usuario['crud_cidade']) ? $usuario['crud_cidade'] : "" ?>"><br>
            </div>
            <div class="">

                <input type="submit" name="<?= (isset($_GET['acao']) == 'edit') ? ('btAlterar') : ('btCadastrar') ?>" value="<?= (isset($_GET['acao']) == 'edit') ? ('Alterar') : ('Cadastrar') ?>">
                <!--CRIAR BOTÃO PARA LIMPAR FORMULARIO, E VOLTAR A TELA INICIAL-->

                <input type="hidden" id="crud_codigo" name="func" value="<?= (isset($usuario['crud_codigo'])) ? ($objFuncoes->base64($usuario['crud_codigo'], 1)) : ('') ?>">
            </div>
        </div>
    </form>
</div>

<?php
include 'footer.php';
?>