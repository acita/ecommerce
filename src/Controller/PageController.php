<?php

namespace Controller;

use Rain\Tpl;

class PageController {

    private $tpl;
    private $options = [];
    private $defaults = [
        "header"=> true,
        "footer"=> true,
        "data"=>[]
    ];

    public function __construct($opts = array(), $tpl_dir = "src/View/")
    {
        $this->options = array_merge($this->defaults, $opts);

        $config = array(
            "base_url"      => null,
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.$tpl_dir,
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."views-cache/",
            "debug"         => false
           );
    
    Tpl::configure( $config );

    $this->tpl = new Tpl;

    if ($this->options['data']) $this->setData($this->options['data']);

	if ($this->options['header'] === true) $this->tpl->draw("header", false);

    }

    public function __destruct()
    {
        if ($this->options['footer'] === true) $this->tpl->draw("footer", false);
    }

    public function setData($data = array())
    {
        foreach ($data as $key => $value){
            $this->tpl->assign($key, $value);
    }}   


    public function setTpl($tplName, $data = array(), $returnHTML = false)
    {
        $this->setData($data);
        return $this->tpl->draw($tplName, $returnHTML);
    }
}
