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
            self::$pdo = new PDO('mysql:host=localhost;dbname=dbgerenciadorusuarios', 'root', '');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return (self::$pdo) ? self::$pdo : false;
    }

}
