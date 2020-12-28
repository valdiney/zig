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

        $this->generateControllerAndMethod();
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
     * @param bool|null $https
     * @param string|null $scriptName
     * @param string|null $host
     * @return String
     */
    public function getBaseUrl(bool $https = null, string $scriptName = null, string $host = null): string
    {
        $https = $https ?? getenv('HTTPS');
        $scriptName = $scriptName ?? $_SERVER['SCRIPT_NAME'];
        $host = $host ?? $_SERVER['HTTP_HOST'];

        $protocol = filter_var($https, FILTER_VALIDATE_BOOLEAN) ? "https" : "http";

        $branch = dirname($scriptName, 2);
        $branch = trim($branch, '/');
        $branch = $branch ? "/{$branch}" : "";

        return "{$protocol}://{$host}{$branch}";
    }

    /**
     * This method is used to obtain and separate the
     * name of controller and the called method on url.
     * @param string|null $scriptName
     * @param string|null $requestUri
     */
    public function generateControllerAndMethod(string $scriptName = null, string $requestUri = null)
    {
        $scriptName = $scriptName ?? $_SERVER['SCRIPT_NAME'];
        $requestUri = $requestUri ?? $_SERVER['REQUEST_URI'];

        $scriptName = dirname($scriptName, 2);
        $redirectUrl = str_replace("{$scriptName}/", '', $requestUri);
        $redirectUrl = trim($redirectUrl, '/');

        $this->urlParameters = $redirectUrl ? explode('/', $redirectUrl) : null;
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

    /**
     * @return array|null
     */
    public function getUrlParameters(): ?array
    {
        return $this->urlParameters;
    }
}
