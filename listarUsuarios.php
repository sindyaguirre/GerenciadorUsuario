<?php
require_once 'classes/Funcoes.class.php';
require_once 'classes/Usuario.class.php';

$objFuncoes = new Funcoes();
$objUsuario = new Usuario();

$where = " WHERE 1";
$orderBy = " ORDER BY crud_codigo ASC";

if (isset($_POST['btnConsult']))
{
    $where = "";
    foreach($_POST as $key=>$value){
        
        if($key!="btnConsult"&&!empty($value)){

            $where .= " OR ".$key ." LIKE '%".$value."%' ";
            $orderBy .= ",".$key." ASC";
        }
    }    
        $where = " WHERE ".(empty($where)?" 1 ":substr($where,3));
        $orderBy = substr($orderBy,0,strlen($orderBy));
}
if (isset($_GET['acao']))
{
    switch ($_GET['acao'])
    {

        case 'edit':
            header('location: /' . ROOT.'/cadastrarUsuario.php?acao=edit&func='. $objFuncoes->base64($_GET['func'], 1));
            break;
        case 'delet':

            if ($objUsuario->queryDelete($_GET['func']) == 'ok')
            {
                header('location: /' . ROOT . '/listarUsuarios.php');
            }
            else
            {
                echo '<script type="text/javascript">alert("Erro em deletar");</script>';
            }
            break;
    }
}

include 'header.php';
include 'menu.php';
?>
<div><h1 class=""><small><?php echo TITULO_USUARIO; ?></small></h1></div>
<div id="formulario">

    <form id="formConsultar" name="formConsultar" action="" method="post">
        <div class="col-12">
            <div class="col-4">
                <label>Nome: </label>
                <input type="text" id="crud_nome" name="crud_nome" 
                value="<?= isset($_POST['crud_nome']) ? $_POST['crud_nome'] : "" ?>">
            </div>
            <div class="col-4">
                <label>Telefone: </label>
                <input type="text" id="crud_fone_celular" name="crud_fone_celular" 
                value="<?= isset($_POST['crud_fone_celular']) ? $_POST['crud_fone_celular'] : "" ?>">
            </div>
            <div class="col-4">
                <label>Cidade: </label> 
                <input type="text" id="crud_cidade" name="crud_cidade" value="<?= isset($_POST['crud_cidade']) ? $_POST['crud_cidade'] : "" ?>">
            </div>
            <div class="col-4">
            <label></label>
                <input type="submit" name="btnConsult" value="Consultar">
                <!--CRIAR BOTÃO PARA LIMPAR FORMULARIO, E VOLTAR A TELA INICIAL-->

            </div>
        </div>
    </form>
</div>
<div>
    <table class="tablesorter table table-striped tabelaUsuarios">
        <thead>
            <tr>
                <th scope="col">Codigo</th>
                <th scope="col">Nome</th>
                <th scope="col">Telefone</th>
                <th scope="col">UF</th>
                <th scope="col">Cidade</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            /*
                aqui neste objeto verificar se há filtro, 
            */
            foreach ($objUsuario->querySelect($where, $orderBy) as $rst)
            {
                ?>
                <tr>
                    <td scope="row"><?php echo $rst['crud_codigo']; ?></td>
                    <td><?php echo $rst['crud_nome'] ?></td>
                    <!--td><?php // echo $objFuncoes->tratarCaracter($rst['crud_nome'], 2);       ?></td-->
                    <td><?php echo $rst['crud_fone_celular']; ?></td>
                    <td><?php echo $objFuncoes->listarEstados(1,$rst['crud_uf']); ?></td>
                    <td><?php echo $rst['crud_cidade']; ?></td>
                    <td>
                        <div class="">
                            <a class="editar" href="/<?=ROOT?>/cadastrarUsuario.php?acao=edit&func=<?= $objFuncoes->base64($rst['crud_codigo'], 1) ?>" title="Editar dados"><img src="img/ico-editar.png" width="16" height="16" alt="Editar"></a>
                            <a class="excluir" href="?acao=delet&func=<?= $objFuncoes->base64($rst['crud_codigo'], 1) ?>" title="Excluir esse dado"><img src="img/ico-excluir.png" width="16" height="16" alt="Excluir"></a>
                        </div>
                    </td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>