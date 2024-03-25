$(document).ready(function () {
    sid = new URLSearchParams(window.location.search).get("sid");
    $.ajax({
        type: 'POST',
        url: '/srvPlayers/?getplayers=' + sid,
        cache: false,
        success: function (result) {
            result = $.parseJSON(result);

            $("#list_server_to_gags").html('');
            $("#list_server_to_logs").html('');

            $.each(result.players, (i, player) => {
                i = (i + 1);
                $("#list_server_to_gags").append('\
                    <li class="hover_lbam" id="plrow" data-uid="' + player.userid + '">\
                        <span>' + i + '</span>\
                        <span ' + player.steam + '>\
                            <a href="/profiles/' + player.steam + '/' + result.sid + '/">' + player.name + '</a>\
                        </span>\
                        <span data-livestamp="' + player.entry_tile + '"></span>\
                        <span style="row" id="admbtn">\
                            <div id="kick-btn" class="button_admin_right popup-open" style="padding: 20px;font-size: 14px;" data-sid="' + player.server_id + '" data-uid="' + player.userid + '">Кик</div>\
                            <div id="ban-btn" class="button_admin_right" style="padding: 20px;font-size: 14px;" data-sid="' + player.server_id + '" data-uid="' + player.userid + '">Бан</div>\
                        </span>\
                    </li>\
                ');
            });

            if (result.adm != 1) {
                $("[id=admbtn]").css("display", "none");
                $("[id=admbt]").css("display", "none");
                $("[class=last_bans_comms_header_muts]").css("grid-template-columns", "repeat(3, 1fr)");
                $("[id=plrow]").css("grid-template-columns", "repeat(3, 1fr)");
            }

            $.each(result.logs, (i, log) => {
                $("#list_server_to_logs").append('\
                    <li class="hover_lbam">\
                        <span>\
                            ' + log.date + '\
                        </span>\
                        <span ' + log.steam1 + '>\
                            <a href="/profiles/' + log.steam1 + '/' + result.sid + '/">' + log.name1 + '</a>\
                        </span>\
                        <span>\
                            ' + log.text + '\
                        </span>\
                        <span ' + log.steam2 + '>\
                            <a href="/profiles/' + log.steam2 + '/' + result.sid + '/">' + log.name2 + '</a>\
                        </span>\
                    </li>\
                ');
            });

            $('[id=ban-btn]').click(function () {
                $('[id=inf][name=uid]').val($(this).attr('data-uid'));
                $('[id=inf][name=sid]').val($(this).attr('data-sid'));
                $('.popup').fadeIn();
                return false;
            });

            $('.popup-close').click(function () {
                $(this).parents('.popup').fadeOut();
                return false;
            });

            $('[id=ban-submit]').click(function () {
                $.ajax({
                    type: 'POST',
                    url: '/srvPlayers/?ban&sid=' + $("[id=inf][name=sid]").val() + '&uid=' + $("[id=inf][name=uid]").val() + '&reason=' + $("[id=inf][name=reason]").val() + '&expires=' + $("[id=expires]").val(),
                    cache: false,
                    success: function (result) {
                        result = $.parseJSON(result);
                        if (result.error) {
                            noty('У вас нет прав!', 'error');
                        } else {
                            noty('Игрок успешно забанен!', 'success');
                            $("[id=plrow][data-uid=" + $("[id=inf][name=uid]").val() + "]").css("display", "none");
                        }
                        $('.popup').fadeOut();
                    },
                });
            });

            $('[id=kick-btn]').click(function () {
                uid = $(this).attr('data-uid');
                $.ajax({
                    type: 'POST',
                    url: '/srvPlayers/?kick&sid=' + $(this).attr('data-sid') + '&uid=' + $(this).attr('data-uid'),
                    cache: false,
                    success: function (result) {
                        result = $.parseJSON(result);
                        if (result.error == 1) {
                            noty(result.error, 'error');
                        } else if (result.error == 2) {
                            noty('Игрока нет на сервере!', 'error');
                            $("[id=plrow][data-uid=" + uid + "]").css("display", "none");
                        } else {
                            noty('Игрок выгнан с сервера!', 'success');
                            $("[id=plrow][data-uid=" + uid + "]").css("display", "none");
                        }
                    },
                });
            });
        },
    });

    $('[id=changeadmin]').on('change', function () {
        $.ajax({
            type: 'POST',
            url: '/srvPlayers/?settings=admin',
            cache: false,
            success: function (result) {
                result = $.parseJSON(result);
                if (result.error) {
                    noty('У вас нет прав!', 'error');
                } else {
                    noty('Успех!', 'success');
                }
            },
        });
    });

    $('[id=changetypeban1]').on('change', function () {
        $.ajax({
            type: 'POST',
            url: '/srvPlayers/?settings=' + $(this).attr('name'),
            cache: false,
            success: function (result) {
                result = $.parseJSON(result);
                if (result.error) {
                    noty('У вас нет прав!', 'error');
                } else {
                    noty('Успех!', 'success');
                }
            },
        });
    });

    $('[id=changetypeban2]').on('change', function () {
        $.ajax({
            type: 'POST',
            url: '/srvPlayers/?settings=' + $(this).attr('name'),
            cache: false,
            success: function (result) {
                result = $.parseJSON(result);
                if (result.error) {
                    noty('У вас нет прав!', 'error');
                } else {
                    noty('Успех!', 'success');
                }
            },
        });
    });
});
