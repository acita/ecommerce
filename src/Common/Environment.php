<?php

class Environment{

    /**
     * Método responsável por carregar as variávies de ambiente
     * @param string $dir
     */

    public static function load($dir){

        if(!file_exists($dir . "/.env")){
            return false;
        }

        $lines = file($dir . '/.env');
        foreach ($lines as $line){
            putenv(trim($line));
        }
    
    }

}

