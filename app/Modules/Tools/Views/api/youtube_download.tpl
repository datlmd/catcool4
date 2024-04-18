{strip}
    {if !empty($error_message)}
        <div class="text-danger p-2 text-center">{$error_message}</div>
    {else}
        {if !empty($video_info)}
            <div class="row mt-5">
                <div class="col-4">
                    <img src="{if !empty($video_info.thumbnail.thumbnails.3)}{$video_info.thumbnail.thumbnails.3.url}{else}{$video_info.thumbnail.thumbnails.0.url}{/if}" class="img-fluid">
                </div>
                <div class="col-8">
                    <strong>{$video_info.title}</strong>
                </div>
            </div>
        {/if}
        {if !empty($video_list.video_top_list)}
            <table class="table mt-5">
                <thead>
                <tr>
                    <th scope="col">{lang('Tool.text_youtube_download_type')}</th>
                    <th scope="col" class="text-center">{lang('Tool.text_youtube_download_quality')}</th>
                    <th scope="col" class="text-end">{lang('Tool.text_youtube_download_url')}</th>
                </tr>
                </thead>
                <tbody>
                {foreach $video_list.video_top_list as $video_info}
                    <tr>
                        <td>
                            {$video_info.type}
                        </td>
                        <td class="text-center">
                            {if $video_info.qualityLabel}{$video_info.qualityLabel}{else}Unknown{/if}
                        </td>
                        <td class="text-end">
                            <a href="{$video_info.download_url}" target="_blank"><i class="fa fa-download me-1"></i>{lang('Tool.text_download_video')}</a>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        {/if}
        {if !empty($video_list.video_all)}
            <table class="table mt-4">
                <thead>
                <tr>
                    <th scope="col">{lang('Tool.text_youtube_download_type')}</th>
                    <th scope="col" class="text-center">{lang('Tool.text_youtube_download_quality')}</th>
                    <th scope="col" class="text-end">{lang('Tool.text_youtube_download_url')}</th>
                </tr>
                </thead>
                <tbody>
                {foreach $video_list.video_all as $video_info}
                    <tr>
                        <td>
                            {$video_info.type}
                        </td>
                        <td class="text-center">
                            {if $video_info.qualityLabel}{$video_info.qualityLabel}{else}Unknown{/if}
                        </td>
                        <td class="text-end">
                            <a href="{$video_info.download_url}" target="_blank"><i class="fa fa-download me-1"></i>{lang('Tool.text_download_video')}</a>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        {/if}
    {/if}
{/strip}
