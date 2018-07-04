<?php
//------------------------------------------------------------------------------------------------
// INCLUDE
//------------------------------------------------------------------------------------------------
if (!isset($root)) $root = str_replace('\\','/',dirname(dirname(dirname(__DIR__))));
require_once($root.'/public_html/start/common/main.php');
//------------------------------------------------------------------------------------------------
if (!isset($_GET['nowa'])) { store_visitor('lychee'); header("Location: http://sstsoft.pl/galeria/lychee/index.php"); exit(0); }
else  { store_visitor('galeria'); require_once($root.'/common/include/createThumbnail/createThumbnail.php'); }
//------------------------------------------------------------------------------------------------
if (isset($_GET['path'])) 
	{
	$page_hash = md5($_GET['path']);
	$galeria_path = rtrim(linkToPath($root,'public_html/start/galeria',$_GET['path']));
	}
else 
	{
	$page_hash = md5('galeria');
	$galeria_path = $root.'/public_html/start/galeria';
	}
//------------------------------------------------------------------------------------------------
// CACHE
//------------------------------------------------------------------------------------------------
$cache_is_on = trace_cache($root.'/public_html/start/cache',$page_hash);
if ($cache_is_on) exit();
//------------------------------------------------------------------------------------------------
// BUILD HTML
//------------------------------------------------------------------------------------------------
$html_fixed_bar = file_get_contents($tmpl_root.'/fixed-bar/fixed-bar-simple.tmpl');
$html_fixed_reklama = file_get_contents($tmpl_root.'/fixed-bar/fixed-bar-reklama.tmpl');
$html_cookies = file_get_contents($tmpl_root.'/cookies-index.tmpl');
$html_bottom = file_get_contents($tmpl_root.'/bottom-normal.tmpl');
$html_galeria = new Template($tmpl_root.'/right/right-galeria.tmpl');
//------------------------------------------------------------------------------------------------
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
"http://www.w3.org/TR/html4/frameset.dtd"><html>'.PHP_EOL;
echo_head('normal','sstsoft.pl - Galeria');
echo ' <body>'.PHP_EOL;
echo $html_fixed_bar.PHP_EOL;
echo $html_fixed_reklama.PHP_EOL;
$html_cookies->output().PHP_EOL;
echo ' <div id="main">'.PHP_EOL;
	echo_top('galeria');
	echo ' <div id="middle">'.PHP_EOL;
		echo ' <div id="middle_top"></div>'.PHP_EOL;
		echo ' <div id="middle_content">'.PHP_EOL;
			echo_menu('galeria',$GLOBALS['html_root']);
			echo ' <div id="right" class="normal">'.PHP_EOL;
				echo ' <div id="right_content">'.PHP_EOL;
				$html_galria->output();
			echo '</div>'.PHP_EOL; // right content
			echo '</div>'.PHP_EOL; // right
		echo '</div>'.PHP_EOL; // middle content
		echo ' <div id="middle_bot"></div>'.PHP_EOL;
	echo '</div>'.PHP_EOL; // middle
	echo $html_bottom.PHP_EOL;
echo '</div><br>'.PHP_EOL; // main
//------------------------------------------------------------------------------------------------
// SERVER CONSOLE
//------------------------------------------------------------------------------------------------
include_once($root.'/public_html/start/common/server-console.php');
echo '</body></html>'.PHP_EOL;  // body, html
//------------------------------------------------------------------------------------------------
// FLUSH HTML TO CACHE
//------------------------------------------------------------------------------------------------
store_cache($root.'/public_html/start/cache',$page_hash);
//------------------------------------------------------------------------------------------------
?>