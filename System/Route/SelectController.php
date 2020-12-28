<?php

namespace System\Route;

/*
|--------------------------------------------------------------------------
| SelectController
|--------------------------------------------------------------------------
| This class is used to call the controller and method according
| the route passed on browser.
|
*/

use System\Controller\Controller;
use System\Request\Request;


class SelectController
{
    private $controller;
    private $method;
    private $getRoute;
    private $allRouters = [];
    private $routerAliases;
    private $routeRegex = [
        '{id}' => '([0-9]{1,})', // rotas passando id: user/1
        '{slug}' => '([a-zA-z0-9_-]+)', // rotas passando slug: usuario/meu-nome-de-usuario
        '{id}-{slug}' => '([0-9]{1,})\-([a-zA-z0-9_-]+)', // rotas passando id e slug: produto/00001-meu-produto
        '{any}' => '([a-zA-Z0-9-_\.\=\&\%\@\!\'\"\(\)\+\*\;\,]+)', // aceita qualquer parâmetro
    ];

    private $atual;

    /**
     * The construc method receive the getRoute instance.
     * @param getRoute Object
     */
    public function __construct(GetRoute $getRoute)
    {
        $this->getRoute = $getRoute;
        $this->controller = $getRoute->getControllerName();
        $this->method = $getRoute->getMethodName();
        $this->routerAliases = $this->getRoute->getControllerNameAliases();
        if ($this->getRoute->getMethodNameAliases()) {
            $this->routerAliases = "{$this->routerAliases}/{$this->getRoute->getMethodNameAliases()}";
        }
    }

    public function run()
    {
        $similarRoutes = $this->takesSimilarRoutes();
        $similarRoutes = $this->takesRegexRoutes($similarRoutes);
        $similarRoutes = $this->takesActualRouteByRegex($similarRoutes);
        $similarRoutes = $this->takesRouteData($similarRoutes);
        $similarRoutes = $this->takesRoutesSimilarToMethod($similarRoutes);

        // pega a primeira rota
        $actualRoute = current($similarRoutes);
        $controller = $actualRoute['controller'];
        $method = $actualRoute['method'];
        $data = isset($actualRoute['data']) ? $actualRoute['data'] : [];

        $this->instantiateController($controller, $method, $data);
    }

