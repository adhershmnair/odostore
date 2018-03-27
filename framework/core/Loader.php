<?php
class Loader{
	public function library($lib){
		include LIB_PATH . "$lib.library.php";
	}
	public function helper($helper){
		include HELPER_PATH . "{$helper}.helper.php";
	}
}