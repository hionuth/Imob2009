<?php

defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
//defined('SITE_ROOT') ? null : define('SITE_ROOT',DS.'var'.DS.'www'.DS.'Imob2009');
$site_root=explode(DS, __DIR__);
array_pop($site_root);
$sr=implode(DS, $site_root);
defined('SITE_ROOT') ? null : define('SITE_ROOT',$sr);//DS.'home'.DS.'igor'.DS.'igor.lanconect.ro'.DS.'Imob2009');
defined('LIB_PATH') ? null : define('LIB_PATH',SITE_ROOT.DS.'include');
defined('PDF_PATH') ? null : define('PDF_PATH',SITE_ROOT.DS.'images'.DS.'pdf');
defined('PHOTO_PATH') ? null : define('PHOTO_PATH',SITE_ROOT.DS.'images');
//
defined('SITE_SERVER') ? null : define('SITE_SERVER','localhost');
defined('SITE_USER') ? null : define('SITE_USER','igor_site');
defined('SITE_PASSWORD') ? null : define('SITE_PASSWORD','floarealbastra');
defined('SITE_DB') ? null : define('SITE_DB','igor_site');

defined('NEW_SITE_SERVER') ? null : define('NEW_SITE_SERVER','localhost');
defined('NEW_SITE_USER') ? null : define('NEW_SITE_USER','simspark_site');
defined('NEW_SITE_PASSWORD') ? null : define('NEW_SITE_PASSWORD','VPhNr7mgk4Y');
defined('NEW_SITE_DB') ? null : define('NEW_SITE_DB','simspark_imobiliare');

defined('FTP_SERVER') ? null : define('FTP_SERVER','ftp.simsparkman-imobiliare.ro');
defined('FTP_USER') ? null : define('FTP_USER','simspark');
defined('FTP_PASSWORD') ? null : define('FTP_PASSWORD','iTnSdLqG{t$#');
defined('FTP_PATH') ? null : define('FTP_PATH','./www/foto');
defined('NEW_FTP_PATH') ? null : define('NEW_FTP_PATH','./www/foto');
//
// sincronizare Imobiliare.ro$ftp_conn
defined('API_URI') ? null : define( 'API_URI', 'http://wsia.imobiliare.ro/index.php?wsdl' );
defined('API_USER') ? null : define( 'API_USER', 'X3F5');//'X36V' );
defined('API_KEY') ? null : define( 'API_KEY', '3DQHUTGtjeHQwD7U');//'89cn23489fn32r' );

//defined('SITE_SERVER') ? null : define('SITE_SERVER','localhost');
//defined('SITE_USER') ? null : define('SITE_USER','igor_site');
//defined('SITE_PASSWORD') ? null : define('SITE_PASSWORD','floarealbastra');
//defined('SITE_DB') ? null : define('SITE_DB','igor_site');

// load config
require_once(LIB_PATH.DS."config.php");

// load basic functions
require_once(LIB_PATH.DS."functions.php");

// core objects
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."databaseobject.php");

// database clases
require_once(LIB_PATH.DS."user.php");


?>