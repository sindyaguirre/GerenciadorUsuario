<?php

/* Define o limite de tempo da sessão em 60 minutos */
//session_cache_expire(60);

// Inicia a sessão
//session_start();


/**
 * Description of Conexa
 *
 * @author Sindy Antunes Aguirre
 * @email sindy_antunes@hotmail.com github https://github.com/sindyaguirre
 */

class Conexao {

    private static $pdo;

    public function __construct()
    {
        
    }

    public static function conectar()
    {
        if (is_null(self::$pdo))
        {
            
           try{

               if($_SERVER['HTTP_HOST']=='localhost'){
                    $host="localhost";
                    $dbname="dbgerenciadorusuarios";
                    $user="root";
                    $passw="";
 
               }else{
                    $host="";
                    $dbname="";
                    $user="";
                    $passw="";
               }
                self::$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $passw);

                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           }catch(PDOException $Exception){
                throw new MyDatabaseException($Exception->getMessage());
           }
        }
        return (self::$pdo) ? self::$pdo : false;
    }

}
