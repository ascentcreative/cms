<?php 

function autoVersion($file) {

	/* Broken at present... doesn't work with Artisan - need to find a way around it... */
	return $file;

    if(strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
			return $file;

		$mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
		return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);

}



function controller() {
	
// work out the current controller...
$ctrl = explode('@', Route::current()->getAction()['controller']);
return $ctrl[0];

}
