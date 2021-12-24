
<script type="text/javascript" src="{base_url('common/plugin/slimscroll/jquery.slimscroll.js')}"></script>
<script type="text/javascript" src="{base_url('common/js/confirm/jquery-confirm.min.js')}"></script>
<script type="text/javascript" src="{base_url('common/js/lightbox/lightbox.js')}"></script>
<script type="text/javascript" src="{base_url('common/js/rcrop/rcrop.min.js')}"></script>
<script type="text/javascript" src="{base_url('common/js/alert.min.js')}"></script>

{if ENVIRONMENT === 'production'}
    <script type="text/javascript" src="{base_url('common/js/admin/filemanager.min.js')}?{CACHE_TIME_JS}"></script>
{else}
    <script type="text/javascript" src="{base_url('common/js/admin/filemanager.js')}?{CACHE_TIME_JS}"></script>
{/if}
