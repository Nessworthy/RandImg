<?php
// Autoloader!

// Feel free to turn this into non-anonymous if you're using php < 5.3
spl_autoload_register(function($class) {
	require_once(strtolower($class).'.class.php');
});

// alpha fn.
require_once('id.php');
