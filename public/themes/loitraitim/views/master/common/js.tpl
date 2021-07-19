<script type="text/javascript" src="{base_url('common/plugin/jquery.appear/jquery.appear.min.js')}"></script>
<script type="text/javascript" src="{base_url('common/plugin/jquery.easing/jquery.easing.min.js')}"></script>
<script type="text/javascript" src="{base_url('common/plugin/jquery.cookie/jquery.cookie.min.js')}"></script>

{if ENVIRONMENT === 'production'}
    <script type="text/javascript" src="{theme_url('assets/js/common/common.min.js')}"></script>
{else}
    <script type="text/javascript" src="{theme_url('assets/js/common/common.js')}"></script>
{/if}


{*<script type="text/javascript" src="{base_url('common/plugin/isotope/jquery.isotope.min.js')}"></script>*}
<script type="text/javascript" src="{base_url('common/plugin/owl.carousel/owl.carousel.min.js')}"></script>
{*<script type="text/javascript" src="{base_url('common/plugin/magnific-popup/jquery.magnific-popup.min.js')}"></script>*}
{*<script type="text/javascript" src="{base_url('common/plugin/vide/jquery.vide.min.js')}"></script>*}
{*<script type="text/javascript" src="{base_url('common/plugin/vivus/vivus.min.js')}"></script>*}

{if ENVIRONMENT === 'production'}
    <script type="text/javascript" src="{theme_url('assets/js/theme.min.js')}"></script>
    <script type="text/javascript" src="{theme_url('assets/js/custom.min.js')}"></script>
    <script type="text/javascript" src="{theme_url('assets/js/theme.init.min.js')}"></script>
{else}
    <script type="text/javascript" src="{theme_url('assets/js/theme.js')}"></script>
    <script type="text/javascript" src="{theme_url('assets/js/custom.js')}"></script>
    <script type="text/javascript" src="{theme_url('assets/js/theme.init.js')}"></script>
{/if}
