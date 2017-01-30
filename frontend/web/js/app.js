$(document).ready(function () {

    var sponsorCount = $(".sponsor").length;
    var prizeCount = $(".prize").length;
    var conditionCount = $(".condition").length;

    var owl = $("#owl-best-projects");
    var owlSponsor = $("#sponsor-owl");

    var owlPage = 0;
    var owlCount = $("#owl-best-projects .item").length;

    if (owlCount > 5) {
        $("#carousel-next").show();
    }

    if (owlSponsor.length) {
        owlSponsor.owlCarousel({

            navigation: false,
            pagination: false,
            slideSpeed : 300,
            singleItem: true,
            autoPlay: 5000
        });
        $("#sponsor-right").click(function () {
            owlSponsor.trigger('owl.next');
            return false;
        });
        $("#sponsor-left").click(function () {
            owlSponsor.trigger('owl.prev');
            return false;
        });
    }

    owl.owlCarousel({

        navigation: false,
        pagination: false,
        rewindNav: false

    });
    $("#carousel-next").click(function () {
        owl.trigger('owl.next');
        owlPage++;
        if ((owlPage + 5) == owlCount) {
            $("#carousel-next").hide();
        }
        $("#carousel-prev").show();
    });
    $("#carousel-prev").click(function () {
        owl.trigger('owl.prev');
        owlPage--;
        $("#carousel-next").show();
        if (owlPage == 0) {
            $("#carousel-prev").hide();
        }
    });
    var ias;
    var myDropzone;

    if ($("div#image-upload").length) {
        var controller =  window.location.pathname.split('/')[1];
        var model = $("div#image-upload").data("model");
        var modelU = model.charAt(0).toUpperCase() + model.substr(1);;
        myDropzone = new Dropzone("div#image-upload", {
            url: "/file/upload?"+(controller == 'advert' ? "width=340&height=200" : ""),
            uploadMultiple: false,
            paramName: "File[uploadFile]",
            maxFiles: 1,
            maxFilesize: 5,
            acceptedFiles: "image/*",
            dictDefaultMessage: "<strong>Перетяните фото в формате .png или .jpg, или нажмите для выбора фото вручную</strong>Максимальный размер фото 5Мб<br/>",
            dictFileTooBig: "Файл слишком большого размера ({{filesize}}МБ). Максимальный размер: {{maxFilesize}}МБ.",
            // init: function() {
            //     this.on("error", function(file, progress) {
            //         console.log("File progress", this.options.maxFilesize);
            //         // if(this.maxFileSize);
            //     });
            // }
        });
        myDropzone.on("success", function (file, data) {
            var result = JSON.parse(data);
            // console.log(result);
            // console.log(data);
            $("#image-upload-error").html("");
            if (result.code == 1) {
                myDropzone.removeAllFiles();
                $("#image-upload-error").html("Изображение не подходит. Пожалуйста, выберите другое.");
                return;
            }
            $("#edit-image-preview").remove();
            $("#"+model+"-photo_file_id").val(result.result.id);
            $("#image-crop").html('<img src="' + result.result.url + '" id="image-canvas" />');
            $("#image-upload").hide();
            $("#image-crop-layer").show();
            var x2 = controller == 'competition' ? 636 : 220, y2 = controller == 'competition' ? 1000 : 127;
            var aspectRatio = controller == 'competition' ? '1:0.5' : '1:0.577272727';
            if (model == "post") {
                aspectRatio = controller == 'competition' ? '1:0.5' : '1:0.577272727';
                x2 = controller == 'competition' ? 636 : 220;
                y2 = controller == 'competition' ? 1000 : 127;
            }
            var html = '<input type="hidden" name="'+modelU+'[x1]" id="'+model+'_x1" value="0" />' +
                '<input type="hidden" name="'+modelU+'[x2]" id="'+model+'_x2" value="'+x2+'" />' +
                '<input type="hidden" name="'+modelU+'[y1]" id="'+model+'_y1" value="0" />' +
                '<input type="hidden" name="'+modelU+'[y2]" id="'+model+'_y2" value="'+y2+'" />';
            $("#form-create").append(html);
            ias = $('#image-canvas').imgAreaSelect({
                instance: true
            });


            ias.setOptions({
                x1: 0,
                y1: 0,
                x2: controller == 'competition' ? 200 : 172,
                y2: 100,
                aspectRatio: aspectRatio,
                persistent: true,
                handles: true,
                movable: true,
                show: true,
                onInit: function (img, selection) {
                    $('#'+model+'_x1').val(selection.x1);
                    $('#'+model+'_y1').val(selection.y1);
                    $('#'+model+'_x2').val(selection.x2);
                    $('#'+model+'_y2').val(selection.y2);
                },
                onSelectEnd: function (img, selection) {
                    $('#'+model+'_x1').val(selection.x1);
                    $('#'+model+'_y1').val(selection.y1);
                    $('#'+model+'_x2').val(selection.x2);
                    $('#'+model+'_y2').val(selection.y2);
                }
            });
            //ias.update();
        });
        myDropzone.on("sending", function (file, xhr, formData) {
            // Will send the filesize along with the file as POST data.
            formData.append("File[filesize]", file.size);
        });
    }



    $("#save-crop").click(function () {
        var controller =  window.location.pathname.split('/')[1];
        var x1 = $('#'+model+'_x1').val();
        var x2 = $('#'+model+'_x2').val();
        var values = {photo_file_id: $("#"+model+"-photo_file_id").val(),
            x1: $('#'+model+'_x1').val(),
            x2: $('#'+model+'_x2').val(),
            y1: $('#'+model+'_y1').val(),
            y2: $('#'+model+'_y2').val()};
        var obj = {};
        var maxWidth = controller == 'competition' ? 636 : 220;
        if (model == "post") {
            obj.Post = values;
            $("#label-advert-image").hide();
            $("#post-preview img").hide();
            maxWidth = controller == 'competition' ? 636 : 220;
        } else {
            obj.Competition = values;
        }
        console.log(obj);
        $.post("/"+model+"/save-image", obj, function (data) {
            console.log(data);
            if (data.code == 0) {
                ias.setOptions({show: false});
                ias.remove();
                $("#image-crop-layer").hide();
                $('#'+model+'_x1').remove();
                $('#'+model+'_y1').remove();
                $('#'+model+'_x2').remove();
                $('#'+model+'_y2').remove();
                $("#image-after-crop img").attr("src", data.result.url);
                $("#image-after-crop").show();

                var pos = $("#image-after-crop").position();
                var width = x2 - x1;
                if (width > maxWidth) {
                    width = maxWidth;
                }

                width = width + pos.left - 30;
                $("#delete-crop-image").css("left", width + 'px');
            }
        }, "json");
        return false;
    });
    $("#delete-crop-image").click(function () {
        myDropzone.removeAllFiles();
        $("#image-after-crop").hide();
        $("#"+model+"-photo_file_id").val("");
        $("#image-crop").html("");
        $("#post-preview img").show();
        $("#image-upload").show();
        return false;
    });

    $("#cancel-upload-image").click(function () {
        myDropzone.removeAllFiles();
        ias.setOptions({show: false});
        ias.remove();
        $("#image-crop-layer").hide();
        $("#image-after-crop").hide();
        $("#"+model+"-photo_file_id").val("");
        $("#image-crop").html("");
        $("#post-preview img").show();
        $("#image-upload").show();
        return false;

    });

    $("#competition-video_url").change(function () {
        var val = $(this).val();
        $.post("/competition/find-video", {url: val}, function (data) {
            if (data.code == 0) {
                $("#video-frame").html('<iframe width="280" height="157" src="https://www.youtube.com/embed/' + data.result.video + '" frameborder="0" allowfullscreen></iframe>');
            } else {
                $("#video-frame").html("");
            }
        }, "json");
    });

    $("#form-close #competition-video_url").keyup(function () {
        var val = $(this).val();
        $.post("/competition/find-video", {url: val}, function (data) {
            if (data.code == 0) {
                $("#video-frame").html('<iframe width="280" height="157" src="https://www.youtube.com/embed/' + data.result.video + '" frameborder="0" allowfullscreen></iframe>');
            } else {
                $("#video-frame").html("");
            }
        }, "json");
    });

    if ($("#delete-crop-image.image-exists").length) {
        var width = parseInt($("#delete-crop-image").data("width"));
        var pos = $("#image-after-crop").position();
        
        width = width + pos.left - 30;
        console.log(width);
        $("#delete-crop-image").css("left", width + 'px');
    }

    $("#add-sponsor").click(function () {
        sponsorCount++;
        var html = '<div class="sponsor row" id="sponsor-'+sponsorCount+'"><div class="col-md-11">' +
            '<div class="form-group field-competition-sponsor">' +
            '<label class="control-label">Спонсор <span>(если есть)</span></label>' +
            '<input type="text" maxlength="20" class="form-control" name="Sponsor[' + sponsorCount + '][name]" placeholder="Название организации, бренда">' +
            '</div>' +
            '<div class="form-group field-competition-sponsor">' +
            '<div class="form-group"><input type="text" class="form-control" name="Sponsor[' + sponsorCount + '][url]" placeholder="Ссылка на ресурс спонсора (не обязательно)"></div>' +
            '</div></div><div class="col-md-1">' +
            '<a href="#" class="btn-remove" data-id="'+sponsorCount+'"><i class="fa fa-minus" aria-hidden="true"></i></a>' +
            '</div></div>';
        $("#sponsor-layer").append(html);
        return false;
    });

    $("#add-condition").click(function () {
        conditionCount++;
        var html = '<div class="condition row" id="condition-'+conditionCount+'"><div class="col-md-11"><div class="form-group field-competition-condition">' +
            '<input type="text" class="form-control" maxlength="50" name="Condition[' + conditionCount + '][name]" placeholder="Условие">' +
            '</div></div><div class="col-md-1">' +
            '<a href="#" class="btn-remove" data-id="'+conditionCount+'"><i class="fa fa-minus" aria-hidden="true"></i></a>' +
            '</div></div>';
        $("#condition-layer").append(html);
        return false;
    });

    $("#add-prize").click(function () {
        prizeCount++;
        var html = '<div class="prize"><div class="form-group field-competition-prize">' +
            '<label class="control-label">' + prizeCount + ' место</label>' +
            '<input type="text" maxlength="20" class="form-control" name="Prize[' + prizeCount + '][name]" placeholder="Название приза"></div>' +
            /*'<div class="form-group field-competition-prize"><div class="form-group">' +
            '<input type="text" class="form-control" name="Prize[' + prizeCount + '][url]" placeholder="Ссылка на приз (не обязательно)"></div></div>*/'</div>';
        $("#prize-layer").append(html);
        return false;
    });

    $(".winner-btn").click(function () {
        var id = $(this).data("id");
        var _this = $(this);
        $("#winner-block-" + id).html("");
        $.post("/competition/set-winner", {prize: id}, function (data) {
            if (data.code == 0) {
                var html = '<div style="float: left;"><strong>' + data.result.name + '</strong></div>';
                if (data.result.country) {
                    html += ' ';
                }
                html += '<div class="member-detail" style="float: left;"><span class="delimiter"> </span><a href="'+data.result.url+'" target="_blank"><i class="glyphicon glyphicon-link"></i> Ссылка</a></div>';
                html += '</div>';
                $("#winner-block-" + id).html(html);
                _this.removeClass("green");
                _this.html('<i class="fa fa-refresh" aria-hidden="true"></i> Перевыбрать');
            }

        }, "json");
        return false;
    });

    if ($("#competition-video_url").length && $("#competition-video_url").val()) {
        $("#competition-video_url").change();
    }

    $(".competition-table tbody tr").click(function () {
        window.location.href = "/id" + $(this).data("id");
    });

    $(".disable-competition").click(function () {
        if (confirm("Вы действительно хотите удалить конкурс? Он больше не будет доступен. Действие необратимо.")) {
            var id = $(this).data("id");
            $.post("/competition/delete", {id: id}, function (data) {
                $("#competition-" + id).remove();
            }, "json");
        }
        return false;
    });

    $(".disable-post").click(function () {
        if (confirm("Вы действительно хотите удалить рекламу? Она больше не будет доступна. Действие необратимо.")) {
            var id = $(this).data("id");
            $.post("/post/delete", {id: id}, function (data) {
                $("#adm-a-" + id).remove();
            }, "json");
        }
        return false;
    });

    $("#sponsor-layer").on("click", "a", function () {
        $("#sponsor-" + $(this).data("id")).remove();
        return false;
    });

    $("#condition-layer").on("click", "a", function () {
        $("#condition-" + $(this).data("id")).remove();
        return false;
    });

    $("#post-name").keyup(function () {
        var val = $(this).val();
        $("#help-text-name").text("Осталось: " + (25-val.length) + ' символов');
        $("#post-preview h4").text(val);
    });
    $("#post-description").keyup(function () {
        var val = $(this).val();
        $("#help-text-description").text("Осталось: " + (50-val.length) + ' символов');
        $("#post-preview p").text(val);
    });

    $.each($(".help-text-len"), function (i, o) {
        var to = $(o).data("to");
        var _this = $("#" + to);
        var max = _this.attr("maxlength");
        $(o).text("Осталось: " + (max-_this.val().length) + ' символов');
        _this.keyup(function () {
            $(o).text("Осталось: " + (max-_this.val().length) + ' символов');
        });
    });


    var setNewPost = function () {
        var id = $("#owl-best-projects .item").filter(":first").data("id");
        $.post("/new-post", {last: id}, function (data) {
            if (data.code == 0) {
                $.each(data.result.post, function (i, o) {
                    var html = '<div class="item" data-id="'+o.id+'"><a href="'+ o.url+'" target="_blank"><div class="post-img"><img src="'+ o.image+'" /></div>'+
                        '<h4>'+ o.name+'</h4><p>'+ o.description+'</p></a></div>';
                    owl.data('owlCarousel').addItem(html, 0);
                });
            }
            setTimeout(function () {
                setNewPost();
            }, 5000);
        }, "json");
    };
    
    

    if ($("#owl-best-projects").length) {
        setTimeout(function () {
            setNewPost();
        }, 5000);
    }

    $("#checkout-form").submit();
});
