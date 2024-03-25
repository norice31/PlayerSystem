let minplayers = 0,
    maxplayers = 0,
    info, players;

let cachedata;

if (servers != 0) {
    $.ajax({
        type: 'POST',
        url: domain + "app/modules/module_block_main_monitoring_rating/includes/js_controller.php",
        data: ({
            data: servers,
            my: "yes"
        }),
        dataType: 'json',
        global: false,
        async: true,
        success: function (data) {
            for (var i = 0; i < data.length; i++) {
                info = data[i];
                cachedata = data;
                minplayers += info['Players'];
                maxplayers += info['MaxPlayers'];
                document.getElementById('server-name-' + i).innerHTML = info['HostName'];
                document.getElementById('server-map-image-' + i).setAttribute("src", domain + "storage/cache/img/maps/" + data[i]['Mod'] + "/" + info['Map_image'] + ".jpg");
                document.getElementById('server-players-' + i).innerHTML = info['Players'] + "/" + info['MaxPlayers'];
                document.getElementById('server-map-' + i).innerHTML = info['Map'];

                document.getElementById('copy_btn_' + i).setAttribute("data-clipboard-text", info['ip']);
                document.getElementById('play_btn_' + i).setAttribute("href", "steam://connect/"+info['ip']+"/");

                let delenie = info["Players"] / info["MaxPlayers"];
                let formula = 100 - ((delenie) * 100);
                document.getElementById("server-stroke-" + i).setAttribute("style", "stroke-dasharray: 100, 100; stroke-dashoffset: " + formula + ";");

                if (delenie <= 0.5)
                    document.getElementById("server-stroke-" + i).setAttribute("stroke", "var(--green-color)");
                else if (delenie <= 0.8)
                    document.getElementById("server-stroke-" + i).setAttribute("stroke", "var(--orange-color)");
                else if (delenie <= 1)
                    document.getElementById("server-stroke-" + i).setAttribute("stroke", "var(--red-color)");
            }
            document.getElementById('min_players').innerHTML = minplayers;
            document.getElementById('max_players').innerHTML = maxplayers;
        }
    });

    function get_players_data(i) {
        var modal = document.getElementById('server-players-online');
        update_info(i);
        $(modal).addClass('modal_show')
    }

    function close_modal(i) {
        var modal = document.getElementById('server-players-online');
        document.getElementById('players_server').remove();
        $(modal).removeClass('modal_show')
        if (document.getElementById("refresh_button") !== null) document.getElementById('refresh_button').remove();
        $('body, html').removeClass('hidescroll');
    }

    window.addEventListener("click", (e) => {
        if (event.target === document.querySelector(".modal_show")) {
            document.getElementById('players_server').remove();
            if (document.getElementById("refresh_button") !== null) document.getElementById('refresh_button').remove();
            $(".modal_show").removeClass("modal_show");
            $('body, html').removeClass('hidescroll');
        }
    });
};

