<?php
// récupération nom user et mot de passe banque de donnee 
$cont = file_get_contents("C:/inetpub/PassBddRepo");
$cont_ar = explode(" ", $cont);
$user = $cont_ar[0];
$password = $cont_ar[1];

// on récupère les versions des applis
$server_software = $_SERVER['SERVER_SOFTWARE'];
$phpVersion = phpversion();
$opensslVersion = OPENSSL_VERSION_TEXT;

$link = mysqli_connect('localhost', $user, $password);
$mysqlVersion = mysqli_get_server_info($link);

// on récupère les ports des applis
$port = $_SERVER['SERVER_PORT'];
$Mysqlport = "3306";

// récupération des projets
$dir = "./www/";
$handle=opendir($dir);
$projectContents = '';
$projectsListIgnore = [".", ".."];
while (($file = readdir($handle)) !== false)
{
	if (is_dir($dir.$file) && !in_array($file,$projectsListIgnore))
	{
		$projectContents .= '<li><a href="';
		/*if($suppress_localhost)
			$projectContents .= 'http://'.$file.$UrlPort.'/"';
		else
			$projectContents .= 'http://localhost'.$UrlPort.'/'.$file.'/"';*/
		$projectContents .= (isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'https').'://'.(isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : $_SERVER['SERVER_ADDR']).'/www'.(isset($_SERVER['SERVER_PORT']) && !in_array($_SERVER['SERVER_PORT'], array(80, 443)) ? ':'.$_SERVER['SERVER_PORT'] : '').'/'.$file.'/"';
		$projectContents .= '>'.$file.'</a></li>';
	}
}
closedir($handle);
if (empty($projectContents))
	$projectContents = "<li>Aucun Projets</li>\n";

