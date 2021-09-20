<?php 

use MatthiasMullie\Minify; // thanks to Mr Mullie for the Minification Engine...
// new version using minification
// to be fair, there's no actual autversioning, as the approach for that doesn't work with Artisan.
// Maybe I should set this up so that both AV and Min can be specified as needed, BUT also disabled on a server level (config)
// i.e. better for dev when you don't a) need a versioned file, and b) minification makes debugging <tricky class=""></tricky>
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
		    
			// perform the actual minification of the files:
		    
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
		
        // prepend the current hostname, and ensure the current protocol is used.
		return '//' . $_SERVER['HTTP_HOST'] . '/min' . $tgt; 
		
}


function controller() {
	
	// work out the current controller...
	$ctrl = explode('@', Route::current()->getAction()['controller']);
	return $ctrl[0];

}


function obscure($str) {

    if (strstr($str, '@')) {
        $ary = explode('@', $str);
        $words = explode('.', $ary[0]);
        $out = array();
        foreach($words as $word) {
            if(strlen($word) > 2) {
                $out[] = substr($word, 0, 1) . str_repeat('*', strlen($word)-2) . substr($word, -1, 1);
            } else {
                $out[] = $word;
            }
        }
        return join('.', $out) . '@' . $ary[1];
    }

}


function imageUrl($spec, $models) {

    if(!is_array($models)) {
        $models = [$models];
    }

    foreach($models as $model) {

        if(!is_null($model)) {
            $hi = \AscentCreative\CMS\Models\Image::getSpecForModel($model, $spec);
            if($hi) {
                return $hi->image;
            }
        }

    }
   
    
}


function embedVideo($url) {

    return view('cms::helpers.embedvideo')->with('url', $url);

}


function cookieManager() {
    return view("cms::cookiemanager.setup");
}


// converts a field name to a legal ID (i.e. removes [])
function nameToId($name) {
    return str_replace(array('[', ']'), array('--'. ''), $name);
}


/* Singleton Accessors */

function headTitle() {
	return app(\AscentCreative\CMS\Helpers\HeadTitle::class);
}

function metadata($model=null) {
    return view()->first(["metadata.tags", "cms::metadata.tags"])->with(['model'=>$model]);
}


function adminMenu() {
	return app(\AscentCreative\CMS\Helpers\AdminMenu::class);
}

function menu($slug, $maxDepth=0) {

    $menu = AscentCreative\CMS\Models\Menu::where('slug', $slug)->first();

    if (!$menu) {
        return '';
    } else {
        return($menu->render($maxDepth));
    }

}

function sitebanner($max=1) {

    $banner = AscentCreative\CMS\Models\SiteBanner::live()->orderBy('start_date', 'DESC')->first();

    if (!$banner) {
        return '';
    } else {
        return view('cms::sitebanner.show', ['banner'=>$banner]);
    }

}

function contentstack($stackName) { 
 
    $stack = AscentCreative\CMS\Models\Stack::where('name', $stackName)->first();

    if ($stack) {
        return view('cms::contentstack', ['stack'=>$stack]);
    } else {
        throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
    }

}