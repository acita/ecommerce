<?php

namespace Controller;

class AdminController extends PageController {

    public function __construct($opts = array(), $tpl_dir = "src/View/admin/")
    {
        parent::__construct($opts, $tpl_dir);
    }
}