// images
$pngFolder = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAABhlBMVEX//v7//v3///7//fr//fj+/v3//fb+/fT+/Pf//PX+/Pb+/PP+/PL+/PH+/PD+++/+++7++u/9+vL9+vH79+r79+n79uj89tj89Nf889D88sj78sz78sr58N3u7u7u7ev777j67bL67Kv46sHt6uP26cns6d356aP56aD56Jv45pT45pP45ZD45I324av344r344T14J734oT34YD13pD24Hv03af13pP233X025303JL23nX23nHz2pX23Gvn2a7122fz2I3122T12mLz14Xv1JPy1YD12Vz02Fvy1H7v04T011Py03j011b01k7v0n/x0nHz1Ejv0Hnuz3Xx0Gvz00buzofz00Pxz2juz3Hy0TrmznzmzoHy0Djqy2vtymnxzS3xzi/kyG3jyG7wyyXkwJjpwHLiw2Liw2HhwmDdvlXevVPduVThsX7btDrbsj/gq3DbsDzbrT7brDvaqzjapjrbpTraojnboTrbmzrbmjrbl0Tbljrakz3ajzzZjTfZijLZiTJdVmhqAAAAgnRSTlP///////////////////////////////////////8A////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////9XzUpQAAAAlwSFlzAAALEgAACxIB0t1+/AAAAB90RVh0U29mdHdhcmUATWFjcm9tZWRpYSBGaXJld29ya3MgOLVo0ngAAACqSURBVBiVY5BDAwxECGRlpgNBtpoKCMjLM8jnsYKASFJycnJ0tD1QRT6HromhHj8YMOcABYqEzc3d4uO9vIKCIkULgQIlYq5haao8YMBUDBQoZWIBAnFtAwsHD4kyoEA5l5SCkqa+qZ27X7hkBVCgUkhRXcvI2sk3MCpRugooUCOooWNs4+wdGpuQIlMDFKiWNbO0dXTx9AwICVGuBQqkFtQ1wEB9LhGeAwDSdzMEmZfC0wAAAABJRU5ErkJggg==
EOFILE;
$pngFolderGo = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJISURBVDjLpZPLS5RhFIef93NmnMIRSynvgRF5KWhRlmWbbotwU9sWLupfCBeBEYhQm2iVq1oF0TKIILIkMgosxBaBkpFDmpo549y+772dFl5bBIG/5eGch9+5KRFhOwrYpmIAk8+OjScr29uV2soTotzXtLOZLiD6q0oBUDjY89nGAJQErU3dD+NKKZDVYpTChr9a5sdvpWUtClCWqBRxZiE/9+o68CQGgJUQr8ujn/dxugyCSpRKkaw/S33n7QQigAfxgKCCitqpp939mwCjAvEapxOIF3xpBlOYJ78wQjxZB2LAa0QsYEm19iUQv29jBihJeltCF0F0AZNbIdXaS7K6ba3hdQey6iBWBS6IbQJMQGzHHqrarm0kCh6vf2AzLxGX5eboc5ZLBe52dZBsvAGRsAUgIi7EFycQl0VcDrEZvFlGXBZshtCGNNa0cXVkjEdXIjBb1kiEiLd4s4jYLOKy9L1+DGLQ3qKtpW7XAdpqj5MLC/Q8uMi98oYtAC2icIj9jdgMYjNYrznf0YsTj/MOjzCbTXO48RR5XaJ35k2yMBCoGIBov2yLSztNPpHCpwKROKHVOPF8X5rCeIv1BuMMK1GOI02nyZsiH769DVcBYXRneuhSJ8I5FCmAsNomrbPsrWzGeocTz1x2ht0VtXxKj/Jl+v1y0dCg/vVMl4daXKg12mtCq9lf0xGcaLnA2Mw7hidfTGhL5+ygROp/v/HQQLB4tPlMzcjk8EftOTk7KHr1hP4T0NKvFp0vqyl5F18YFLse/wPLHlqRZqo3CAAAAABJRU5ErkJggg==
EOFILE;
$gifLogo = <<< EOFILE
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
EOFILE;
$pngPlugin = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsSAAALEgHS3X78AAAABGdBTUEAALGOfPtRkwAAACBjSFJNAAB6JQAAgIMAAPn/AACA6QAAdTAAAOpgAAA6mAAAF2+SX8VGAAABmklEQVR42mL4//8/AyUYIIDAxK5du1BwXEb3/9D4FjBOzZ/wH10ehkF6AQIIw4B1G7b+D09o/h+X3gXG4YmteA0ACCCsLghPbPkfm9b5PzK5439Sdg9eAwACCEyANMBwaFwTGIMMAOEQIBuGA6Mb/qMbABBAEAOQnIyMo1M74Tgiqf2/b3gVhgEAAQQmQuKa/8ekdYMxyLCgmEYMHJXc9t87FNMAgACCGgBxIkgzyDaQU5FxQGQN2AUBUXX/vULKwdgjsOQ/SC9AAKEEYlB03f+oFJABdSjYP6L6P0guIqkVjt0DisEGAAQQigEgG0AhHxBVi4L9wqvBBiEHtqs/xACAAAIbEBBd/x+Eg2ObwH4FORmGfYCaQRikCUS7B5YBNReBMUgvQABBDADaAtIIwsEx9f/Dk9pQsH9kHTh8XANKMAIRIIDAhF9ELTiQQH4FaQAZCAsskPNhyRpkK7oBAAEEMSC8GsVGkEaYIlBghcU3gbGzL6YBAAEEJnzCgP6EYs/gcjCGKQI5G4Z9QiswDAAIIAZKszNAgAEAHgFgGSNMTwgAAAAASUVORK5CYII=
EOFILE;
$pngWrench = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAABO1BMVEXu7u7n5+fk5OTi4uLg4ODd3d3X19fV1dXU1NTS0tLPz8+7z+/MzMy6zu65ze65zu7Kysq3zO62zO3IyMjHx8e1yOiyyO2yyOzFxcXExMSyxue0xuexxefDw8OtxeuwxOXCwsLBwcGuxOWsw+q/v7+qweqqwuqrwuq+vr6nv+qmv+m7u7ukvumkvemivOi5ubm4uLicuOebuOeat+e0tLSYtuabtuaatuaXteaZteaatN6Xs+aVs+WTsuaTsuWRsOSrq6uLreKoqKinp6elpaWLqNijo6OFpt2CpNyAo92BotyAo9+dnZ18oNqbm5t4nt57nth7ntp4nt15ndp3nd6ZmZmYmJhym956mtJzm96WlpaVlZVwmNyTk5Nvl9lultuSkpKNjY2Li4uKioqIiIiHh4eGhoZQgtVKfNFdha6iAAAAaXRSTlMA//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////914ivwAAAACXBIWXMAAAsSAAALEgHS3X78AAAAH3RFWHRTb2Z0d2FyZQBNYWNyb21lZGlhIEZpcmV3b3JrcyA4tWjSeAAAAKFJREFUGJVjYIABASc/PwYkIODDxBCNLODEzGiQgCwQxsTlzJCYmAgXiGKVdHFxYEuB8dkTOIS1tRUVocaIWiWI8IiIKKikaoD50kYWrpwmKSkpsRC+lBk3t2NEMgtMu4wpr5aeuHcAjC9vzadjYyjn7w7lK9kK6tqZK4d4wBQECenZW6pHesEdFC9mbK0W7otwsqenqmpMILIn4tIzgpG4ADUpGMOpkOiuAAAAAElFTkSuQmCC
EOFILE;
$favicon = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAAB8AAAAfCAYAAAAfrhY5AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJ
bWFnZVJlYWR5ccllPAAAA2RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdp
bj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6
eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEz
NDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJo
dHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlw
dGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEu
MC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVz
b3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1N
Ok9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo1ODg0QkM3NUZBMDhFMDExODkyQ0U2NkE5ODVB
M0Q2OSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoxRkI1ODNGRTA5MDMxMUUwQjAwNEEwODc0
OTk5N0ZEOCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoxRkI1ODNGRDA5MDMxMUUwQjAwNEEw
ODc0OTk5N0ZEOCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3Mi
PiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo1ODg0QkM3NUZB
MDhFMDExODkyQ0U2NkE5ODVBM0Q2OSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo1ODg0QkM3
NUZBMDhFMDExODkyQ0U2NkE5ODVBM0Q2OSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRG
PiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PiUukzAAAAHHSURBVHja5FfRccIwDLVz
/W+7QdggbJBM0HQCwg+/LRNwTJDymx9ggmYDsgEZwRuUDVI5ET1XyE5CuIa76k7ABVtPluQnRVZV
JcYST4woD85/ZRbC5wxUf/sdbZagBehGVAvlNM+GXWYaaIugQ+QDdA1OnLqByyyAzwPo042iqyMx
BwdKN7jMNODREWKFyonv2KdPPqERoDlPGQMKQ7drPWPjfAy6Inb080/QiK/2Js8JMacBpzWwzGIs
QFdxhujkFMNtSkj3m1ftjTnxEg0f0XNXAYb1mmatwFPSFM1s4NTwuUp18QU9CiyonWj2rhkHWXAK
kNeh7gdMQ5wzRdnKcAo9DwZcsRBtqL70qm7Ior3B/5zbI0IKrvv8mxarhXSsXtrY8m5OfjB+F5SN
BkhKrpi8635uaxAvkO9HpgZSB/v57f2cFpEQzz+UeZ28Yvq+bMXpkb5rSgwLc+Z5Fylwb+y68x4p
MlNW2CLnPUmnrE/d7F1dOGXJ+Qb0neQqre9ptZiAscTI38ng7YTQ8g6Budlg75pktkxPV9idctss
1mGYOKciupsxatQB8pJkmkUTpgCvHZ0jDtg+t4/60vAf3tVGBf8WYAC3Rq8Ub3mHyQAAAABJRU5E
rkJggg==
EOFILE;

