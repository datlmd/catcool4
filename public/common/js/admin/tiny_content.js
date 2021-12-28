var is_tiny_processing = false;
var Tiny_content = {
    loadTiny: function(max_height) {
        if (typeof max_height === 'undefined') {
            max_height = 350;
        }
        var lang_code = "en";
        if ($("html").get(0).hasAttribute("lang") && $("html").attr("lang") == "vi") {
            lang_code = $("html").attr("lang");
        }

        tinymce.init({
            selector: '[data-bs-toggle=\'tinymce\']',
            skin: 'oxide-dark',
            themes: "silver",
            //plugins: 'print preview fullpage powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons',
            plugins: 'print preview paste searchreplace autolink autosave save hr directionality visualblocks visualchars fullscreen image imagetools responsivefilemanager link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons code',
            //imagetools_cors_hosts: ['picsum.photos'],
            language: lang_code,
            language_url: base_url + '/common/js/tinymce/langs/' + lang_code + '.js',
            remove_script_host: false,
            relative_urls: false,
            menubar: false,
            toolbar: 'undo redo | fullscreen preview code | formatselect bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | link image myFileManager media pageembed | numlist bullist checklist | table | fontselect fontsizeselect | forecolor backcolor casechange permanentpen formatpainter removeformat | hr pagebreak codesample | print emoticons help', /* charmap emoticons a11ycheck ltr rtl */
            fontsize_formats: "8px 9px 10px 11px 12px 14px 16px 18px 20px 24px 30px 36px 48px 64px 72px",
            image_caption: true,
            image_title: true,
            image_advtab: true,
            image_class_list: [
                { title: 'None', value: '' },
                { title: 'Fluid', value: 'img-fluid' },
                { title: 'Rounded', value: 'rounded' },
                { title: 'Rounded Top', value: 'rounded-top' },
                { title: 'Rounded Bottom', value: 'rounded-bottom' },
                { title: 'Rounded Left', value: 'rounded-start' },
                { title: 'Rounded Circle', value: 'rounded-circle' },
                { title: 'Rounded Pill', value: 'rounded-pill' },
            ],
            imagetools_toolbar: "alignleft aligncenter alignright image",//"rotateleft rotateright | flipv fliph | editimage imageoptions",
            //importcss_append: true,
            template_cdate_format: '[Date Created (CDATE): %d/%m/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %d/%m/%Y : %H:%M:%S]',
            height: max_height,
            quickbars_selection_toolbar: 'formatselect bold italic blockquote forecolor removeformat | quicklink | alignleft aligncenter alignright',
            quickbars_insert_toolbar: false,// 'formatselect blockquote quicktable image myFileManager',
            toolbar_drawer: 'sliding',
            contextmenu: "link image",/*right click*/
            mobile: {
                theme: 'silver'
            },
            /*
            setup: (editor) => {
                editor.ui.registry.addButton('myFileManager', {
                    icon: 'image',
                    tooltip: 'File Manager',
                    onAction: () => {
                        if (is_tiny_processing) {
                            return;
                        }
                        if ($('#modal_image').length) {
                            $('#modal_image').remove();
                        }
                        is_tiny_processing = true;
                        $.ajax({
                            url: 'common/filemanager?type=image',
                            dataType: 'html',
                            success: function(html) {
                                is_tiny_processing = false;
                                $('body').append('<div id="modal_image" class="modal" data-keyboard="false" data-backdrop="static">' + html + '</div>');

                                $('#modal_image').modal('show');
                                $('#modal_image').delegate('a.thumbnail', 'click', function(e) {
                                    e.preventDefault();
                                    editor.insertContent('<figure class="image figure"><img src="' + base_url + '/img/' + $($(this).data('file-target')).val() + '" style="width:100%; max-width: 700px;" data-mce-src="' + base_url + '/img/' + $($(this).data('file-target')).val() + '"><figcaption class="figure-caption text-end">Caption</figcaption></figure><br/>');

                                    $('#modal_image').modal('hide');
                                });
                            },
                            error: function (xhr, errorType, error) {
                                is_tiny_processing = false;
                            }
                        });
                    }
                });
                editor.on('change', function () {
                    editor.save();
                });
            },//end setup

             */
            file_picker_types: 'image media',
            file_picker_callback: function (cb, value, meta) {

                if (is_tiny_processing) {
                    return;
                }
                if ($('#modal_image').length) {
                    $('#modal_image').remove();
                }

                is_tiny_processing = true;

                var type = "";
                if (meta.filetype != 'undefined') {
                    type = meta.filetype;
                }

                $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

                $.ajax({
                    url: 'common/filemanager?type=' + type,
                    dataType: 'html',
                    success: function(html) {
                        is_tiny_processing = false;

                        $('.loading').remove().fadeOut();

                        $('body').append('<div id="modal_image" class="modal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1">' + html + '</div>');

                        $('#modal_image').modal('show');
                        $('html').css('overflow', 'hidden');
                        $('#modal_image').delegate('a.thumbnail', 'click', function(e) {
                            e.preventDefault();

                            var img_url = base_url + '/img/' + $($(this).data('file-target')).val();
                            if (type != 'undefined' && type == "image") {
                                cb(img_url, { width: '100%', height: '' }); //{ title: img_url }
                            } else {
                                img_url = base_url + '/file/' + $($(this).data('file-target')).val();
                                cb(img_url);
                            }

                            $('#modal_image').modal('hide');
                        });
                    },
                    error: function (xhr, errorType, error) {
                        $('.loading').remove().fadeOut();
                        is_tiny_processing = false;
                    }
                });
            },
        });

        return true;
    },
};
