/*********************************************************************
* #### jQuery File Browser Awesome v0.2.0 ####
* Coded by Ican Bachors 2014.
* http://ibacor.com/labs/jquery-file-browser-awesome/
* Updates will be posted to this site.
*********************************************************************/

var fba = function(g) {
    if (g.host != undefined && g.api != undefined && g.route != undefined && g.host != '' && g.api != '' && g.route != '') {
        var j = '<div class="fba_direktori"></div>' + '<div class="fba_read_file"><i class="fas fa-code text-primary me-1"></i> <span id="rf"></span> <span id="perms"></span><button type="button" id="w_file" class="btn btn-xs btn-warning float-right" style="margin-top: -3px;">Save</button> </div>' + '<textarea id="fba_text"></textarea>',
            k = getParameterByName('path');
        $("#fba").html(j);
        if (k != '') {
            if (k.indexOf('.') === -1) {
                fba_direktori(k)
            } else {
                var l = k.substring(k.lastIndexOf('/') + 1),
                    gehu = k.replace('/' + l, "");
                fba_direktori(gehu);
                fba_file(k)
            }
        } else {
            fba_direktori("")
        }
        var h = CodeMirror.fromTextArea(document.getElementById("fba_text"), {
            mode: 'text/html',
            lineNumbers: true,
            autofocus: true,
            theme: 'monokai'
        });
    } else {
        alert('Options required.')
    }

    function fba_direktori(e) {
        $.ajax({
            type: "POST",
            url: g.host + g.api,
            data: 'path=' + e,
            crossDomain: true,
            dataType: "json"
        }).done(function(c) {
            if (c.status == 'success') {
                var r = "";
                r += '<div class="fba_header"><div class="name">Name</div><div class="size pe-3">Size</div><div class="modif pe-3">Last Modified</div></div>';

                if (e != "") {
                    var d = e.split('/'),
                        ee = [];
                    for (i = 0; i < d.length - 1; i++) {
                        ee.push(d[i])
                    }
                    var f = (d.length > 1 ? ee.join('/') : '');

                    r += '<div class="fba_root"><i class="bsub fas fa-level-up-alt btn btn-xs btn-success me-2 mb-1 px-3" data-bsub="' + f + '" title="Up"></i>' + e + "</div>"
                    r += '<div class="fba_body">';
                } else {
                    r += '<div class="fba_body">';
                }

                $.each(c.data, function(i, a) {
                    if (c.data[i].type == "dir") {
                        r += '<div class="fba_content"><div class="name"><span class="sub fa" data-sub="' + c.data[i].path + '"><i class="fas fa-folder"></i> ' + c.data[i].name + '</span></div><div class="size">' + c.data[i].items + ' items</div><div class="modif">' + c.data[i].modif + '</div></div>'
                    } else {
                        var b = fba_size(c.data[i].size);
                        var s = c.data[i].path.substr(c.data[i].path.lastIndexOf(".") + 1);
                        switch (s) {
                            case "html":
                            case "php":
                            case "js":
                            case "css":
                            case "txt":
                            case "md":
                            case "asp":
                            case "tpl":
                            case "aspx":
                            case "jsp":
                            case "py":
                                r += '<div class="fba_content"><div class="name"><span class="rfile fa" data-rfile="' + c.data[i].path + '"><i class="far fa-file text-dark me-1"></i> ' + c.data[i].name + '</span></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>';
                                break;
                            case "apk":
                                r += '<div class="fba_content"><div class="name"><a href="' + g.host + c.data[i].dir + '/' + c.data[i].path + '" target="_blank"><i class="fab fa-android text-warning me-1"></i> ' + c.data[i].name + '</a></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>'
                                break;
                            case "pdf":
                                r += '<div class="fba_content"><div class="name"><a href="' + g.host + c.data[i].dir + '/' + c.data[i].path + '" target="_blank"><i class="far fa-file-pdf text-danger me-1"></i> ' + c.data[i].name + '</a></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>'
                                break;
                            case "jpg":
                            case "JPG":
                            case "jpeg":
                            case "JPEG":
                            case "gif":
                            case "GIF":
                            case "png":
                            case "PNG":
                            case "bmp":
                            case "BMP":
                                r += '<div class="fba_content"><div class="name"><a href="' + g.host + c.data[i].dir + '/' + c.data[i].path + '" target="_blank"><i class="fas fa-file-image text-primary me-1"></i> ' + c.data[i].name + '</a></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>'
                                break;
                            default:
                                r += '<div class="fba_content"><div class="name"><a href="' + g.host + c.data[i].dir + '/' + c.data[i].path + '" target="_blank"><i class="fas fa-download text-secondary me-1"></i> ' + c.data[i].name + '</a></div><div class="size">' + b + '</div><div class="modif">' + c.data[i].modif + '</div></div>'
                        }
                    }
                });
                r += "</div>";
                $(".fba_direktori").html(r);
                $(".sub").click(function() {
                    var t = $(this).data("sub");
                    fba_direktori(t);

                    h.setValue("");
                    $("#rf").html("");
                    $("#perms").html("");

                    window.history.pushState(null, null, g.route + "&path=" + t);
                    return false
                });
                $(".bsub").click(function() {
                    var t = $(this).data("bsub");
                    fba_direktori(t);

                    h.setValue("");
                    $("#rf").html("");
                    $("#perms").html("");

                    window.history.pushState(null, null, g.route + "&path=" + t);
                    return false
                });
                $(".rfile").click(function() {
                    var a = $(this).data("rfile");
                    fba_file(a);
                    window.history.pushState(null, null, g.route + "&path=" + a);
                    return false
                })
            }
        })
    }

    function fba_file(c) {
        $.ajax({
            type: "POST",
            url: g.host + g.api,
            data: 'file=' + c,
            //crossDomain: true,
            dataType: "json"
        }).done(function(a) {
            if (a.status == 'success') {
                $("#rf").html(c);
                $("#perms").html(" [" + a.perms + "]");
                h.setValue(a.text);
            }
        })
    }

    $("#w_file").click(function() {
        var wfile = $("#rf").html();
        var content = h.getValue();
        if (wfile == undefined || content == undefined || wfile == '' || content == '') {
            $.notify("Please input data", {'type': 'danger'});
            return false;
        }
        $.ajax({
            type: "POST",
            url: g.host + g.api,
            data: 'wfile=' + wfile + '&content=' + content,
            dataType: "json",
            beforeSend: function () {
                $("#w_file").html('Save ' + '<i class="fas fa-spinner fa-spin"></i>');
            },
            complete: function () {
                setTimeout(function() {
                    $("#w_file").html('Save');
                }, 800);
            },
        }).done(function(a) {
            if (a.status == 'error') {
                $.notify(a.msg, {'type': 'danger'});
            }

            $.notify("Saved");
        })
    });

    function fba_size(e) {
        var t = ["Bytes", "KB", "MB", "GB", "TB"];
        if (e == 0) return "0 Bytes";
        var n = parseInt(Math.floor(Math.log(e) / Math.log(1024)));
        return Math.round(e / Math.pow(1024, n), 2) + " " + t[n]
    }

    function getParameterByName(a) {
        a = a.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var b = new RegExp("[\\?&]" + a + "=([^&#]*)"),
            results = b.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "))
    }
}

$(function () {
    if ($("#fba").length) {
        fba({
            host: $("#fba").attr('data-host'), // your host / domain
            api: $("#fba").attr('data-api'), // controllers name fba api
            route: $("#fba").attr('data-route') // controllers name fba api
        });
    }
});
