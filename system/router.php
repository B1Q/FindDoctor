<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 8:08 AM
 */


class Router
{
	public static function Init($routes, $config = [])
	{
		$uri = explode("/", $_SERVER['REQUEST_URI']);
		$uri[1] = count($uri) > 2 ? $uri[1] . "/" .$uri[2] : $uri[1];
		$controller = $routes['default'] ?? "IndexController";
		if (!empty($uri) && array_key_exists($uri[1], $routes))
			$controller = $routes[$uri[1]];

		$controllerArray = explode("/", $controller);
		$function = !empty($controllerArray) && count($controllerArray) > 1 ? $controllerArray[1] : "Index";
		$controller = !empty($controllerArray) ? $controllerArray[0] : $routes['default'] ?? "IndexController";

		$controllerPath = DIVINEPATH . "app/Controllers/$controller.php";
		$sessionController = DIVINEPATH . "app/Controllers/$routes[acontrollerweallneed].php";

		if (!defined("SessionController"))
			require_once $sessionController;

		if (file_exists($controllerPath)) {
			require_once $controllerPath;

			$controllerInstance = new $controller();
			$controllerInstance->defaultConfig = $config;
			$controllerInstance->database = GoodDB::getInstance();
			if (method_exists($controllerInstance, $function) && is_callable([ $controllerInstance, $function ]))
				$controllerInstance->$function();
			else
				echo "Method $function is Not Callable!" . (int)is_callable([ $controllerInstance, $function ]);
		} else
			echo "Couldn't Find Controller on $controllerPath";
	}

	public static function getSegment($index)
	{
		$uri = explode("/", $_SERVER['REQUEST_URI']);
		if (count($uri) < $index) return "";
		return $uri[$index];
	}

	public static function Redirect($url)
	{
		if (!headers_sent()) {
			header("location: $url");
			exit;
		}
	}
}