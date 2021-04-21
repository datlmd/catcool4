var is_processing = false;
var Tiny_content = {
    loadTiny: function(max_height) {
        if (typeof max_height === 'undefined') {
            max_height = 350;
        }

        tinymce.init({
            selector: '[data-bs-toggle=\'tinymce\']',
            //skin: 'oxide-dark',
            //themes: "silver",
            //plugins: 'print preview fullpage powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons',
            plugins: 'print preview paste searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image imagetools responsivefilemanager link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons code',
            //imagetools_cors_hosts: ['picsum.photos'],
            remove_script_host:false,
            relative_urls: false,
            menubar: false,
            toolbar: 'undo redo | formatselect bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | link myFileManager media | numlist bullist checklist | table | fontselect fontsizeselect | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak codesample | fullscreen preview code | help', /* charmap emoticons a11ycheck ltr rtl */
            fontsize_formats: "8px 9px 10px 11px 12px 14px 16px 18px 20px 24px 30px 36px 48px 64px 72px",
            image_caption: true,
            image_advtab: true,
            imagetools_toolbar: "alignleft aligncenter alignright image",//"rotateleft rotateright | flipv fliph | editimage imageoptions",
            //importcss_append: true,
            template_cdate_format: '[Date Created (CDATE): %d/%m/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %d/%m/%Y : %H:%M:%S]',
            height: max_height,
            quickbars_selection_toolbar: 'bold italic blockquote forecolor removeformat | quicklink | alignleft aligncenter alignright',
            quickbars_insert_toolbar: 'formatselect blockquote quicktable myFileManager',
            toolbar_drawer: 'sliding',
            contextmenu: "link image",/*right click*/
            setup: (editor) => {
                editor.ui.registry.addButton('myFileManager', {
                    icon: 'image',
                    tooltip: 'File Manager',
                    onAction: () => {
                        if (is_processing) {
                            return;
                        }
                        if ($('#modal-image').length) {
                            $('#modal-image').remove();
                        }
                        is_processing = true;
                        $.ajax({
                            url: 'common/filemanager',
                            dataType: 'html',
                            success: function(html) {
                                is_processing = false;
                                $('body').append('<div id="modal-image" class="modal" data-keyboard="false" data-backdrop="static">' + html + '</div>');

                                $('#modal-image').modal('show');
                                $('#modal-image').delegate('a.thumbnail', 'click', function(e) {
                                    e.preventDefault();
                                    editor.insertContent('<figure class="image"><img src="' + base_url + '/img/' + $(this).parent().find('input').val() + '" style="width:100%; max-width: 700px;" data-mce-src="' + base_url + '/img/' + $(this).parent().find('input').val() + '"><figcaption>Caption</figcaption></figure><br/>');

                                    $('#modal-image').modal('hide');
                                });
                            },
                            error: function (xhr, errorType, error) {
                                is_processing = false;
                            }
                        });
                    }
                });
                editor.on('change', function () {
                    editor.save();
                });
            },//end setup
        });

        return true;
    },
};