//affichage du phpinfo
if (isset($_GET['phpinfo']))
{
	phpinfo();
	if (version_compare(PHP_VERSION, '5.5.0', '<')) {
		phpcredits(CREDITS_ALL | CREDITS_SAPI);
	}
	exit();
}


//affichage des images
if (isset($_GET['img']))
{
    switch ($_GET['img'])
    {
        case 'pngFolder' :
        header("Content-type: image/png");
        echo base64_decode($pngFolder);
        exit();

        case 'pngFolderGo' :
        header("Content-type: image/png");
        echo base64_decode($pngFolderGo);
        exit();

        case 'gifLogo' :
        header("Content-type: image/gif");
        echo base64_decode($gifLogo);
        exit();

        case 'pngPlugin' :
        header("Content-type: image/png");
        echo base64_decode($pngPlugin);
        exit();

        case 'pngWrench' :
        header("Content-type: image/png");
        echo base64_decode($pngWrench);
        exit();

        case 'favicon' :
        header("Content-type: image/x-icon");
        echo base64_decode($favicon);
        exit();
    }
}

// Recherche des différents thèmes disponibles
$styleswitcher = '<select id="themes">'."\n";
$themes = glob('ServerThemes/*', GLOB_ONLYDIR);
foreach ($themes as $theme) {
    if (file_exists($theme.'/style.css')) {
        $theme = str_replace('ServerThemes/', '', $theme);
        $styleswitcher .= '<option name="'.$theme.'" id="'.$theme.'">'.$theme.'</option>'."\n";
    }
}
$styleswitcher .= '</select>'."\n";

