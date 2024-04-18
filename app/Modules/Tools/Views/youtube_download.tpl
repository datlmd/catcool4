{strip}
{literal}
<style type="text/css">
    .download-youtube-content {
        min-height: 100vh;
        padding: 20px;
    }
    .download-youtube-content h2 {
        font-size: 35px;
    }
    .download-youtube-content .form-download {
        width: 100%;
        max-width: 800px;
        margin: 10px auto;
    }
    .download-youtube-content #video_content {
        width: 100%;
        max-width: 600px;
        margin: 20px auto 10px auto;
    }
</style>
{/literal}
<div class="container-lg bg-white download-youtube-content mt-2">
    <h2 class="text-primary text-center mt-4 mb-3">{lang('Tool.youtube_download_title')}</h2>
    <div class="row text-center form-download">
        <div class="col-9">
            <input type="text" name="youtube_download_url" class="form-control form-control-lg" placeholder="{lang('Tool.help_youtube_download_textbox')}">
        </div>
        <div class="col-3">
            <button id="button_download_youtube" class="btn btn-lg w-100 btn-primary"><i class="fa fa-download me-1"></i>{lang('Tool.button_youtube_download')}</button>
        </div>
    </div>
    <div id="video_content"></div>
</div>
{/strip}
<script>
    var is_processing = false;

    $(document).on("click", '#button_download_youtube', function(event) {
        if ($(".download-youtube-content input[name=\'youtube_download_url\']").val() == "") {
            return false;
        }

        if (is_processing) {
            return false;
        }
        is_processing = true;
        $('#video_content').html("");
        $.ajax({
            url: 'tools/youtube/api_youtube_video',
            //type: 'POST',
            data: {
                'url': $(".download-youtube-content input[name=\'youtube_download_url\']").val(),
            },
            dataType: 'html',
            beforeSend: function() {
                $(this).find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
            },
            complete: function() {
                $(this).find('i').replaceWith('<i class="fa fa-download me-1"></i>');
            },
            success: function(json) {
                is_processing = false;

                $('#video_content').html(json);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                is_processing = false;
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
</script>
