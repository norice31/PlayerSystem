<?php
if (isset($_SESSION['user_admin'])) : ?>
    <aside class="sidebar-right unshow">
        <section class="sidebar">
            <div class="user-sidebar-right-block">
                <div class="info">
                    <div class="admin_type">
                        <svg viewBox="0 0 512 512">
                            <path d="M78.6 5C69.1-2.4 55.6-1.5 47 7L7 47c-8.5 8.5-9.4 22-2.1 31.6l80 104c4.5 5.9 11.6 9.4 19 9.4h54.1l109 109c-14.7 29-10 65.4 14.3 89.6l112 112c12.5 12.5 32.8 12.5 45.3 0l64-64c12.5-12.5 12.5-32.8 0-45.3l-112-112c-24.2-24.2-60.6-29-89.6-14.3l-109-109V104c0-7.5-3.5-14.5-9.4-19L78.6 5zM19.9 396.1C7.2 408.8 0 426.1 0 444.1C0 481.6 30.4 512 67.9 512c18 0 35.3-7.2 48-19.9L233.7 374.3c-7.8-20.9-9-43.6-3.6-65.1l-61.7-61.7L19.9 396.1zM512 144c0-10.5-1.1-20.7-3.2-30.5c-2.4-11.2-16.1-14.1-24.2-6l-63.9 63.9c-3 3-7.1 4.7-11.3 4.7H352c-8.8 0-16-7.2-16-16V102.6c0-4.2 1.7-8.3 4.7-11.3l63.9-63.9c8.1-8.1 5.2-21.8-6-24.2C388.7 1.1 378.5 0 368 0C288.5 0 224 64.5 224 144l0 .8 85.3 85.3c36-9.1 75.8 .5 104 28.7L429 274.5c49-23 83-72.8 83-130.5zM104 432c0 13.3-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="menu">
                <ul class="nav">
                    <li data-tippy-placement="left" data-tippy-content="Настройки" <?php get_section('section', 'gateways') == 'settings' && print 'class="active_m"' ?> onclick="location.href = '<?php echo set_url_section(get_url(2), 'section', 'settings') ?>';">
                        <svg viewBox="0 0 576 512">
                            <path d="M184.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L39 113c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L39 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM256 96c0-17.7 14.3-32 32-32H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H288c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H288c-17.7 0-32-14.3-32-32zM192 416c0-17.7 14.3-32 32-32H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H224c-17.7 0-32-14.3-32-32zM80 464c-26.5 0-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48s-21.5 48-48 48z" />
                        </svg>
                    </li>
                </ul>
            </div>
        </section>
    </aside>
<?php endif;
if (!empty($_GET['section']) && isset($_SESSION['steamid32'])) : ?>
    <div class="row">
        <?php switch ($_GET['section']):
            case $_GET['section']:
                require MODULES . 'module_page_playerlist/includes/' . $_GET['section'] . '.php';
                break;
        endswitch; ?>
    </div>
<?php else : ?>
<div class="popup" style="background-color: rgb(11 11 11);">
    <div class="button_admin_right popup-close" style="width: 30px;height: 30px;text-align: center;margin-left: auto;margin-right: -9px; margin-top: -10px;">X</div>
    <span style="color: var(--span-color);">Настройка бана</span>
    <div class="qiwipay">
        <form id="ban">
            <input type="text" id="inf" name="uid" style="display: none" value="1">
            <input type="text" id="inf" name="sid" style="display: none" value="1">
            <center>
                <select id="expires" size="5" style="color: var(--span-color); background-color: var(--grey-color); width: 200px; margin-top: 50px; font-size: 25px; text-align: center; border: 0px; border-radius: 10px;">
                    <option value="300" selected>5 Минут</option>
                    <option value="600">10 Минут</option>
                    <option value="1800">30 Минут</option>
                    <option value="3600">1 Час</option>
                    <option value="7200">2 Часа</option>
                    <option value="10800">3 Часа</option>
                    <option value="18000">5 Часов</option>
                    <option value="43200">12 Часов</option>
                    <option value="86400">1 День</option>
                    <option value="259200">3 Дня</option>
                    <option value="604800">1 Неделя</option>
                    <option value="2592000">1 Месяц</option>
                    <option value="0" style="color: red">Навсегда</option>
                </select>
            </center>
            <center>
                <br>
                <input class="form-control" type="text" id="inf" name="reason" value="Читер" style="text-align:center;border-radius: 5px;padding: 10px;color: var(--span-color); background-color: var(--grey-color);">
                <br><br>
                <div id="ban-submit" class="button_admin_right popup-open" style="/* padding: 36px; */font-size: 14px;height: 46px;width: 100px;text-align: center;">Забанить</div>
            </center>
        </form>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="last_bans_comms">
                <div class="head_text">Игроки онлайн</div>
            </div>
            <div class="last_bans_comms_header_muts">
                <span>#</span>
                <span>Игрок</span>
                <span>Зашел</span>
                <span id="admbt">Действие</span>
            </div>
            <ul class="lbam_list_body_muts lbam_list_scroll" id="list_server_to_gags"></ul>
        </div>
    </div>
        <div class="col-md-6">
        <div class="card">
            <div class="last_bans_comms">
                <div class="head_text">Логи действий</div>
            </div>
            <div class="last_bans_comms_header_muts">
                <span><?php echo $Translate->get_translate_phrase('_Date') ?></span>
                <span>Админ</span>
                <span>Действие</span>
                <span>Игрок</span>
            </div>
            <ul class="lbam_list_body_muts lbam_list_scroll" id="list_server_to_logs"></ul>
        </div>
    </div>
</div>
<script src="/app/modules/module_page_playerlist/assets/js/jq.js"></script>
<script src="/app/modules/module_page_playerlist/assets/js/moment.js"></script>
<script src="/app/modules/module_page_playerlist/assets/js/livestamp.min.js"></script>
<script>
		moment.defineLocale('en-foo', {
			parentLocale: 'ru',
		});
</script>
<?php endif; ?>
