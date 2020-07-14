<?php
	include_once "api/storage.php";

	define("PATH_INCLUDE_PAGES",    "./pages/");
	define("PATH_INCLUDE_THEME",    "./theme/");
	define("PATH_INCLUDE_INDEX",    "index");
	define("PATH_INCLUDE_404",      "file_not_found");
	define("REQUEST_GET_PAGE_NAME", "page");
	define("THEME_FILE_HEAD",       "head");
	define("THEME_FILE_TAIL",       "tail");

	function loadPage($page, $plainError = false, $path = PATH_INCLUDE_PAGES) {
		$requestPage = $path . $page . ".html";
		if (file_exists($requestPage)) {
			include_once($requestPage);
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
