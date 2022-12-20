## DESCRIÇÃO

Projeto de e-commerce básico em PHP utilizando a arquitetura MVC  

## REQUISITOS

PHP 7.0 or later  
PHP Mailer: "5.2.22  
Slim Framework: 2.0 

Obs:
Como estamos usando o Slim na versão 2.0, na função stripSlashesIfMagicQuotes em Slim/Http/Util ao criarmos a variável $strip é preciso substituir a chamada da função get_magic_quotes_gpc por false, uma vez que a função chamada por default é desencorajada a partir do PHP7

    public static function stripSlashesIfMagicQuotes($rawData, $overrideStripSlashes = null)
    {
        $strip = is_null($overrideStripSlashes) ? false : $overrideStripSlashes;
        if ($strip) {
            return self::_stripSlashes($rawData);
        } else {
            return $rawData;
        }
    }

RainTpl: 3.0.0  