function update_info(server_id) {
    info = cachedata[server_id];
    if (document.getElementById("refresh_button") !== null) document.getElementById("refresh_button");
    if (document.getElementById("players_server") !== null) document.getElementById('players_server').remove();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: domain + "app/modules/module_block_main_monitoring_rating/ext/js_controller.php",
        data: {
            ip: info['ip']
        },
        success: function (result) {
            players = result;
            document.getElementById('server-map-image-modal').setAttribute("src", domain + "storage/cache/img/maps/" + info['Mod'] + "/" + info['Map_image'] + ".jpg");
            document.getElementById('server-map-pin').setAttribute("src", domain + "storage/cache/img/pins/maps/" + info['Map_Pin'] + ".png");

            document.getElementById('copy_btn_' + server_id).setAttribute("data-clipboard-text", info['ip']);
            document.getElementById('copy_btnsecond').setAttribute("data-clipboard-text", info['ip']);

            document.getElementById('server-players-' + server_id).innerHTML = info['Players'] + "/" + info['MaxPlayers'];

            let map_name = info['Map'];
            let clipped_map_name = map_name.substring(map_name.search('_') + 1, map_name.length);

            document.getElementById('server-maptwo').innerHTML = clipped_map_name;
            var scoreCT = players[0]['score_ct'];
            var scoreT = players[0]['score_t'];
            var scoreElement = document.getElementById("server-map22");
            scoreElement.innerHTML = `<span style="color: var(--t-color);">${scoreCT}</span> : <span style="color: var(--ct-color);">${scoreT}</span>`;
            var sdiv = '<div id = "players_server">';
            if (players) {
                if (players.length > 1) {
                    for (var i2 = 1; i2 < players.length; i2++) {
                        var KD = "0";
                        var HD = "0";
                        if (Number(players[i2]['Frags']) > 0 && Number(players[i2]['Death']) > 0) {
                            KD = (Number(players[i2]['Frags']) / Number(players[i2]['Death'])).toFixed(1);
                        }
                        if (Number(players[i2]['Frags']) > 0 && Number(players[i2]['Headshots']) > 0) {
                            HD = ((Number(players[i2]['Headshots']) / Number(players[i2]['Frags'])) * 100).toFixed(1);
                        }
                        var str = '<li class="hover_mon">' +
                            '<span class="mon_player_name"> <a href=\"profiles/' + players[i2]['SteamID'] + "/" + server_id + "\">" + players[i2]['Name'].replace(/[\u00A0-\u9999<>\&]/g, function (i) {
                                return '&#' + i.charCodeAt(0) + ';';
                            }) + '</a></span>' +
                            '<span class="big"><img class="manImg" height=20 src=\"' + domain + '/storage/cache/img/ranks/' + info["Rank_Pack"] + '/' + players[i2]['rank'] + '.svg\"></img></span>' +
                            '<span class = "size_modal_block">' + players[i2]['Frags'] + '</span>' +

                            '<span class = "modal-stats" style="display: none" class = "size_modal_block">' + players[i2]['Assist'] + '</span>' +
                            '<span class = "size_modal_block">' + players[i2]['Death'] + '</span>' +
                            '<span class = "modal-stats" style="display: none" class = "size_modal_block">' + KD + '</span>' +
                            '<span class = "modal-stats" style="display: none" class = "size_modal_block">' + players[i2]['Headshots'] + '</span>' +
                            '<span class = "modal-stats" style="display: none" class = "size_modal_block">' + HD + '\%</span>' +
                            '<span class = "big">' + fancyTimeFormat(players[i2]['PlayTime']) + '</span>' +
                            '</li>';
                        sdiv += str;
                    }
                    document.getElementById('fullstats').style.display = 'flex';
                    document.getElementById('hidestats').style.display = 'none';

                    document.getElementById('a_title').style.display = 'none';
                    document.getElementById('kd_title').style.display = 'none';
                    document.getElementById('hs_title').style.display = 'none';
                    document.getElementById('hsp_title').style.display = 'none';
                    document.getElementById('mon_header').style.display = 'grid';
                    document.getElementById('modal-card-footer').style.paddingTop = '5px';
                    const stats = document.getElementsByClassName('modal-stats');
                    for (let index = 0; index < stats.length; index++) {
                        stats[index].style.display = 'none';
                    };
                    const mcs = document.getElementsByClassName('modal-card');
                    for (let index = 0; index < mcs.length; index++) {
                        mcs[index].style.width = "420px";
                    };
                    const boxes = document.querySelectorAll('.size_modal_block');
                    boxes.forEach(box => {
                        box.style.width = '60px';
                    });
                    document.getElementById('connect_server').setAttribute("href", "steam://connect/" + info['ip']);
                } else {
                    document.getElementById('fullstats').style.display = 'none';
                    document.getElementById('mon_header').style.display = 'none';
                    document.getElementById('modal-card-footer').style.paddingTop = '0';
                    var str = '<div class="map_server_no_players_block">' +
                    '<svg viewBox="0 0 512 512"><path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zm240 80c0-8.8 7.2-16 16-16c45 0 85.6 20.5 115.7 53.1c6 6.5 5.6 16.6-.9 22.6s-16.6 5.6-22.6-.9c-25-27.1-57.4-42.9-92.3-42.9c-8.8 0-16-7.2-16-16zm-80 80c-26.5 0-48-21-48-47c0-20 28.6-60.4 41.6-77.7c3.2-4.4 9.6-4.4 12.8 0C179.6 308.6 208 349 208 369c0 26-21.5 47-48 47zM367.6 208a32 32 0 1 1 -64 0 32 32 0 1 1 64 0zm-192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>' +
                    '<div class="map_server_no_players_text">Увы, но сервер пуст!</div>'
                    '</div>';
                    sdiv += str;
                    document.getElementById('connect_server').setAttribute("href", "steam://connect/" + info['ip']);
                }
            }
            sdiv += "</div>";
            po = document.getElementById('players_online');
            po.insertAdjacentHTML('beforeend', sdiv);

            if (document.getElementById("refresh_button") == null) {
                refresh = document.getElementsByClassName('modal-card__header');
                refresh[0].insertAdjacentHTML('beforeend', '<a id = "refresh_button" onclick="update_info(' + server_id + ')" href="javascript:void(0);" class="modal-refresh"><svg viewBox="0 0 512 512"><path d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H463.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V448c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352H176c17.7 0 32-14.3 32-32s-14.3-32-32-32H48.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z" /></svg></a>');
            } else document.getElementById("refresh_button").style.display = 'block';
        }
    });
}

