<?
require_once "Rcon.php";
require_once "../../../ext/Db.php";

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

set_time_limit(4);

define('IN_LR', true);
define('APP', '../../../../app/');
define('STORAGE', '../../../../storage/');
define('PAGE', APP . 'page/general/');
define('PAGE_CUSTOM', APP . 'page/custom/');
define('MODULES', APP . 'modules/');
define('INCLUDES', APP . 'includes/');
define('CACHE', STORAGE . 'cache/');
define('ASSETS', STORAGE . 'assets/');
define('SESSIONS', CACHE . 'sessions/');
define('LOGS', CACHE . 'logs/');
define('IMG', CACHE . 'img/');
define('ASSETS_CSS', ASSETS . 'css/');
define('ASSETS_JS', ASSETS . 'js/');
define('THEMES', ASSETS_CSS . 'themes/');
define('RANKS_PACK', IMG . 'ranks/');
define('MINUTE_IN_SECONDS', 60);
define('HOUR_IN_SECONDS', 3600);
define('DAY_IN_SECONDS', 86400);
define('WEEK_IN_SECONDS', 604800);
define('MONTH_IN_SECONDS', 2592000);
define('YEAR_IN_SECONDS', 31536000);

use \app\ext\Db;
use app\modules\module_block_main_monitoring_rating\ext\Rcon;

$ip = $_POST['ip'];

$Db = new Db();

$rcon = ($Db-> query( 'Core', 0, 0, "SELECT `rcon` FROM `lvl_web_servers` WHERE `ip` = '".$ip."' "))['rcon'];

$_IP = explode(':', $ip);
$_RCON = new Rcon($_IP[0], $_IP[1]);
if( $_RCON->Connect() )
{
    $_RCON->RconPass( $rcon);
    $_RCON->Command( "sm_getserverinfo");
    $_RCON->Disconnect();
}
sleep(1);


$myfile = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/modules/module_block_main_monitoring_rating/servers/".$ip.".json");
$data = json_decode($myfile, true);
$Players = [];
$Players[0]['score_t'] = $data['score_t'];
$Players[0]['score_ct'] = $data['score_ct'];
for ($i=0; $i < count($data['players']); $i++)
{
    $Player = [];

    $Player['Name'] = $data['players'][$i]['name'];
    $Player['SteamID'] = $data['players'][$i]['steamid'];
    $Player['Frags'] = $data['players'][$i]['kills'];
    $Player['Death'] = $data['players'][$i]['death'];
    $Player['Assist'] = $data['players'][$i]['assists'];
    $Player['Headshots'] = $data['players'][$i]['headshots'];
    $Player['PlayTime'] = $data['players'][$i]['playtime'];
    $Player['rank'] = $data['players'][$i]['rank'];
    $Players[ ] = $Player;
}

echo json_encode($Players);
?>