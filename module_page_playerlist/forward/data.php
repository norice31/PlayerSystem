<?php

/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Запрос на получение информации о банах

use app\modules\module_page_playerlist\ext\Rcon;

function Rcons($Db, $sid, $command)
{
    try {
        $server = $Db->queryAll('Core', 0, 0, "SELECT `ip`, `rcon` FROM `lvl_web_servers`");
        $_IP = explode(':', $server[$sid]['ip']);
        $_RCON = new Rcon($_IP[0], $_IP[1]);
        if ($_RCON->Connect()) {
            $_RCON->RconPass($server[$sid]['rcon']);
            $_RCON->Command($command);
            $_RCON->Disconnect();
        }
    } catch (Exception $e) {
        return ['status' => "error", 'text' => "RCON error: {$e->getMessage()}"];
    }
}

$info = $Db->query('Core', 0, 0, "SELECT * FROM fe_settings");

if (isset($_GET['getplayers'])) {
    $sid = $_GET['getplayers']-1;
    if ($info['admin'] == 1) {
        $USER_ID = $Db->db_data['IksAdmin'][0]['USER_ID'];
        $DB_num = $Db->db_data['IksAdmin'][0]['DB_num'];
        $Table = $Db->db_data['IksAdmin'][0]['Table'];
        
        
        if ($info['ikstype'] == 1) { 
            $access = $Db->query('IksAdmin', $USER_ID, $DB_num, "SELECT `sid` FROM `".$Table."admins` WHERE `sid` LIKE ".$_SESSION['steamid64']);
        } else {
            $access = $Db->query('IksAdmin', $USER_ID, $DB_num, "SELECT `sid` FROM `".$Table."admins` WHERE `sid` LIKE ".$_SESSION['steamid64']." AND `server_id` LIKE ".$_GET['getplayers']);
        }
    } else {
        $USER_ID = $Db->db_data['AdminSystem'][$sid]['USER_ID'];
        $DB_num = $Db->db_data['AdminSystem'][$sid]['DB_num'];
        $Table = $Db->db_data['AdminSystem'][$sid]['Table'];

        $access = $Db->query('AdminSystem', $USER_ID, $DB_num, "SELECT `steamid` FROM `".$Table."admins` WHERE `steamid` LIKE ".$_SESSION['steamid64']);
    }

    if (!$access) {
        $adm = 0;
    } else {
        $adm = 1;
    }

    // Запрос на получение информации о игроках
    $res_players = $Db->queryAll('Core', 0, 0, "SELECT `steam`, `name`, `userid`, `server_id`, `entry_tile` FROM `fe_players` WHERE `server_id` LIKE ".$_GET['getplayers']);
    $res_logs = $Db->queryAll('Core', 0, 0, "SELECT `steam1`, `name1`, `steam2`, `name2`, `text`, `date` FROM `fe_logs` WHERE `server_id` LIKE ".$_GET['getplayers']." ORDER BY `date` DESC");


    die(json_encode(array(
        'players' => $res_players,
        'logs' => $res_logs,
        'adm' => $adm,
        'sid' => $sid
    )));
}

    if (isset($_GET['settings'])) {
        ( !isset( $_SESSION['user_admin'] ) ) && die(json_encode(array(
            'error' => 1
        )));;

        if ($info[$_GET['settings']] == 0) {
            $Db->query('Core', 0, 0, "UPDATE `fe_settings` SET ".$_GET['settings']."=1");
        } else {
            $Db->query('Core', 0, 0, "UPDATE `fe_settings` SET ".$_GET['settings']."=0");
        }

        die(json_encode(array(
            'error' => 0
        )));
    }

    if ($info['admin'] == 1) {
        if (isset($_GET['kick'])) {
            $sid = $_GET['sid']-1;
                
            $USER_ID = $Db->db_data['IksAdmin'][0]['USER_ID'];
            $DB_num = $Db->db_data['IksAdmin'][0]['DB_num'];
            $Table = $Db->db_data['IksAdmin'][0]['Table'];
            
            if ($info['ikstype'] == 1) { 
                $access = $Db->query('IksAdmin', $USER_ID, $DB_num, "SELECT `sid` FROM `".$Table."admins` WHERE `sid` LIKE ".$_SESSION['steamid64']);
            } else {
                $access = $Db->query('IksAdmin', $USER_ID, $DB_num, "SELECT `sid` FROM `".$Table."admins` WHERE `sid` LIKE ".$_SESSION['steamid64']." AND `server_id` LIKE ".$_GET['sid']);
            }

            if (!$access) 
                die(json_encode(array(
                    'error' =>  1
                )));

            // Запрос на получение информации о игроке
            $res_player = $Db->query('Core', 0, 0, "SELECT `steam`, `name`, `userid`, `server_id` FROM `fe_players` WHERE `server_id` LIKE ".$_GET['sid']." AND `userid` LIKE ".$_GET['uid']);

            if (!$res_player) {
                die(json_encode(array(
                    'error' => 2
                )));
            }
            

            $command = 'kickid '.$_GET['uid'];

            Rcons($Db, $sid, $command);

            $params = [
                'steam1' 		=> $_SESSION['steamid64'],
                'name1' 	=> action_text_clear(action_text_trim($General->checkName($_SESSION['steamid64'])), 13),
                'text1'     => 'Кикнул',
                'steam2'	=> $res_player['steam'],
                'name2'	=> $res_player['name'],
                'server_id'	=> $_GET['sid']
            ];

            $Db->query('Core', 0, 0, "INSERT INTO `fe_logs`(`steam1`, `name1`, `text`, `steam2`, `name2`, `server_id`, `date`) VALUES (:steam1, :name1, :text1, :steam2, :name2, :server_id, NOW())",$params);

            die(json_encode(array(
                'error' => 0
            )));
        }

        if (isset($_GET['ban'])) {
            $sid = $_GET['sid']-1;
                
            $USER_ID = $Db->db_data['IksAdmin'][0]['USER_ID'];
            $DB_num = $Db->db_data['IksAdmin'][0]['DB_num'];
            $Table = $Db->db_data['IksAdmin'][0]['Table'];
            
            $access = $Db->query('IksAdmin', $USER_ID, $DB_num, "SELECT `sid` FROM `".$Table."admins` WHERE `sid` LIKE ".$_SESSION['steamid64']." AND `server_id` LIKE ".$_GET['sid']);

            if ($info['ikstype'] == 1) { 
                $access = $Db->query('IksAdmin', $USER_ID, $DB_num, "SELECT `sid` FROM `".$Table."admins` WHERE `sid` LIKE ".$_SESSION['steamid64']);
            } else {
                $access = $Db->query('IksAdmin', $USER_ID, $DB_num, "SELECT `sid` FROM `".$Table."admins` WHERE `sid` LIKE ".$_SESSION['steamid64']." AND `server_id` LIKE ".$_GET['sid']);
            }

            
            if (!$access) 
                die(json_encode(array(
                    'error' => 1
                )));

            // Запрос на получение информации о игроке
            $res_player = $Db->query('Core', 0, 0, "SELECT `steam`, `name`, `userid`, `server_id` FROM `fe_players` WHERE `server_id` LIKE ".$_GET['sid']." AND `userid` LIKE ".$_GET['uid']);
            
            $command = 'kickid '.$_GET['uid'];

            Rcons($Db, $sid, $command);
        
            if ($info['ikstype'] == 1) { 
                $banpar = array(
                    'sid' => $res_player['steam'],
                    'name' => $res_player['name'],
                    'created' => time(),
                    'end' => time() + $_GET['expires'],
                    'time' => $_GET['expires'],
                    'reason' => $_GET['reason'],
                    'adminsid' => $_SESSION['steamid64'],
                    'server_id' => 1
                );
            } else {
                $banpar = array(
                    'sid' => $res_player['steam'],
                    'name' => $res_player['name'],
                    'created' => time(),
                    'end' => time() + $_GET['expires'],
                    'time' => $_GET['expires'],
                    'reason' => $_GET['reason'],
                    'adminsid' => $_SESSION['steamid64'],
                    'server_id' => $_GET['sid']
                );
            }

            $Db->query('IksAdmin', $USER_ID, $DB_num, "INSERT INTO `".$Table."bans`(`name`, `sid`, `adminsid`, `created`, `time`, `end`, `reason`, `server_id`) VALUES (:name, :sid, :adminsid, :created, :time, :end, :reason, :server_id)",$banpar);
        
            if ($info['standart'] == 1)
                $par = array(
                    'steamid' => $res_player['steam'],
                    'name' => $res_player['name'],
                    'created' => time(),
                    'end' => time() + $_GET['expires'],
                    'duration' => $_GET['expires'],
                    'reason' => $_GET['reason'],
                    'admin_steamid' => $_SESSION['steamid64'],
                    'admin_name' => action_text_clear(action_text_trim($General->checkName($_SESSION['steamid64'])), 13)
                );
                $Db->query('Core', 0, 0, "INSERT INTO `fe_bans`(`steamid`, `name`, `created`, `end`, `duration`, `reason`, `admin_steamid`, `admin_name`) VALUES (:steamid, :name, :created, :end, :duration, :reason, :admin_steamid, :admin_name)",$par);
    

            $params = [
                'steam1' 		=> $_SESSION['steamid64'],
                'name1' 	=> action_text_clear(action_text_trim($General->checkName($_SESSION['steamid64'])), 13),
                'text1'     => 'Забанил',
                'steam2'	=> $res_player['steam'],
                'name2'	=> $res_player['name'],
                'server_id'	=> $_GET['sid']
            ];
        
            $Db->query('Core', 0, 0, "INSERT INTO `fe_logs`(`steam1`, `name1`, `text`, `steam2`, `name2`, `server_id`, `date`) VALUES (:steam1, :name1, :text1, :steam2, :name2, :server_id, NOW())",$params);
        
        
            die(json_encode(array(
                'error' => 0
            )));
        }
    } else {
        if (isset($_GET['kick'])) {
            $sid = $_GET['sid']-1;
                
            $USER_ID = $Db->db_data['AdminSystem'][$sid]['USER_ID'];
            $DB_num = $Db->db_data['AdminSystem'][$sid]['DB_num'];
            $Table = $Db->db_data['AdminSystem'][$sid]['Table'];
            
            $access = $Db->query('AdminSystem', $USER_ID, $DB_num, "SELECT `steamid` FROM `".$Table."admins` WHERE `steamid` LIKE ".$_SESSION['steamid64']);
            
            if (!$access) 
                die(json_encode(array(
                    'error' => 1
                )));

            // Запрос на получение информации о игроке
            $res_player = $Db->query('Core', 0, 0, "SELECT `steam`, `name`, `userid`, `server_id` FROM `fe_players` WHERE `server_id` LIKE ".$_GET['sid']." AND `userid` LIKE ".$_GET['uid']);

            if (!$res_player) {
                die(json_encode(array(
                    'error' => 2
                )));
            }
            

            $command = 'kickid '.$_GET['uid'];

            Rcons($Db, $sid, $command);

            $params = [
                'steam1' 		=> $_SESSION['steamid64'],
                'name1' 	=> action_text_clear(action_text_trim($General->checkName($_SESSION['steamid64'])), 13),
                'text1'     => 'Кикнул',
                'steam2'	=> $res_player['steam'],
                'name2'	=> $res_player['name'],
                'server_id'	=> $_GET['sid']
            ];

            $Db->query('Core', 0, 0, "INSERT INTO `fe_logs`(`steam1`, `name1`, `text`, `steam2`, `name2`, `server_id`, `date`) VALUES (:steam1, :name1, :text1, :steam2, :name2, :server_id, NOW())",$params);

            die(json_encode(array(
                'error' => 0
            )));
        }

        if (isset($_GET['ban'])) {
            $sid = $_GET['sid']-1;
                
            $USER_ID = $Db->db_data['AdminSystem'][$sid]['USER_ID'];
            $DB_num = $Db->db_data['AdminSystem'][$sid]['DB_num'];
            $Table = $Db->db_data['AdminSystem'][$sid]['Table'];
            
            $access = $Db->query('AdminSystem', $USER_ID, $DB_num, "SELECT `steamid` FROM `".$Table."admins` WHERE `steamid` LIKE ".$_SESSION['steamid64']);
            
            if (!$access) 
                die(json_encode(array(
                    'error' => 1
                )));

            // Запрос на получение информации о игроке
            $res_player = $Db->query('Core', 0, 0, "SELECT `steam`, `name`, `userid`, `server_id` FROM `fe_players` WHERE `server_id` LIKE ".$_GET['sid']." AND `userid` LIKE ".$_GET['uid']);
            
            $command = 'kickid '.$_GET['uid'];

            Rcons($Db, $sid, $command);
        
            $par = array(
                'steamid' => $res_player['steam'],
                'name' => $res_player['name'],
                'created' => time(),
                'end' => time() + $_GET['expires'],
                'duration' => $_GET['expires'],
                'reason' => $_GET['reason'],
                'admin_steamid' => $_SESSION['steamid64'],
                'admin_name' => action_text_clear(action_text_trim($General->checkName($_SESSION['steamid64'])), 13)
            );

            $Db->query('AdminSystem', $USER_ID, $DB_num, "INSERT INTO `".$Table."bans`(`steamid`, `name`, `created`, `end`, `duration`, `reason`, `admin_steamid`, `admin_name`) VALUES (:steamid, :name, :created, :end, :duration, :reason, :admin_steamid, :admin_name)",$par);
        
            if ($info['standart'] == 1)
                $Db->query('Core', 0, 0, "INSERT INTO `fe_bans`(`steamid`, `name`, `created`, `end`, `duration`, `reason`, `admin_steamid`, `admin_name`) VALUES (:steamid, :name, :created, :end, :duration, :reason, :admin_steamid, :admin_name)",$par);
    

            $params = [
                'steam1' 		=> $_SESSION['steamid64'],
                'name1' 	=> action_text_clear(action_text_trim($General->checkName($_SESSION['steamid64'])), 13),
                'text1'     => 'Забанил',
                'steam2'	=> $res_player['steam'],
                'name2'	=> $res_player['name'],
                'server_id'	=> $_GET['sid']
            ];
        
            $Db->query('Core', 0, 0, "INSERT INTO `fe_logs`(`steam1`, `name1`, `text`, `steam2`, `name2`, `server_id`, `date`) VALUES (:steam1, :name1, :text1, :steam2, :name2, :server_id, NOW())",$params);
        
        
            die(json_encode(array(
                'error' => 0
            )));
        }

    }