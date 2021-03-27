<div class="mb-4 text-end">
    <a href="{site_url('countries/manage')}" class="btn btn-sm {if $active eq 'countries'}btn-primary{else}btn-outline-primary{/if}">{lang('CountryAdmin.text_country')}</a>
    <a href="{site_url('countries/provinces_manage')}" class="btn btn-sm {if $active eq 'provinces'}btn-primary{else}btn-outline-primary{/if}">{lang('CountryAdmin.text_province')}</a>
    <a href="{site_url('countries/districts_manage')}" class="btn btn-sm {if $active eq 'districts'}btn-primary{else}btn-outline-primary{/if}">{lang('CountryAdmin.text_district')}</a>
    <a href="{site_url('countries/wards_manage')}" class="btn btn-sm {if $active eq 'wards'}btn-primary{else}btn-outline-primary{/if}">{lang('CountryAdmin.text_ward')}</a>
</div>
