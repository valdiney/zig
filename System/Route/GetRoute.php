<?php

namespace System\Route;

/*
|--------------------------------------------------------------------------
| GetRoute
|--------------------------------------------------------------------------
| This class is used to catch the route from url on browser.
|
*/

class GetRoute
{
    public $existControllerOnRoute = false;
    private $baseUrl;
    private $urlParameters;
    private $controller;
    private $method;
    private $controllerNameAliases;
    private $methodNameAliases;

    public function __construct()
    {
        $this->baseUrl = $this->getBaseUrl();

        $this->getControllerAndMethod();
        $this->veriFyControllerOnUrl();
        $this->veriFyMethodOnUrl();

        if (!defined('CONTROLLER_NAME') && !defined('BASEURL')) {
            define('CONTROLLER_NAME', $this->controller);
            define('METHOD_NAME', $this->method);
            define('BASEURL', $this->getBaseUrl());
        }

        $this->getUrlVariables();
    }

    /**
     * This method return the url passed on browser.
     * Example http://localhost:8000
     * @return String
     */
    public function getBaseUrl(): string
    {
        $protocol = getenv('HTTPS') ? "https" : "http";

        $branch = dirname($_SERVER['SCRIPT_NAME'], 2);
        $branch = trim($branch, '/');
        $branch = $branch ? "/{$branch}" : "";

        return "{$protocol}://{$_SERVER['HTTP_HOST']}{$branch}";
    }

    /**
     * This method is used to obtain and separate the
     * name of controller and the called method on url.
     */
    private function getControllerAndMethod()
    {
        $scriptName = dirname($_SERVER['SCRIPT_NAME'], 2);
        $redirectUrl = str_replace("{$scriptName}/", '', $_SERVER['REQUEST_URI']);
        $redirectUrl = trim($redirectUrl, '/');

        if ($redirectUrl) {
            $this->urlParameters = explode('/', $redirectUrl);
        }
    }

    /**
     * This method is used to verify if exist controller name passed on url of the browser.
     */
    private function veriFyControllerOnUrl()
    {
        if (!empty($this->urlParameters[3])) {
            $this->existControllerOnRoute = true;
        }
        if ($this->urlParameters && array_key_exists(0, $this->urlParameters)) {
            $this->controller = ucfirst($this->urlParameters[0]) . 'Controller';
            $this->controllerNameAliases = $this->urlParameters[0];
        }
    }

    /**
     * This method is used to verify if exist method name passed on url of the browser.
     */
    private function veriFyMethodOnUrl()
    {
        if ($this->urlParameters && array_key_exists(1, $this->urlParameters)) {
            $this->method = $this->urlParameters[1];
            $nameAndAliases = $this->urlParameters;
            array_shift($nameAndAliases);
            $nameAndAliases = implode('/', $nameAndAliases);
            $this->methodNameAliases = $nameAndAliases;
        }
    }

    public function getUrlVariables()
    {
        if ($this->urlParameters == null) {
            return [];
        }

        $data = [];
        foreach ($this->urlParameters as $key => $value) {
            if ($key >= 2) {
                array_push($data, $value);
            }
        }

        return $data;
    }

    public function getControllerNameAliases()
    {
        return $this->controllerNameAliases;
    }

    public function getMethodNameAliases()
    {
        return $this->methodNameAliases;
    }

    /**
     * This method is return the controller name.
     * @return String
     */
    public function getControllerName()
    {
        return $this->controller;
    }

    /**
     * This method return the method name.
     * @return String
     */
    public function getMethodName()
    {
        return $this->method;
    }
}
