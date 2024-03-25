<?php

/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Если входящий поток существует, начинаем работу.
!isset($_POST['data']) && die();

define("IN_LR", true);

// Основная директория вэб-приложения.
define('APP', '../../../../app/');

// Основная директория вэб-приложения.
define('STORAGE', '../../../../storage/');

// Директория содержащая основные блоки вэб-приложения.
define('PAGE', APP . 'page/general/');

// Директория содержащая дополнительные блоки вэб-приложения.
define('PAGE_CUSTOM', APP . 'page/custom/');

// Директория с модулями.
define('MODULES', APP . 'modules/');

// Директория с основными конфигурационными файлами.
define('INCLUDES', APP . 'includes/');

// Директория содержащая графические кэш-файлы.
define('CACHE', STORAGE . 'cache/');
// Директория с ресурсами.
define('ASSETS', STORAGE . 'assets/');

// Директория с основными кэш-файлами.
define('SESSIONS', CACHE . 'sessions/');

// Директория содержащая логи.
define('LOGS', CACHE . 'logs/');

// Директория содержащая изображения.
define('IMG', CACHE . 'img/');

// Директория с CSS шаблонами.
define('ASSETS_CSS', ASSETS . 'css/');

// Директория с JS библиотеками.
define('ASSETS_JS', ASSETS . 'js/');

// Директория с шаблонами "Themes".
define('THEMES', ASSETS_CSS . 'themes/');

// Директория с изображениями рангов.
define('RANKS_PACK', IMG . 'ranks/');

// Временные константы ( Постоянные времени ) - Минута.
define('MINUTE_IN_SECONDS', 60);

// Временные константы ( Постоянные времени ) - Час.
define('HOUR_IN_SECONDS', 3600);

// Временные константы ( Постоянные времени ) - День.
define('DAY_IN_SECONDS', 86400);

// Временные константы ( Постоянные времени ) - Неделя.
define('WEEK_IN_SECONDS', 604800);

// Временные константы ( Постоянные времени ) - Месяц.
define('MONTH_IN_SECONDS', 2592000);

// Временные константы ( Постоянные времени ) - Год.
define('YEAR_IN_SECONDS', 31536000);

session_start();

// Подключение SourceQuery.
require '../ext/SourceQuery/bootstrap.php';

// Подключение основных функций.
require '../../../includes/functions.php';

require '../../../ext/Db.php';

use \app\ext\Db;
use xPaw\SourceQuery\SourceQuery;

$Db = new Db;

// Если входящий поток существует, начинаем работу.
!isset($_POST['data']) && die();

// Итоговый вывод является массивом.
$return = [];

// Итоговый кэш является массивом.
$cache = [];

// Присваиваем список серверов.
$servers = $_POST['data'][0];

// Считаем количество серверов.
$servers_count = sizeof($servers);


// Перебираем список серверов и собираем данные в подмассивы.
for ($i_ser = 0; $i_ser < $servers_count; $i_ser++) :
    // Список основых IP | PORT.
    $server[] = explode(":", $servers[$i_ser]['ip']);

    // Список Fake IP:PORT.
    $server_fakeip[] = $servers[$i_ser]['fakeip'];

    // Название сервера из БД.
    $server_name[] = $servers[$i_ser]['name_custom'];
endfor;
// Создние экземпляра класса - SourceQuery.
$Query = new SourceQuery();

// Перебор серверов и получение актуальной информации.
for ($i_server = 0; $i_server < $servers_count; $i_server++) :
    // Освное действие
    try {
        // Попытка подключения, протокол - Source.
        $Query->Connect($server[$i_server][0], $server[$i_server][1], 3, SourceQuery::SOURCE);

        // Присваиваем полученную информацию о сервере.
        $info[$i_server] = $Query->GetInfo();

        $score = $server_score["ct_rounds"] . ":" . $server_score["t_rounds"];
        $return[ $i_server ]["Score"] = $score;
        $return[ $i_server ]["Rank_Pack"] = $Db->statistics_table[$i_server]['ranks_pack'];

        // Вывод - IP Сервера
        $return[$i_server]['ip'] = empty($server_fakeip[$i_server]) ? $server[$i_server][0] . ':' . $server[$i_server][1] : $server_fakeip[$i_server];

        // Вывод - Название сервера
        // $return[ $i_server ]['HostName'] = substr_unicode( $info[ $i_server ]['HostName'], 0, 43 ) . '..';

        // Вывод - Название сервера
        $return[$i_server]['HostName'] = $server_name[$i_server];

        // Проверка на существование изображения карты.
        if (file_exists('../../../../storage/cache/img/maps/' . $info[$i_server]['AppID'] . '/' . array_reverse(explode("/", $info[$i_server]['Map']))[0] . '.jpg')) :
            // Вывод - Название карты.
            $return[$i_server]['Map'] = array_reverse(explode("/", $info[$i_server]['Map']))[0];

            // Вывод - Изображение карты карты.
            $return[$i_server]['Map_image'] = array_reverse(explode("/", $info[$i_server]['Map']))[0];

            // Вывод изображения эмблемы карты
            $return[$i_server]['Map_Pin'] = '_' . array_reverse(explode("/", $info[$i_server]['Map']))[0];

            // Добавление в кэш ссылки на изображения текущей карты.
            $cache[$i_server] = $info[$i_server]['AppID'] . '/' . array_reverse(explode("/", $info[$i_server]['Map']))[0];
        else :
            // Вывод - Название карты.
            $return[$i_server]['Map'] = array_reverse(explode("/", $info[$i_server]['Map']))[0];

            // Вывод - При отсутсвии изображении, заглушка.
            $return[$i_server]['Map_image'] = '-';

            // Вывод изображения эмблемы карты
            $return[$i_server]['Map_Pin'] = '_';

            // Добавление в кэш заглушки.
            $cache[$i_server] = '730/-';
        endif;

        // Вывод - Количество игроков.
        $return[$i_server]['Players'] = $info[$i_server]['Players'];

        // Вывод - Максимальное количество игроков.
        $return[$i_server]['MaxPlayers'] = $info[$i_server]['MaxPlayers'];

        // Вывод - Название мода.
        $return[$i_server]['Mod'] = $info[$i_server]['AppID'];

        // Исключение
    } catch (Exception $e) {
        // Вывод - IP Сервера
        $return[$i_server]['ip'] = empty($server_fakeip[$i_server]) ? $server[$i_server][0] . ':' . $server[$i_server][1] : $server_fakeip[$i_server];

        // Название выключенного сервера
        $return[$i_server]['HostName'] = 'Сервер отключен';

        // Карта выключенного сервера
        $return[$i_server]['Map'] = '-';

        // Название выключенного сервера
        $return[$i_server]['Map_image'] = '-';

        // Вывод изображения эмблемы карты
        $return[$i_server]['Map_Pin'] = '_';

        // Количество игроков выключенного сервера
        $return[$i_server]['Players'] = 0;
        $return[$i_server]['MaxPlayers'] = 0;

        // Мод выключенного сервера
        $return[$i_server]['Mod'] = '730';
        $cache[$i_server] = '730/-';

        // Конец действия
    } finally {
        $Query->Disconnect();
    }
endfor;

// Проверка директории под кэш
!file_exists('../temp') && mkdir('../temp', 0777, true);

// Кэширование изображений с серверов для предзагрузки блоков
(!file_exists('../temp/cache.php') || $cache != require '../temp/cache.php') && file_put_contents('../temp/cache.php', '<?php return ' . var_export($cache, true) . ";");

// Вывод
echo json_encode($return, JSON_UNESCAPED_UNICODE);
exit;