function fancyTimeFormat(duration) {
    const hrs = ~~(duration / 3600);
    const mins = ~~((duration % 3600) / 60);
    const secs = ~~duration % 60;
    let ret = "";

    if (hrs > 0) {
        ret += "" + hrs + ":" + (mins < 10 ? "0" : "");
    }

    ret += "" + mins + ":" + (secs < 10 ? "0" : "");
    ret += "" + secs;

    return ret;
}

var copyip = new ClipboardJS('.copybtn3');
copyip.on('success', function (e) {
    noty('Адрес Скопирован', 'success', '/storage/assets/sounds/copy.mp3', 0.2);
    e.clearSelection();
});

$('.play').click(function (event) {
    $('body,html').addClass('hidescroll');
});

$("#fullstats").click(function () {
    $("#fullstats").hide();
    $("#hidestats").show();
    $("#a_title").show();
    $("#kd_title").show();
    $("#hs_title").show();
    $("#hsp_title").show();
    const stats = document.getElementsByClassName('modal-stats');
    for (let index = 0; index < stats.length; index++) {
        stats[index].style.display = 'block';
    };
    const mcs = document.getElementsByClassName('modal-card');
    for (let index = 0; index < mcs.length; index++) {
        mcs[index].style.width = "600px";
    };
    const boxes = document.querySelectorAll('.size_modal_block');
    boxes.forEach(box => {
        box.style.width = '40px';
    });
});

$("#hidestats").click(function () {
    $("#hidestats").hide();
    $("#fullstats").show();
    $("#a_title").hide();
    $("#kd_title").hide();
    $("#hs_title").hide();
    $("#hsp_title").hide();
    const stats = document.getElementsByClassName('modal-stats');
    for (let index = 0; index < stats.length; index++) {
        stats[index].style.display = 'none';
    };
    const mcs = document.getElementsByClassName('modal-card');
    for (let index = 0; index < mcs.length; index++) {
        mcs[index].style.width = "420px";
    };
    const boxes = document.querySelectorAll('.size_modal_block');
    boxes.forEach(box => {
        box.style.width = '60px';
    });
});