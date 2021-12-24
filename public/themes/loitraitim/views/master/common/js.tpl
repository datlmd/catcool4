
<script type="text/javascript" src="{base_url('common/plugin/owl.carousel/owl.carousel.min.js')}"></script>

{if ENVIRONMENT === 'production'}
    <script type="text/javascript" src="{theme_url('assets/js/custom.min.js')}?{CACHE_TIME_JS}"></script>
{else}
    <script type="text/javascript" src="{theme_url('assets/js/custom.js')}?{CACHE_TIME_JS}"></script>
{/if}