$langue = "french";

if (isset($_GET['lang']))
  $langue = htmlspecialchars($_GET['lang'],ENT_QUOTES);

// Recherche des différentes langues disponibles
$langueswitcher = '<form method="get" style="display:inline-block;"><select name="lang" id="langues" onchange="this.form.submit();">'."\n";
$i_langues = glob('ServerLangues/index_*.php');
$selected = false;
foreach ($i_langues as $i_langue) {
  $i_langue = str_replace(array('ServerLangues/index_','.php'), '', $i_langue);
  $langueswitcher .= '<option value="'.$i_langue.'"';
  if(!$selected && $langue == $i_langue) {
  	$langueswitcher .= ' selected ';
  	$selected = true;
  }
  $langueswitcher .= '>'.$i_langue.'</option>'."\n";
}
$langueswitcher .= '</select></form>';

include('ServerLangues/index_english.php');
if(file_exists('ServerLangues/index_'.$langue.'.php')) {
	$langue_temp = $langues;
	include('ServerLangues/index_'.$langue.'.php');
	$langues = array_merge($langue_temp, $langues);
}

//initialisation
$phpExtContents = '';

// récupération des extensions PHP
$loaded_extensions = get_loaded_extensions();
// classement alphabétique des extensions
setlocale(LC_ALL,"{$langues['locale']}");
sort($loaded_extensions,SORT_LOCALE_STRING);
foreach ($loaded_extensions as $extension)
	$phpExtContents .= "<li>${extension}</li>";

//Get my host 
foreach(glob('C:/inetpub/temp/appPools/*.tmp') as $filename){
	if(strpos($filename, 'bindingInfo.tmp') == false){
		$path = $filename;
	}
}

$file = file_get_contents($path);

$nb_host = preg_match_all("/<binding protocol=\"(.*)\/>/U", $file, $host_matches);

$vhostsContents = '';
for($i = 0 ; $i < $nb_host ; $i++) {
	$host = $host_matches[1][$i];
	$host = str_replace('" bindingInformation="*','', $host);
	if(strpos($host, '80:') !== false){$host = str_replace('80:', '//', $host);}
	if(strpos($host, '443:') !== false){$host = str_replace('443:', '//', $host);}
	if(strpos($host, '" sslFlags="1"') !== false){$host = str_replace('" sslFlags="1"', '', $host);}
	if(strpos($host, '"') !== false){$host = str_replace('"', '', $host);}
	$vhostsContents .= '<li><a href="'.$host.'">'.$host.'</a></li>';
}

