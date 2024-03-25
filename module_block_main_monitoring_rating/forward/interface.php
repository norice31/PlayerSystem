<?php
?>
<script>
    servers.push(<?= json_encode(action_array_keep_keys($General->server_list, ['ip', 'fakeip', 'name_custom'])) ?>);
</script>
<div class="row fix_mobile">
    <div class="col-md-8">
        <div class="rating_flex_block">
            <div class="rating_title">
                <span>
                    <svg viewBox="0 0 576 512">
                        <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                    </svg>
                    <?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Rating_Three') ?></span>
            </div>
            <div class="ratings_block scroll no-scrollbar">
                <?php for ($d = 0; $d < $Db->table_statistics_count; $d++) : ?>
                    <div class="rating_block">
                        <div class="rating_server_name" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Rating_Server') ?>: <?= $Db->statistics_table[$d]['name'] ?>" data-tippy-placement="top">
                            <svg viewBox="0 0 512 512">
                                <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z" />
                            </svg>
                        </div>
                        <div class="rating_player_card scroll no-scrollbar">
                            <?php $count = sizeof($data['module_block_main_monitoring_rating'][$d]);
                            $data_paste[$d] = $data['module_block_main_monitoring_rating'][$d];
                            for ($dd = 0; $dd < $count; $dd++) {
                                $General->get_js_relevance_avatar($General->arr_general['only_steam_64'] === 1 ? con_steam32to64($data_paste[$d][$dd]['steam']) : $data_paste[$d][$dd]['steam']) ?>
                                <div class="rating_player_info <?php if ($dd + 1 == '1') : ?>first_place<?php endif; ?><?php if ($dd + 1 == '2') : ?>second_place<?php endif; ?><?php if ($dd + 1 == '3') : ?>third_place<?php endif; ?>" onclick="location.href = '<?= $General->arr_general['site'] ?>profiles/<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64($data_paste[$d][$dd]['steam']) : $data_paste[$d][$dd]['steam'] ?>/';">
                                    
                                    <div class="rating_info_right">
                                        <div class="rating_place">
                                            <span><?= $dd + 1 ?></span>
                                            <svg class="<?php if ($dd + 1 == '1') : ?>one<?php endif; ?><?php if ($dd + 1 == '2') : ?>two<?php endif; ?><?php if ($dd + 1 == '3') : ?>three<?php endif; ?>" viewBox="0 0 640 512">
                                                <path d="M144 112C144 50.1 194.1 0 256 0h16c8.8 0 16 7.2 16 16V32c0 60.2-47.5 109.3-107 111.9c-23.9 32.2-37 71.5-37 112.1c0 97.2 78.8 176 176 176h11.6c43.5 0 86.3 10.1 125.2 29.6l9.9 5c11.9 5.9 16.7 20.3 10.7 32.2s-20.3 16.7-32.2 10.7l-9.9-5C403.1 488.4 367.6 480 331.6 480H320 308.4c-36 0-71.5 8.4-103.8 24.5l-9.9 5c-11.9 5.9-26.3 1.1-32.2-10.7s-1.1-26.3 10.7-32.2l9.9-5c8.3-4.2 16.8-7.9 25.4-11.2c-5.6-3.2-11-6.7-16.3-10.3c-59.6 28.2-131.9 6.3-165.4-51.8l-8-13.9c-4.4-7.7-1.8-17.4 5.9-21.9c13.8-8 28.4-13.1 43.3-15.5C27.5 315.6 0 273 0 224V208c0-8.8 7.2-16 16-16c15.9 0 31.1 2.9 45.2 8.2c-24.3-38.8-26.8-89.5-2.3-131.9l8-13.9c4.4-7.7 14.2-10.3 21.9-5.9C115 63.7 133.8 86.8 144 113v-1zm315 31.9C399.5 141.3 352 92.2 352 32V16c0-8.8 7.2-16 16-16h16c61.9 0 112 50.1 112 112v1c10.2-26.2 29-49.2 55.3-64.4c7.7-4.4 17.4-1.8 21.9 5.9l8 13.9c24.5 42.4 21.9 93.1-2.3 131.9c14.1-5.3 29.3-8.2 45.2-8.2c8.8 0 16 7.2 16 16v16c0 49-27.5 91.6-68 113.1c14.8 2.4 29.5 7.5 43.3 15.5c7.7 4.4 10.3 14.2 5.9 21.9l-8 13.9c-24.2 42-68.7 65.1-114 64c-4.8-5.8-10.9-10.8-18.1-14.4l-9.9-5c-2.8-1.4-5.7-2.8-8.6-4.1c-10.4-4.8-21-9-31.8-12.6c-7.9-2.7-15.9-5-24-7C460 378.9 496 321.7 496 256c0-40.6-13.1-79.9-37-112.1z" />
                                            </svg>
                                        </div>
                                        <div class="rating_nick_value">
                                            <span class="rating_nick"><?= htmlentities(action_text_clear(action_text_trim($data_paste[$d][$dd]['name'], 15))) ?></span>
                                            <div class="rating_value"><?= number_format($data_paste[$d][$dd]['value'], 0, '.', ' ') ?> <?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_topValue') ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <?php $servers_cache = $Modules->get_module_cache('module_block_main_monitoring_rating'); ?>
    <div class="col-md-4">
        <div class="servers_flex_block">
            <div class="general_online">
                <div class="general_online_signal">
                    <div class="first_circle">
                        <svg viewBox="0 0 512 512">
                            <path d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512z" />
                        </svg>
                    </div>
                    <div class="second_circle">
                        <svg viewBox="0 0 512 512">
                            <path d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512z" />
                        </svg>
                    </div>
                </div>
                <span>
                    <svg viewBox="0 0 512 512">
                        <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm48 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zm280 72a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm56 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z" />
                    </svg>
                    <?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Rating_Monitoring') ?>
                </span>
                <div class="general_online_count" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Monitoring_Players_Two') ?>" data-tippy-placement="left"><span id="min_players">-</span>/<span id="max_players">-</span></div>
            </div>
            <div class="servers_block scroll no-scrollbar">
                <?php for ($i_server = 0; $i_server < $General->server_list_count; $i_server++) : ?>
                    <div class="server_block">
                        <div class="server_map_image">
                            <img class="map" ondrag="return false" ondragstart="return false" id="server-map-image-<?= $i_server ?>" src="<?= $General->arr_general['site'] ?>storage/cache/img/maps/730/-.jpg" alt="" title="">
                        </div>
                        <div class="server_info_block">
                            <svg class="online_bar" width="50px" height="10px" viewBox="0 0 120 37">
                                <path d="M 5 10 L 100 10" stroke="var(--modal-bg)" stroke-width="20" fill-opacity="0" stroke-linecap="round"></path>
                                <path id="server-stroke-<?= $i_server ?>" d="M 5 10 L 100 10" stroke="var(--stroke-color)" stroke-width="20" fill-opacity="0" stroke-linecap="round"></path>
                            </svg>
                            <div class="server_left_block">
                                <div class="server_players_block">
                                    <div id="server-players-<?= $i_server ?>">-/-</div>
                                    <span><?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Monitoring_Players') ?></span>
                                </div>
                                <div class="partition"></div>
                                <div class="server_name_map_content">
                                    <div class="server_name_custom" id="server-name-<?= $i_server ?>">-</div>
                                    <div class="server_map_name" id="server-map-<?= $i_server ?>"><?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Loading') ?></div>
                                </div>
                            </div>
                            <div class="server_right_block">
                                
                                <?php if (file_exists(MODULES . 'module_page_playerlist/description.json')) : ?>
                                    <a class="server_button btn-clipboard" href="/srvPlayers/?sid=<?= $i_server+1 ?>" title="" data-tippy-content="Просмотр игроков" data-tippy-placement="left">
                                        <svg viewBox="0 0 384 512">
                                            <path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                        </svg>
                                    </a>
                                <?php endif; ?>
                                <button class="server_button btn-clipboard copybtn3" id="copy_btn_<?= $i_server ?>" data-clipboard-text="" data-tippy-content="<?= $Translate->get_translate_phrase('_TakeIp') ?>" data-tippy-placement="left" title="">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z" />
                                    </svg>
                                </button>
                                <a class="server_button play" id="play_btn_<?= $i_server ?>" href="" title="">
                                    <svg viewBox="0 0 384 512">
                                        <path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>
<div id="server-players-online" class="modal-window-server modal_players_online">
    <div class="modal-card">
        <div class="modal-card__header">
            <a title="" onclick="close_modal(id)" href="javascript:void(0);" class="modal-btn__close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
                </svg>
            </a>
            <div class="cover server-modal__bg">
                <img ondrag="return false" ondragstart="return false" id="server-map-image-modal" src="<?= $General->arr_general['site'] ?>storage/cache/img/maps/730/-.jpg" alt="" title="">
                <div class="shadow"></div>
            </div>
            <div class="server-modal__header">
                <img class="map_pins" ondrag="return false" ondragstart="return false" id="server-map-pin" src="<?= $General->arr_general['site'] ?>storage/cache/img/pins/maps/_.png" alt="" title="">
                <div class="map_name_block">
                    <div class="server_map_now_play_text">
                        <?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_CurrentMapPlay') ?>
                    </div>
                    <div class="server_map_name_second" id="server-maptwo">
                        <?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Loading') ?>
                    </div>
                </div>
                <div class="server_map_score">
                    <img class="server_map_score_t_img" src="<?= $General->arr_general['site'] ?>app/modules/module_block_main_monitoring_rating/assets/img/t.png" alt="" title="">
                    <div class="server_map_score_ct_t" id="server-map22"><?= $info[$i_server]['Score'] ?></div>
                    <img class="server_map_score_ct_img" src="<?= $General->arr_general['site'] ?>app/modules/module_block_main_monitoring_rating/assets/img/ct.png" alt="" title="">
                </div>
            </div>
        </div>
        <div class="mon_header" id="mon_header">
            <span class="mon_player_name">
                <svg viewBox="0 0 448 512">
                    <path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                </svg>
                <?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Player') ?>
            </span>
            <span class='big'>
                <svg class='center' viewBox="0 0 640 512" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Level') ?>" data-tippy-placement="top">
                    <path d="M353.8 54.1L330.2 6.3c-3.9-8.3-16.1-8.6-20.4 0L286.2 54.1l-52.3 7.5c-9.3 1.4-13.3 12.9-6.4 19.8l38 37-9 52.1c-1.4 9.3 8.2 16.5 16.8 12.2l46.9-24.8 46.6 24.4c8.6 4.3 18.3-2.9 16.8-12.2l-9-52.1 38-36.6c6.8-6.8 2.9-18.3-6.4-19.8l-52.3-7.5zM256 256c-17.7 0-32 14.3-32 32V480c0 17.7 14.3 32 32 32H384c17.7 0 32-14.3 32-32V288c0-17.7-14.3-32-32-32H256zM32 320c-17.7 0-32 14.3-32 32V480c0 17.7 14.3 32 32 32H160c17.7 0 32-14.3 32-32V352c0-17.7-14.3-32-32-32H32zm416 96v64c0 17.7 14.3 32 32 32H608c17.7 0 32-14.3 32-32V416c0-17.7-14.3-32-32-32H480c-17.7 0-32 14.3-32 32z" />
                </svg>
            </span>
            <span class='size_modal_block'>
                <svg class='center' viewBox="0 0 512 512" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Kills') ?>" data-tippy-placement="top">
                    <path d="M559.7 392.2l-135.1 99.52C406.9 504.8 385 512 362.1 512H15.1C7.251 512 0 504.8 0 496v-95.98C0 391.3 7.251 383.1 15.1 383.1l55.37 .0241l46.5-37.74c20.1-17 47.12-26.25 74.12-26.25h159.1c19.5 0 34.87 17.38 31.62 37.38c-2.623 15.74-17.37 26.62-33.37 26.62H271.1c-8.748 0-15.1 7.25-15.1 16c0 8.742 7.25 15.99 15.1 15.99h120.6l119.7-88.17c17.79-13.19 42.81-9.344 55.93 8.469C581.3 354.1 577.5 379.1 559.7 392.2z" />
                    <path d="M432 127.1C432 57.25 367.5 0 288 0C208.5 0 143.1 57.25 143.1 127.1c0 46.5 28.24 86.88 69.1 109.3l-5.5 25.88C205.9 275.8 213.1 288 224.1 288h126c11.13 0 19.13-12.25 16.5-24.88l-5.501-25.88C403.8 214.9 432 174.5 432 127.1zM231.1 176c-17.63 0-32.01-14.38-32.01-32s14.38-32 32.01-32c17.63 0 32 14.38 32 32S249.6 176 231.1 176zM344 176c-17.63 0-32.01-14.38-32.01-32s14.38-32 32.01-32c17.63 0 32 14.38 32 32S361.6 176 344 176z" />
                </svg>
            </span>
            <span id='a_title' style="display: none" class='size_modal_block'>
                <svg class='center' viewBox="0 0 640 512" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Assists') ?>" data-tippy-placement="top">
                    <path d="M543.9 251.4c0-1.1 .1-2.2 .1-3.4c0-48.6-39.4-88-88-88l-40 0H320l-16 0 0 0v16 72c0 22.1-17.9 40-40 40s-40-17.9-40-40V128h.4c4-36 34.5-64 71.6-64H408c2.8 0 5.6 .2 8.3 .5l40.1-40.1c21.9-21.9 57.3-21.9 79.2 0l78.1 78.1c21.9 21.9 21.9 57.3 0 79.2l-69.7 69.7zM192 128V248c0 39.8 32.2 72 72 72s72-32.2 72-72V192h80l40 0c30.9 0 56 25.1 56 56c0 27.2-19.4 49.9-45.2 55c8.2 8.6 13.2 20.2 13.2 33c0 26.5-21.5 48-48 48h-2.7c1.8 5 2.7 10.4 2.7 16c0 26.5-21.5 48-48 48H224c-.9 0-1.8 0-2.7-.1l-37.7 37.7c-21.9 21.9-57.3 21.9-79.2 0L26.3 407.6c-21.9-21.9-21.9-57.3 0-79.2L96 258.7V224c0-53 43-96 96-96z" />
                </svg>
            </span>
            <span class='size_modal_block'>
                <svg class='center' viewBox="0 0 512 512" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Death') ?>" data-tippy-placement="top">
                    <path d="M416 398.9c58.5-41.1 96-104.1 96-174.9C512 100.3 397.4 0 256 0S0 100.3 0 224c0 70.7 37.5 133.8 96 174.9c0 .4 0 .7 0 1.1v64c0 26.5 21.5 48 48 48h48V464c0-8.8 7.2-16 16-16s16 7.2 16 16v48h64V464c0-8.8 7.2-16 16-16s16 7.2 16 16v48h48c26.5 0 48-21.5 48-48V400c0-.4 0-.7 0-1.1zM224 256c0 35.3-28.7 64-64 64s-64-28.7-64-64s28.7-64 64-64s64 28.7 64 64zm128 64c-35.3 0-64-28.7-64-64s28.7-64 64-64s64 28.7 64 64s-28.7 64-64 64z" />
                </svg>
            </span>
            <span id='kd_title' style="display: none" class='size_modal_block'>
                <svg class='center' viewBox="0 0 512 512" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_KD') ?>" data-tippy-placement="top">
                    <path d="M256 0c17.7 0 32 14.3 32 32V42.4c93.7 13.9 167.7 88 181.6 181.6H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H469.6c-13.9 93.7-88 167.7-181.6 181.6V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V469.6C130.3 455.7 56.3 381.7 42.4 288H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H42.4C56.3 130.3 130.3 56.3 224 42.4V32c0-17.7 14.3-32 32-32zM107.4 288c12.5 58.3 58.4 104.1 116.6 116.6V384c0-17.7 14.3-32 32-32s32 14.3 32 32v20.6c58.3-12.5 104.1-58.4 116.6-116.6H384c-17.7 0-32-14.3-32-32s14.3-32 32-32h20.6C392.1 165.7 346.3 119.9 288 107.4V128c0 17.7-14.3 32-32 32s-32-14.3-32-32V107.4C165.7 119.9 119.9 165.7 107.4 224H128c17.7 0 32 14.3 32 32s-14.3 32-32 32H107.4zM256 288c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32z" />
                </svg>
            </span>
            <span id='hs_title' style="display: none" class='size_modal_block'>
                <svg class='center' viewBox="0 0 512 512" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Headshots') ?>" data-tippy-placement="top">
                    <path d="M120 159.6c40 0 40 0 40 0c17.67 0 31.1 14.29 31.1 31.92c0 9.961-4.848 18.5-12.01 24.35c6.297-2.903 13.05-4.754 20.01-4.754c8.34 0 16.58 2.18 23.81 6.307l32.19 18.35l32.19-18.35c7.24-4.129 15.48-6.309 23.82-6.309c6.959 0 13.71 1.849 20.01 4.75c-7.162-5.855-12.01-14.39-12.01-24.35c0-17.63 14.33-31.92 32-31.92c0 0-.0001 0 40 0c30.93 0 55.1-24.93 55.1-55.79s-25.07-55.91-56-55.91c-9.031 0-17.44 2.339-24.99 6.127C362.2 23.49 335.1 0 304 0c-19.22 0-36.27 8.649-48 22.04C244.3 8.649 227.2 0 208 0C176 0 149.8 23.49 144.1 54.05C137.4 50.26 129 47.92 120 47.92c-30.93 0-56 25.06-56 55.91S89.07 159.6 120 159.6zM511.9 254.4l-16.06 9.098c-9.838 5.608-21.92 5.608-31.75 0l-32.19-18.35c-4.918-2.804-10.96-2.804-15.88 0l-32.19 18.35c-9.838 5.61-21.92 5.61-31.75 0l-32.19-18.35c-4.918-2.804-10.96-2.804-15.88 0l-32.19 18.35c-9.838 5.61-21.92 5.61-31.75 0L207.9 245.2c-4.918-2.804-10.96-2.804-15.88 0L159.9 263.5c-9.838 5.61-21.92 5.61-31.75 0L95.94 245.2c-4.918-2.804-10.96-2.804-15.88 0L47.88 263.5c-9.836 5.608-21.91 5.608-31.75 0L.0605 254.4c-.0547 .0312 .0547-.0331 0 0C-1.115 396.5 113.9 512 256 512S513.1 396.5 511.9 254.4C511.9 254.4 511.1 254.5 511.9 254.4zM143.1 336.4c0-17.71 14.29-31.92 31.97-31.92c17.8 0 32.09 14.22 32.09 31.92c0 17.71-14.29 31.92-32.09 31.92C158.3 368.3 143.1 354.1 143.1 336.4zM304 446.9H208c-8.836 0-15.1-7.147-15.1-15.96c0-26.45 21.49-47.89 47.1-47.89h32c26.51 0 48 21.44 48 47.89C320 439.8 312.8 446.9 304 446.9zM336 368.3c-17.8 0-32.09-14.22-32.09-31.92c0-17.71 14.29-31.92 32.09-31.92c17.68 0 31.97 14.22 31.97 31.92C368 354.1 353.7 368.3 336 368.3z" />
                </svg>
            </span>
            <span id='hsp_title' style="display: none" class='size_modal_block'>
                <svg class='center' viewBox="0 0 512 512" data-tippy-content="%<?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Headshots') ?>" data-tippy-placement="top">
                    <path d="M512 256c0-37.7-23.7-69.9-57.1-82.4 14.7-32.4 8.8-71.9-17.9-98.6-26.7-26.7-66.2-32.6-98.6-17.9C325.9 23.7 293.7 0 256 0s-69.9 23.7-82.4 57.1c-32.4-14.7-72-8.8-98.6 17.9-26.7 26.7-32.6 66.2-17.9 98.6C23.7 186.1 0 218.3 0 256s23.7 69.9 57.1 82.4c-14.7 32.4-8.8 72 17.9 98.6 26.6 26.6 66.1 32.7 98.6 17.9 12.5 33.3 44.7 57.1 82.4 57.1s69.9-23.7 82.4-57.1c32.6 14.8 72 8.7 98.6-17.9 26.7-26.7 32.6-66.2 17.9-98.6 33.4-12.5 57.1-44.7 57.1-82.4zm-320-96c17.67 0 32 14.33 32 32s-14.33 32-32 32-32-14.33-32-32 14.33-32 32-32zm12.28 181.65c-6.25 6.25-16.38 6.25-22.63 0l-11.31-11.31c-6.25-6.25-6.25-16.38 0-22.63l137.37-137.37c6.25-6.25 16.38-6.25 22.63 0l11.31 11.31c6.25 6.25 6.25 16.38 0 22.63L204.28 341.65zM320 352c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32z" />
                </svg>
            </span>
            <span class='big'>
                <svg class='center' viewBox="0 0 512 512" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Play_time') ?>" data-tippy-placement="top">
                    <path d="M256 512C114.6 512 0 397.4 0 256S114.6 0 256 0S512 114.6 512 256s-114.6 256-256 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                </svg>
            </span>
        </div>
        <ul class="mon_list_body mon_list_scroll no-scrollbar" id="players_online"></ul>
        <div class="modal-card_footer" id="modal-card-footer">
            <a class="modal-btn" id = 'fullstats' onChange="window.location.href=this.value"><?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Detailed') ?></a>
            <a class="modal-btn" id = 'hidestats' style="display: none" onChange="window.location.href=this.value"><?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Hide') ?></a>
            <div class="modal-card__footer">
                <a class="modal-btn_copy btn-clipboard copybtn3" id="copy_btnsecond" data-clipboard-text="">
                    <svg viewBox="0 0 512 512">
                        <path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z" />
                    </svg>
                    <?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_TakeIp') ?>
                </a>
                <a class="modal-btn" id="connect_server">
                    <svg viewBox="0 0 496 512">
                        <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.79 52.79 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3.1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z" />
                    </svg>
                    <?= $Translate->get_translate_module_phrase('module_block_main_monitoring_rating', '_Connect') ?>
                </a>
            </div>
        </div>
    </div>
</div>