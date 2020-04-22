<?php

include_once 'Conexao.class.php';
include_once 'Funcoes.class.php';

class Usuario {

    private $con;
    private $objFuncoes;
    private $crud_nome;
    private $crud_fone_celular;
    private $crud_uf;
    private $crud_cidade;
    private $crud_codigo;

    public function __construct()
    {
        $this->con = new Conexao();
        $this->objFuncoes = new Funcoes();
    }

    /**
     * 
     * @param type $atributo
     * @param type $valor
     */
    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    /**
     * 
     * @param type $atributo
     * @return type
     */
    public function __get($atributo)
    {
        return $this->$atributo;
    }

    /**
     * 
     * @param type $dado
     * @return type
     */
    public function querySeleciona($dado){
        try {
            $this->crud_codigo = (int) $this->objFuncoes->base64($dado, 2);

            $select = $this->con->conectar()->prepare("SELECT * FROM `crud` WHERE `crud_codigo` = ?");
            $result = $select->execute(array($this->crud_codigo));

            //verificando se a consulta foi feita com sucesso
            if (!$result)
            {
                $erro = $select->select->errorInfo();
                exit($erro[2]);
            }
            //buscando os dados na linha encontrada
            $arrayReturn = array(
                'status' => $status = $result,
                'arrayDados' => ( $status == true ? $select->fetch() : "")
            );
            return $arrayReturn;
        } catch (Exception $ex) {
            return "error " . $ex->getMessage();
        }
    }

    /**
     * 
     * @return type
     */
    public function querySelect()
    {
       try {
            $select = $this->con->conectar()->prepare("SELECT * FROM `crud`;");
            $select->execute();
            return $select->fetchAll();
        } catch (Exception $ex) {
            return 'erro ' . $ex->getMessage();
        }
    }
    /**
     * 
     * @return type
     */
    public function queryVerificarCampoExiste($str,$nomeColuna)
    {
       try {
            $select = $this->con->conectar()->prepare("SELECT * FROM `crud` WHERE ".$nomeColuna."= '$str' ;");
            $select->execute();
            //var_dump($select->fetchAll());die();
            return $select->fetchAll();
        } catch (Exception $ex) {
            return 'erro ' . $ex->getMessage();
        }
    }

    /**
     * 
     * @param type $dados
     * @return string
     */
    public function queryInsert($dados)
    {
        try {
            //$this->nome = $this->objFuncoes->tratarCaracter($dados['nome'], 1);
            $this->crud_nome = $dados['crud_nome'];
            $this->crud_fone_celular = $dados['crud_fone_celular'];

            $existeNome = $this->queryVerificarCampoExiste($this->crud_nome,'crud_nome');
            $existeFone = $this->queryVerificarCampoExiste($this->crud_fone_celular,'crud_fone_celular');

            /**
             * verifificar se o nome ou telefone já não existem
             */
            if((is_array($existeNome)&&!empty($existeNome))||(is_array($existeFone)&&!empty($existeFone))){
                header('location: /' . ROOT . '/resposta.php');
            }else{

                $this->crud_uf = $dados['crud_uf'];
                $this->crud_cidade = $dados['crud_cidade'];

                $cad = $this->con->conectar()->prepare(
                        'INSERT INTO crud (`crud_nome`, `crud_fone_celular`,`crud_uf`,`crud_cidade`)'
                        . ' VALUE (:crud_nome, :crud_fone_celular, :crud_uf, :crud_cidade);');
                $cad->bindParam(":crud_nome", $this->crud_nome, PDO::PARAM_STR);
                $cad->bindParam(":crud_fone_celular", $this->crud_fone_celular, PDO::PARAM_STR);
                $cad->bindParam(":crud_uf", $this->crud_uf, PDO::PARAM_STR);
                $cad->bindParam(":crud_cidade", $this->crud_cidade, PDO::PARAM_STR);

                if ($cad->execute())
                {
                    return 'ok';
                }
                else
                {
                    return 'erro';
                }
            }

        } catch (Exception $ex) {
            return 'error ' . $ex->getMessage();
        }
    }

    public function queryUpdate($dados)
    {
        try {
            $this->crud_codigo = $dados['crud_codigo'];
            $this->crud_nome = $dados['crud_nome'];
//            $this->nome = $this->objFuncoes->tratarCaracter($dados['nome'], 1);
            $this->crud_fone_celular = $dados['crud_fone_celular'];
            $this->crud_cidade = $dados['crud_cidade'];
            $this->crud_uf = $dados['crud_uf'];
            $cst = $this->con->conectar()->prepare("UPDATE `crud` SET 
            `crud_nome` = :crud_nome,
            `crud_fone_celular` = :crud_fone_celular,
            `crud_cidade` = :crud_cidade,
            `crud_uf` = :crud_uf WHERE `crud_codigo` = :crud_codigo;");
            $cst->bindParam(":crud_codigo", $this->crud_codigo, PDO::PARAM_INT);
            $cst->bindParam(":crud_nome", $this->crud_nome, PDO::PARAM_STR);
            $cst->bindParam(":crud_fone_celular", $this->crud_fone_celular, PDO::PARAM_STR);
            $cst->bindParam(":crud_cidade", $this->crud_cidade, PDO::PARAM_STR);
            $cst->bindParam(":crud_uf", $this->crud_uf, PDO::PARAM_STR);
            if ($cst->execute())
            {
                return 'ok';
            }
            else
            {
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error ' . $ex->getMessage();
        }
    }

    public function queryDelete($dado)
    {

        try {
            $this->crud_codigo = $this->objFuncoes->base64($dado, 2);
            $cst = $this->con->conectar()->prepare("DELETE FROM `crud` WHERE `crud_codigo` = :idusu;");
            $cst->bindParam(":idusu", $this->crud_codigo, PDO::PARAM_INT);
            if ($cst->execute())
            {
                return 'ok';
            }
            else
            {
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error' . $ex->getMessage();
        }
    }


}