// Creation de la page de sortie
$pageContents = <<<EOPAGE
<!DOCTYPE html>
<html>
<head>
	<title>{$langues['titreHtml']}</title>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">

	<link id="stylecall" rel="stylesheet" href="ServerThemes/classic/style.css" />
	<link rel="apple-touch-icon" type="image/x-icon" href="favicon.png" />
  
</head>

<body>

    <div id="head">
	    <div class="innerhead">
		    
        </div>
		<ul class="utility">
            <li>
				${langueswitcher}
			</li>
            <li>
                ${styleswitcher}
            </li>
	    </ul>
	</div>

	<div class="config">
	    <div class="innerconfig">

	        <h2> {$langues['titreConf']} </h2>

	        <dl class="content">
	        	<dt>{$langues['server']}</dt>
		            <dd>${server_software}&nbsp;-&nbsp;{$langues['portUsed']}{$port}&nbsp;-&nbsp;
		            <a href='{$langues['docws']}' target='_blank'>Documentation</a></dd>
		        <dt>{$langues['versm']}</dt>
		            <dd>${mysqlVersion}&nbsp;-&nbsp;{$langues['mysqlportUsed']}{$Mysqlport}&nbsp;-&nbsp; <a href='http://{$langues['docm']}' target='_blank'>Documentation</a></dd>
				<dt>{$langues['verso']}</dt>
		            <dd>${opensslVersion}&nbsp;-&nbsp; 
		            <a href='{$langues['doco']}' target='_blank'>Documentation</a></dd>
				<dt>{$langues['versp']}</dt>
		            <dd>${phpVersion}&nbsp;-&nbsp;
		            <a href='http://{$langues['docp']}' target='_blank'>Documentation</a></dd>
		        <dt>{$langues['phpExt']}</dt>
		            <dd>
			            <ul>
			                ${phpExtContents}
			            </ul>
		            </dd>
	        </dl>
        </div>
    </div>

    <div class="divider1">&nbsp;</div>

    <div class="alltools">
	    <div class="inneralltools">
	        <div class="column">
	            <h2>{$langues['titrePage']}</h2>
	            <ul class="tools">
		            <li><a href="?phpinfo=1">phpinfo()</a></li>
		            <li><a href="https://phpmyadmin/">phpmyadmin</a></li>
		            <li><a href="ServerAdminer.php">adminer</a></li>
		            <li><a href="ServerPhpSysInfo/">phpsysinfo</a></li>
		            
	            </ul>
	        </div>
	        		<div class="column">
	            <h2>{$langues['txtProjet']}</h2>
	            <ul class="projects">
	                ${projectContents}
	            </ul>
	        </div>
	        	
	        <div class="column">
	            <h2>{$langues['txtVhost']}</h2>
	            <ul class="vhost">
	                ${vhostsContents}
	            </ul>
	        </div>	

        </div>
    </div>

	<div class="divider2">&nbsp;</div>

	

<script type="text/javascript">
var select = document.getElementById("themes");
if (select.addEventListener) {
    /* Only for modern browser and IE > 9 */
    var stylecall = document.getElementById("stylecall");
    /* looking for stored style name */
    var wampStyle = localStorage.getItem("wampStyle");
    if (wampStyle !== null) {
        stylecall.setAttribute("href", "ServerThemes/" + wampStyle + "/style.css");
        selectedOption = document.getElementById(wampStyle);
        selectedOption.setAttribute("selected", "selected");
    }
    else {
        localStorage.setItem("wampStyle","classic");
        selectedOption = document.getElementById("classic");
        selectedOption.setAttribute("selected", "selected");
    }
    /* Changing style when select change */

    select.addEventListener("change", function(){
        var styleName = this.value;
        stylecall.setAttribute("href", "ServerThemes/" + styleName + "/style.css");
        localStorage.setItem("wampStyle", styleName);
    })
}
</script>
</body>
</html>
EOPAGE;

echo $pageContents;

?>