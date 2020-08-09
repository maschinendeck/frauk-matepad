<?php
	require("./mustache/src/Mustache/Autoloader.php");
	include_once "api/storage.php";

	define("PATH_INCLUDE_PAGES",    "./pages/");
	define("PATH_INCLUDE_TEMPLATE", "./templates/");
	define("PATH_INCLUDE_THEME",    "./theme/");
	define("PATH_INCLUDE_INDEX",    "index");
	define("PATH_INCLUDE_404",      "file_not_found");
	define("REQUEST_GET_PAGE_NAME", "page");
	define("THEME_FILE_HEAD",       "head");
	define("THEME_FILE_TAIL",       "tail");
	define("COOKIE_USER",           "userCookie");

	// Mustache Template Engine
	Mustache_Autoloader::register();
	$mustache = new Mustache_Engine();

	// Fetch database and read session cookie for later use by page
	$store = new Storage;
	$store->readFromDisk();
	$currentUserID = isset($_COOKIE[COOKIE_USER]) ? $_COOKIE[COOKIE_USER] : "";
	$currentUser = $store->fetchUserByID($currentUserID);

	function bindAndRenderTemplate($template, $binding) {
		echo bindAndRenderTemplateToString($template, $binding);
	}

	function bindAndRenderTemplateToString($template, $binding) {
		global $mustache;
		$templateFile = PATH_INCLUDE_TEMPLATE . $template;
		if (file_exists($templateFile)) {
			$templateContent = file_get_contents($templateFile);
			return $mustache->render($templateContent, $binding);
		}
	}

	function loadPage($page, $plainError = false, $path = PATH_INCLUDE_PAGES) {
		global $mustache, $store, $currentUser;
		$requestPath = $path . $page;
		$requestPagePHP  = $requestPath . "/page.php";
		$requestPageHTML = $requestPath . "/page.html";
		if (file_exists($requestPath)) {				// If the template page exists
			if (file_exists($requestPagePHP)) {			// Calling a 'smart' page (with php)
				include_once($requestPagePHP);
			} else if (file_exists($requestPageHTML)) {	// Calling a 'normal' page (no php code)
				echo file_get_contents($requestPageHTML);
			}
		} else {
			if ($plainError) {
				echo "<center>Error Loading Page - 404 File Not Found</center>";
			} else {
				load404();
			}
		}
	}

	function load404() {
		loadPage(PATH_INCLUDE_404, $plainError = true);
	}

	function loadIndex() {
		loadPage(PATH_INCLUDE_INDEX);
	}

	function sanitizePageParameter($page) {
		$info = pathinfo($page);
		if (isset($info['extension'])) {
			return basename($page, "." .$info['extension']);
		} else {
			return basename($page);
		}
	}

	# Import head
	loadPage(THEME_FILE_HEAD, '', $path = PATH_INCLUDE_THEME);

	# Load requested file
	if (isset($_GET[REQUEST_GET_PAGE_NAME])) {
		$pageToLoad = sanitizePageParameter($_GET[REQUEST_GET_PAGE_NAME]);
		loadPage($pageToLoad);
	} else {
		loadIndex();
	}

	# Import tail
	loadPage(THEME_FILE_TAIL, '', $path = PATH_INCLUDE_THEME);
?>
