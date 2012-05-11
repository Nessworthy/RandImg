<?php
require 'inc/include.php';
$key = new key();
if ($_GET['id']) {
    $id = alphaID($_GET['id'], false);
}
if (isset($_COOKIE['source'])) {
    $source = $_COOKIE['source'];
} else {
    $source = 'imgur';
}
if ($_GET['s']) {
    setcookie('source', $_GET['s']);
    $source = $_GET['s'];
}

function generate_hash($length = 5) {
    return key::new_key($length);
}

function validate_page($url) {
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($handle);
    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    return ($code == 200) ? true : false;
}

function validate_hash($hash, $s) {
	if ($s == 'screensnapr') {
		$url = 'http://screensnapr.com/e/' . $hash . '.png';
	} else {
		$url = 'http://i.imgur.com/' . $hash . '.jpg';
	}
    if (validate_page($url)) {
    	if ($s == 'screensnapr') {
    		return true;
    	}
        list($width, $height) = getimagesize($url);
        if ($width == '161' && $height == '81') {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function get_imgur($hash) {
    if ($hash == null) {
        $hash = generate_hash();
    }
    if (validate_hash($hash, 'imgur') == true) {
        return array('url' => 'http://i.imgur.com/' . $hash . '.jpg', 'hash' => $hash);
    } else {
        return get_imgur(null);
    }
}

function get_screensnapr($hash) {
    if ($hash == null) {
        $hash = generate_hash();
    }
    if (validate_hash($hash, 'screensnapr') == true) {
        return array('url' => 'http://screensnapr.com/e/' . $hash . '.png', 'hash' => $hash);
    } else {
        return get_screensnapr(null);
    }
}

if ($source == 'screensnapr') {
	$image = ($id) ? get_screensnapr($id) : get_screensnapr(null);
} else {
	$image = ($id) ? get_imgur($id) : get_imgur(null);
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>RandImg</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="css/bootstrap.css" rel="stylesheet">
		<style>
			body {
				padding-top: 60px;
			}
			footer {
				color: #888;
				padding-top: 6px;
			}
		</style>
		<link href="css/bootstrap-responsive.css" rel="stylesheet">
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- Le fav and touch icons -->
		<link rel="shortcut icon" href="favicon.ico">
	</head>
	<body>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
					<a class="brand" href="#">RandImg</a>
					<div class="nav-collapse">
						<ul class="nav">
							<li class="active">
								<a href="index.php">Random</a>
							</li>
							<?php
                            echo '<li><a href="index.php?id=' . alphaID($image['hash'], true) . '">Permalink</a></li>';
							?>
						</ul>
						<ul class="nav pull-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Source<b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li<?php if ($source != 'screensnapr') { echo ' class="active"'; } ?>>
										<a href="index.php?s=imgur">Imgur</a>
									</li>
									<li<?php if ($source == 'screensnapr') { echo ' class="active"'; } ?>>
										<a href="index.php?s=screensnapr">Screensnapr <span class="badge badge-error">Rarely Works</span></a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="thumbnail">
						<?php
                        echo '<img src="' . $image['url'] . '" /><br>';
						?>
					</div>
				</div>
			</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script defer src="js/bootstrap.min.js"></script>
	</body>
</html>