<div class="mb-4 text-end">
    <a href="{site_url('manage/countries')}" class="btn btn-sm {if $active eq 'countries'}btn-primary{else}btn-outline-primary{/if}">{lang('CountryAdmin.text_country')}</a>
    <a href="{site_url('manage/country_zones')}" class="btn btn-sm {if $active eq 'zones'}btn-primary{else}btn-outline-primary{/if}">{lang('CountryAdmin.text_province')}</a>
    <a href="{site_url('manage/country_districts')}" class="btn btn-sm {if $active eq 'districts'}btn-primary{else}btn-outline-primary{/if}">{lang('CountryAdmin.text_district')}</a>
    <a href="{site_url('manage/country_wards')}" class="btn btn-sm {if $active eq 'wards'}btn-primary{else}btn-outline-primary{/if}">{lang('CountryAdmin.text_ward')}</a>
</div>
