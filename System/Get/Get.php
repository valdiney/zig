<?php

namespace System\Get;

use System\Route\GetRoute;

class Get extends GetRoute
{
    public function __construct()
    {
        parent::__construct();
    }

    public function position($position)
    {
        if (isset($this->getUrlVariables()[$position])) {
            return $this->getUrlVariables()[$position];
        } else {
            return false;
        }
    }

    function redirectTo(string $route, $params = false)
    {
        $route = BASEURL . "/{$route}";
        $variables = "";

        if ($params) {
            foreach ($params as $key => $itens) {
                $variables .= '/' . $itens;
            }

            $route .= $variables;
        }

        header("Location:{$route}");
    }

    public function all()
    {
        return $this->getUrlVariables();
    }
}
