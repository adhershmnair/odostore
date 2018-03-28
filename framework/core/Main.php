<?php
class Main {
	public static function run() {
		self::init();
		self::autoload();
		self::dispatch();
	}

	private static function init() {
		define("DS", DIRECTORY_SEPARATOR);
		define("ROOT", getcwd() . DS);
		define("APP_PATH", ROOT . 'src' . DS);
		define("FRAMEWORK_PATH", ROOT . "framework" . DS);
		define("PUBLIC_PATH", ROOT . "public" . DS);
		define("CONFIG_PATH", ROOT . "config" . DS);
		define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);
		define("MODEL_PATH", APP_PATH . "models" . DS);
		define("VIEW_PATH", ROOT . "templates" . DS);
		define("ROUTE_PATH", ROOT . "routes" . DS);
		define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
		define('DB_PATH', FRAMEWORK_PATH . "database" . DS);
		define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);
		define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);
		define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);
		$GLOBALS['config'] = include CONFIG_PATH . "config.php";
		require CORE_PATH . "Controller.php";
		require CORE_PATH . "Loader.php";
		require DB_PATH . "Mysql.php";
		require CORE_PATH . "Model.php";
		self::routing();
		session_start();		
	}


	private static function autoload() {
		spl_autoload_register(array(__CLASS__,'load'));
	}

	private static function load($classname){
		if (substr($classname, -10) == "Controller"){
			require_once CURRENT_CONTROLLER . ucfirst($classname).".php";
		} elseif (substr($classname, -5) == "Model"){
			require_once  MODEL_PATH . ucfirst($classname).".php";
		}
	}

	private static function dispatch(){
		$controller_name = CONTROLLER . "Controller";
		$action_name = ACTION . "Action";
		$controller = new $controller_name;
		$controller->$action_name();
	}

	private static function routing(){
		require CORE_PATH.'Router.php';
		$request = $_SERVER['PHP_SELF'];
		$requesturi = explode('index.php', $request);
		unset($requesturi[0]);
		$request = implode($requesturi);
		$router = new Router($request);
		include ROUTE_PATH . "routes.php";
		if (!defined('PLATFORM')) {
			define("PLATFORM", 'error');
		}
		if (!defined('CONTROLLER')) {
			define("CONTROLLER", 'Error404');
		}
		if (!defined('ACTION')) {
			define("ACTION", 'index');
		}
		$plarform = !empty(PLATFORM)? PLATFORM . DS: '';
		if (!defined('CURRENT_CONTROLLER')) {
			define("CURRENT_CONTROLLER", CONTROLLER_PATH . $plarform);
		}
		if (!defined('CURRENT_VIEW')) {
			define("CURRENT_VIEW", VIEW_PATH . PLATFORM . DS);
		}


	}

}