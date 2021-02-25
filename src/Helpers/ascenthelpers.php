<?php 

use MatthiasMullie\Minify;
// new version using minification
function autoVersion($file, $min=true) {

		// if not set to minify, just return the filename
		if (!$min) {
			return $file;
		}
		
		// if not a local file, or it just doesn't exist, bail
		if(strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file)) {
			return $file;
		}
			
		
		$mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
		
		$tgt = preg_replace('{\\.([^./]+)$}', ".$mtime.min.\$1", $file);
		
		$glob = preg_replace('{\\.([^./]+)$}', ".*.min.\$1", $file);
		
		
		$inf = pathinfo($file);
		
		$ext = $inf['extension'];
		
		if(!file_exists($_SERVER['DOCUMENT_ROOT'] . '/min' . $tgt)) {
		    
		   // echo 'not found: minifying';
		    
		    $minbase = $_SERVER['DOCUMENT_ROOT'] . '/min';
		    
		    if(!file_exists($minbase)) {
		        mkdir($minbase);
		    }
		    
		    // ensure all directories exist:
		    $dirs = explode('/', $inf['dirname']);
		    foreach($dirs as $dir) {
		        
		          $minbase = $minbase . '/' . $dir;
		          if(!file_exists($minbase)) {
		              mkdir($minbase);
		          }
		          
		    }
		    
		    
		 //   $cfg = Zend_Registry::get('config');
		 //   require_once($cfg->corebasepath . '/Mullie/init.php');
		    
		////    echo $file;
		  //  echo $tgt;
		    
		 //   exit();
		    
		    if ($ext == 'js') {
		        $minify = new Minify\JS($_SERVER['DOCUMENT_ROOT'] . $file);
		        $minify->minify($_SERVER['DOCUMENT_ROOT'] . '/min' . $tgt);
		    }
		    
		    if ($ext == 'css') {
		        $minify = new Minify\CSS($_SERVER['DOCUMENT_ROOT'] . $file);
		        $minify->minify($_SERVER['DOCUMENT_ROOT'] . '/min' . $tgt);
		    }
		    
		    // clean up older versions:
		    $aryGlob = glob($_SERVER['DOCUMENT_ROOT'] . '/min' . $glob);
		    $current = array_pop($aryGlob); // last element will be the new file. Pop it off the array to keep itt.
		    foreach($aryGlob as $del) {
		        //echo 'deleting: ' . $del;
		        // Delete all the old versions.
		        unlink ($del);
		    }
		    
		}
		
		return '/min' . $tgt; 
		
}




function controller() {
	
// work out the current controller...
$ctrl = explode('@', Route::current()->getAction()['controller']);
return $ctrl[0];

}
