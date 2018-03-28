<?php
class Router{
	private $request;
	public function __construct($request){
		$this->request = $request;
	}
	public function get($route, $file){
		$uri = trim( $this->request, "/" );
		$uri = explode("/", $uri);
		if (empty($uri[0])) {
			$file['platform'] = '';
			$file['controller'] = 'Index';
			$file['action'] = 'index';
		}
		if($uri[0] == trim($route, "/")){
			define("PLATFORM", isset($file['platform']) ? $file['platform'] : '');
			define("CONTROLLER", isset($file['controller']) ? $file['controller'] : 'Index');
			define("ACTION", isset($file['action']) ? $file['action'] : 'index');
			$plarform = !empty(PLATFORM)? PLATFORM . DS: '';
			define("CURRENT_CONTROLLER", CONTROLLER_PATH . $plarform);
			define("CURRENT_VIEW", VIEW_PATH . PLATFORM . DS);
		}
	}
}