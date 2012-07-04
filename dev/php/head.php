<?php
$phpRoot = '/home/desalvo/public_html/php/';
$contextRoot = $_SERVER['HTTP_HOST'];
require_once($phpRoot . 'config.php');

$pageTitle ? $pageTitle = 'DeSalvo Custom Cycles | ' . $pageTitle : $pageTitle = 'DeSalvo Custom Cycles';
$pageData ? $pageCSS = '<link rel="stylesheet" type="text/css" href="'.$contextRoot.'css/'.$pageData.'.css" />' : $pageCSS = '';

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta name="keywords" content ="'.$metaKeywords.'" />
	<meta name="description" content="'.$metaDescription.'" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=8" />

	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

	<link rel="stylesheet" type="text/css" href="'.$contextRoot.'css/default.css" />
	<link rel="stylesheet" type="text/css" href="'.$contextRoot.'css/superbox.css" />
    <link rel="stylesheet" type="text/css" href="'.$contextRoot.'css/facebookFeed.css" />
    '.$pageCSS.'

	<title>'.$pageTitle.'</title>

</head>
';

?>