    /**
     * Pega todas as rotas parecidas, ou seja,
     * que possuem a mesma quantidade de barras.
     *
     * @return array
     */
    protected function takesSimilarRoutes(): array
    {
        // se rota for vazia, verifica se existe rot para vazio e adiciona uma barra
        if ($this->routerAliases == '') {
            $blankRoute = array_filter($this->allRouters, function ($route) {
                return $route['alias'] == '';
            });
            $uniqueBarRoute = array_filter($this->allRouters, function ($route) {
                return $route['alias'] == '/';
            });
            if (!count($blankRoute) && count($uniqueBarRoute)) {
                $this->routerAliases = '/';
            }
        }
        $barsInActualRoute = substr_count($this->routerAliases, '/');
        // pega todas as rotas parecidas
        return array_filter($this->allRouters, function ($route) use ($barsInActualRoute) {
            // pra home
            if ($route['alias'] == '/') {
                return $this->routerAliases == '/';
            }
            // rotas opcionais
            if (preg_match('/\{(.*)\?\}/', $route['alias'])) {
                return true;
            }
            return substr_count($route['alias'], '/') == $barsInActualRoute;
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Pega por rotas com regex
     *
     * @param array $similarRoutes
     * @return array
     */
    protected function takesRegexRoutes(array $similarRoutes): array
    {
        return array_map(function ($route) {
            if (preg_match_all("/\{([a-zA-Z0-9\?]+)\}/", $route['alias'], $matches)) {
                $route['realRoute'] = $route['alias'];
                $route['alias'] = $this->manipulateRouteRegex($route['alias'], $matches);
            }
            $route['route'] = $route['alias'];
            return $route;
        }, $similarRoutes);
    }

    /**
     * Manipula o regex das rotas
     */
    protected function manipulateRouteRegex(string $route, array $matches): string
    {
        foreach ($matches[0] as $regex) {
            $optional = false;
            if (preg_match('/\{(.*)\?\}/', $regex)) {
                $optional = true;
                $regex = str_replace('?}', '}', $regex);
            }
            $regexValue = isset($this->routeRegex[$regex]) ? $this->routeRegex[$regex] : '(.*)';
            $regexValue = $optional ? "{$regexValue}?" : $regexValue;
            $regex = $optional ? str_replace('}', '?}', $regex) : $regex;
            $route = str_replace($regex, "?{$regexValue}", $route);
        }
        return $route;
    }

    /**
     * Pega a rota atual por regex
     *
     * @param array $similarRoutes
     * @return array
     */
    protected function takesActualRouteByRegex(array $similarRoutes): array
    {
        $similarRoutes = array_filter($similarRoutes, function ($data) {
            $route = str_replace('/', '\/', $data['route']);
            return preg_match("/^{$route}/", $this->routerAliases, $matches);
        });
        // rota não encontrada
        if (!count($similarRoutes)) {
            require_once(__DIR__ . '/../../App/Views/Layouts/404.php');
            exit;
        }
        return $similarRoutes;
    }

    /**
     * Pega os parametros da url se houverem
     *
     * @param array $similarRoutes
     * @return array
     */
    protected function takesRouteData(array $similarRoutes): array
    {
        return array_map(function ($data) {
            $route = str_replace('/', '\/', $data['route']);
            preg_match("/^{$route}/", $this->routerAliases, $match);
            array_shift($match);
            $data['data'] = $match;

            // verifica se existe somente uma rota e ela possui barras
            if (count($data['data']) === 1 && preg_match('/\//', $data['data'][0])) {
                $data['data'] = explode('/', $data['data'][0]);
            }
            return $data;
        }, $similarRoutes);
    }

    /**
     * Pega as rotas iguais ao HTTP_METHOD
     *
     * @param array $similarRoutes
     * @return array
     */
    protected function takesRoutesSimilarToMethod(array $similarRoutes): array
    {
        $similarRoutes = array_filter($similarRoutes, function ($route) {
            return $route['type'] == $_SERVER['REQUEST_METHOD'];
        });
        // verifica tipo de rota
        if (!count($similarRoutes)) {
            require_once(__DIR__ . '/../../App/Views/Layouts/405.php');
            exit;
        }
        return $similarRoutes;
    }

    /**
     * The method is used to instantiate the controller
     * @param controller
     * @param method String the method name
     * @return method
     */
    protected function instantiateController(string $controller, string $method, array $data = [])
    {
        # Verifying if exist the character \\ in Controller name
        if (strstr($controller, '\\')) {
            $stringToArray = explode('\\', $controller);
            $controllerNameWithfullNamespace = implode("\\", array_values($stringToArray));
            $controller = "App\Controllers\\" . $controllerNameWithfullNamespace;

        } else {
            $controller = "App\Controllers\\" . $controller;
        }

        $this->verifyIfControllerExists($controller);

        /** @var Controller */
        # Instanciate the Controller
        $controller = new $controller;

        $this->verifyIfMethodExists($controller, $method);

        # Call the Controller Method
        # data is empty
        if (!count($data)) {
            return call_user_func([$controller, $method]);
        }

        $data = explode('/', $data[0]);

        # data is not empty
        return call_user_func_array([$controller, $method], $data);
    }

    /**
     * Verifica se o controller passado existe
     *
     * @param string $controller
     * @return void
     */
    protected function verifyIfControllerExists(string $controller): void
    {
        if (!class_exists($controller)) {
            require_once(__DIR__ . '/../../App/Views/Layouts/405.php');
            exit;
        }
    }

    /**
     * Verifica se o método atual existe naquele controller
     *
     * @param Controller $controller
     * @param string $method
     * @return void
     */
    protected function verifyIfMethodExists(Controller $controller, $method): void
    {
        if (!method_exists($controller, $method)) {
            require_once(__DIR__ . '/../../App/Views/Layouts/405.php');
            exit;
        }
    }

    public function get(string $aliases, string $controllerAndMethod)
    {
        $this->create($aliases, $controllerAndMethod, "GET");
    }

    public function create(string $aliases, string $controllerAndMethod, string $type = "GET")
    {
        $arrayExplode = explode('@', $controllerAndMethod);

        $this->allRouters[] = [
            'controller' => $arrayExplode[0],
            'method' => $arrayExplode[1],
            'alias' => $aliases,
            'type' => $type,
        ];
    }

    public function post(string $aliases, string $controllerAndMethod)
    {
        $this->create($aliases, $controllerAndMethod, "POST");
    }

    public function put(string $aliases, string $controllerAndMethod)
    {
        $this->create($aliases, $controllerAndMethod, "PUT");
    }

    public function delete(string $aliases, string $controllerAndMethod)
    {
        $this->create($aliases, $controllerAndMethod, "DELETE");
    }
}
