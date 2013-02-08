<?php




require '../../vendor/slim/Slim/Slim.php';
require '../../vendor/slim/Slim-Extras/Views/TwigView.php';
require '../../vendor/slim/Slim-Extras/LogWriters/TimestampLogFileWriter.php';
require '../../vendor/mongo/crud.php';
require '../../vendor/mongo/list.php';
require '../../vendor/mongo/command.php';

require '../../vendor/PHPMailer/class.phpmailer.php';
require_once '../../vendor/Twig/Autoloader.php';


require_once '../../vendor/Twig/Autoloader.php';
Twig_Autoloader::register();

require_once '../../vendor/Twig/Extensions/Autoloader.php';
Twig_Extensions_Autoloader::register();



session_cache_limiter(false);
session_start();



// set environment
$whitelist = array('pipeline.matti', '127.0.0.1');

if(in_array($_SERVER['HTTP_HOST'], $whitelist)){

    define("ENVIRONMENT", 'development');
    define("HOST", 'http://pipeline.matti');
    define("BASE_FOLDER", '');
    error_reporting(E_ALL);
    ini_set('display_errors', "1");

}else if($_SERVER['HTTP_HOST'] == "cfpatientcases.xc-events.it"){

   define("ENVIRONMENT", 'production');
   define("BASE_FOLDER", '');
   define("HOST", 'http://cfpatientcases.xc-events.it');
   
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   
   //phpinfo();die();
   
}else{
  
   define("ENVIRONMENT", 'staging');
   define("HOST", 'http://pipeline.mattimatti.com');
   define("BASE_FOLDER", '');
   error_reporting(0);
   ini_set('display_errors', 0);
  
}



// setup language
$availableLanguages = array(
    'fr' => 'fr_FR.utf8',
    'en' => 'en_GB.utf8',
    'default' => 'en_GB.utf8'
);

if (!function_exists("gettext"))
{
    die( "gettext is not installed\n");
}

$lang = "en";

if(isset($_SESSION["lang"])){
  $lang = $_SESSION["lang"];
}

// hello
//$lang = "fr";


// Setup language
$locale = (isset($lang) && array_key_exists($lang, $availableLanguages)) ? $availableLanguages[$lang] : $availableLanguages['default'];


$te = 'LC_ALL=$locale';
putenv($te);

$ta = $locale;
setlocale(LC_ALL, $ta);

if(ENVIRONMENT == 'development'){
  putenv('LC_ALL='.$locale);
  setlocale(LC_ALL, '$ta');
}





$domain = "messages";
$locales_root = "includes/locale";

$filename = "$locales_root/$lang/LC_MESSAGES/$domain.mo";
$mtime = filemtime($filename); // check its modification time
// our new unique .MO file
$filename_new = "$locales_root/$lang/LC_MESSAGES/{$domain}_{$mtime}.mo"; 



if (!file_exists($filename_new)) {  // check if we have created it before
      // if not, create it now, by copying the original
      copy($filename,$filename_new);
}



// compute the new domain name
$domain_new = "{$domain}_{$mtime}";

bindtextdomain($domain_new, $locales_root);
bind_textdomain_codeset($domain_new, 'UTF-8');
textdomain($domain_new);


/*
trace($lang);
trace($locale);
trace($filename_new);
trace($domain_new);
trace(gettext("Continue"));
die();
*/









// setup twig
TwigView::$twigDirectory = dirname(__FILE__) .'/../../vendor/Twig';
TwigView::$twigExtensions = array("Twig_Extensions_Extension_I18n");
//TwigView::$twigOptions = array('cache' => 'tmp/cache/', 'auto_reload' => true);
TwigView::$twigOptions = array('cache' => false, 'auto_reload' => true);











define('MONGO_HOST', '127.0.0.1');


// setup slim app
$app = new Slim(array(
    'templates.path' => __DIR__.'/../../templates/',
    'log.writer' => new TimestampLogFileWriter(),
    'view' => 'TwigView',
    'cookies.secret_key'  => 'MY_SALTY_PEPPER',
    'cookies.lifetime' => time() + (1 * 24 * 60 * 60), // = 1 day
    'cookies.cipher' => MCRYPT_RIJNDAEL_256,
    'cookies.cipher_mode' => MCRYPT_MODE_CBC
));


$app->config('lang', $lang);
$app->config('debug', (ENVIRONMENT == 'development') ? true : false );
$app->config('mode', ENVIRONMENT);

$app->hook('slim.before', function () use ($app) {
    $app->view()->appendData(array('lang' => $app->config('lang')));
});




// @todo: add count collection command mongo/commands.php





include '../../routes/application.php';
include '../../routes/rest.php';

$app->run();






