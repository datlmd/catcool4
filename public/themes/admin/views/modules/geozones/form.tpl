{strip}
    {form_hidden('manage_url', site_url($manage_url))}

    <div class="container-fluid  dashboard-content">
        {form_open(site_url("$manage_url/save"), ["id" => "form_geo_zone", "method" => "post", "data-cc-toggle" => "ajax"])}
            <input type="hidden" name="geo_zone_id" value="{$edit_data.geo_zone_id}">
            <div class="row">
                <div class="col-sm-9 col-12">
                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('GeoZoneAdmin.heading_title')}
                        </div>
                        <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                            <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                            <a href="{back_to($manage_url)}" class="btn btn-sm btn-space btn-secondary mb-0 me-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                        </div>
                    </div>

                    {if !empty(print_flash_alert())}
                        {print_flash_alert()}
                    {/if}
                    {if !empty($errors)}
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    {/if}

                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.geo_zone_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">

                            <div class="form-group row required has-error mb-2">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('GeoZoneAdmin.text_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="name" value='{old("name", $edit_data.name)}' id="input_name" class="form-control {if validation_show_error("name")}is-invalid{/if}">
                                    <div id="error_name" class="invalid-feedback">
                                        {validation_show_error("name")}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row required has-error">
                                <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                    {lang('GeoZoneAdmin.text_description')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="text" name="description" value='{old("description", $edit_data.description)}' id="input_description" class="form-control {if validation_show_error("description")}is-invalid{/if}">
                                    <div id="error_description" class="invalid-feedback">
                                        {validation_show_error("name")}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="zone_to_geo_zone_list" class="card">
                        <h5 class="card-header">{lang('GeoZoneAdmin.text_geo_zones')}</h5>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-start required" width="50%">{lang('GeoZoneAdmin.text_country')}</th>
                                    <th class="text-start">{lang('GeoZoneAdmin.text_zone')}</th>
                                    <th width="70"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    {if !empty($edit_data.zone_to_geo_zones)}
                                        {counter assign=zone_to_geo_zone_row start=1 print=false}

                                        {foreach $edit_data.zone_to_geo_zones as $zone_to_geo_zone}
                                            <tr id="zone_to_geo_zone_row_{$zone_to_geo_zone_row}">
                                                <td class="text-start">

                                                    <select name="zone_to_geo_zones[{$zone_to_geo_zone_row}][country_id]" id="input_zone_to_geo_zones_{$zone_to_geo_zone_row}_country_id" class="form-control cc-form-select-single country-changed{if validation_show_error("zone_to_geo_zones[{$zone_to_geo_zone_row}][country_id]")} is-invalid{/if}" disabled target_id="#input_zone_to_geo_zones_{$zone_to_geo_zone_row}_zone_id" data-zone-to-geo-zone-row="{$zone_to_geo_zone_row}" data-zone-id="{$zone_to_geo_zone.zone_id}">
                                                        {foreach $country_list as $key => $value}
                                                            <option value="{$key}" {if $zone_to_geo_zone.country_id eq $key}selected{/if}>{$value}</option>
                                                        {/foreach}
                                                    </section>
                                                    <div id="error_zone_to_geo_zones_{$zone_to_geo_zone_row}_country_id" class="invalid-feedback">
                                                        {validation_show_error("zone_to_geo_zones[{$zone_to_geo_zone_row}][country_id]")}
                                                    </div>
                                                    
                                                </td>
                                                <td class="text-start">

                                                    <select name="zone_to_geo_zones[{$zone_to_geo_zone_row}][zone_id]" id="input_zone_to_geo_zones_{$zone_to_geo_zone_row}_zone_id" disabled class="form-control cc-form-select-single country-changed{if validation_show_error("zone_to_geo_zones[{$zone_to_geo_zone_row}][zone_id]")} is-invalid{/if}">
                                                        
                                                    </select>
                                                    <div id="error_zone_to_geo_zones_{$zone_to_geo_zone_row}_zone_id" class="invalid-feedback">
                                                        {validation_show_error("zone_to_geo_zones[{$zone_to_geo_zone_row}][zone_id]")}
                                                    </div>
                                                    
                                                </td>
                                               
                                                <td class="text-end">
                                                    <button type="button" onclick="$('#zone_to_geo_zone_row_{$zone_to_geo_zone_row}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
                                                </td>
                                            </tr>

                                            {counter}

                                        {/foreach}
                                    {/if}

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="text-end"><button type="button" onclick="addZoneToGeoZones();" data-bs-toggle="tooltip" title="{lang('GeoZoneAdmin.text_add')}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></button></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="col-sm-3 col-12">
                    {include file=get_theme_path('views/inc/menu_localisation.inc.tpl') active="geo_zones"}
                </div>
                
            </div>
        {form_close()}
    </div>

    <div id="html_zone_to_geo_zones" style="display: none">
        <table>
            <tbody>
                <tr id="zone_to_geo_zone_row_{'zone_to_geo_zone_row'}">
                    <td class="text-start">

                        <select name="zone_to_geo_zones[{'zone_to_geo_zone_row'}][country_id]" id="input_zone_to_geo_zones_{'zone_to_geo_zone_row'}_country_id" class="form-control country-changed" disabled data-zone-to-geo-zone-row="{'zone_to_geo_zone_row'}" target_id="#input_zone_to_geo_zones_{'zone_to_geo_zone_row'}_zone_id">
                            {foreach $country_list as $key => $value}
                                <option value="{$key}">{$value}</option>
                            {/foreach}
                        </select>

                    </td>
                    <td class="text-start">

                        <select name="zone_to_geo_zones[{'zone_to_geo_zone_row'}][zone_id]" id="input_zone_to_geo_zones_{'zone_to_geo_zone_row'}_zone_id" class="form-control country-changed" disabled>
                        </select>

                    </td>
   
                    <td class="text-end">
                        <button type="button" onclick="$('#zone_to_geo_zone_row_{'zone_to_geo_zone_row'}').remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <input type="hidden" name="zone_to_geo_zone_row" id="zone_to_geo_zone_row" value="{$edit_data.zone_to_geo_zones|@count|default:0}">
{/strip}
<script type="text/javascript">


    function addZoneToGeoZones() {
        var zone_to_geo_zone_row = $('#zone_to_geo_zone_row').val();
        zone_to_geo_zone_row = parseInt(zone_to_geo_zone_row) + 1;
        $('#zone_to_geo_zone_row').val(zone_to_geo_zone_row);

        var html = $('#html_zone_to_geo_zones table tbody').html().replaceAll('zone_to_geo_zone_row', zone_to_geo_zone_row);
        $('#zone_to_geo_zone_list table tbody').append(html);

                       
        $('select[name=\'zone_to_geo_zones[' + zone_to_geo_zone_row + '][country_id]\'], select[name=\'zone_to_geo_zones[' + zone_to_geo_zone_row + '][zone_id]\']').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            selectionCssClass: 'select2--small',
            dropdownCssClass: 'select2--small',
        });

        $('select[name=\'zone_to_geo_zones[' + zone_to_geo_zone_row + '][country_id]\']').trigger('change');

        //$('.cc-form-select-single').select2('open');
    }

    var zone = [];

    $('#zone_to_geo_zone_list').on('change', 'select[name$=\'[country_id]\']', function () {
        var element = this;

        $(element).prop('disabled', true);

        $('select[name=\'zone_to_geo_zones[' + $(element).attr('data-zone-to-geo-zone-row') + '][zone_id]\']').prop('disabled', false);

        if (!zone[$(element).val()]) {

            $.ajax({
                url: 'countries/api/zones',
                data: {
                    'country_id' : $(element).val(),
                    [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    $('button[form=\'form_geo_zone\']').prop('disabled', true);
                },
                complete: function () {
                    $('button[form=\'form_geo_zone\']').prop('disabled', false);
                },
                success: function (json) {
                    zone[$(element).val()] = json;

                    if (json.token) {
                        // Update CSRF hash
                        $("input[name*='" + csrf_token + "']").val(json.token);
                    }

                    html = '<option value="0">' + '{{lang("GeoZoneAdmin.text_all_zones")}}' + '</option>';

                    $.each(json.zones, function(index, value) {
                        html += '<option value="' + index.replace("_", "") + '"';

                        if (index.replace("_", "") == $(element).attr('data-zone-id')) {
                            html += ' selected';
                        }

                        html += '>' + value + '</option>';
                    });
                    
                    $('#zone_to_geo_zone_list select[name=\'zone_to_geo_zones[' + $(element).attr('data-zone-to-geo-zone-row') + '][zone_id]\']').html(html);

                    $('#zone_to_geo_zone_list select[name=\'zone_to_geo_zones[' + $(element).attr('data-zone-to-geo-zone-row') + '][zone_id]\']').prop('disabled', false);

                    $(element).prop('disabled', false);

                    $('#zone_to_geo_zone_list select[name$=\'[country_id]\']:disabled:first').trigger('change');
                },
                error: function (xhr, errorType, error) {
                    console.log(error + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        } else {
            html = '<option value="0">' + '{{lang("GeoZoneAdmin.text_all_zones")}}' + '</option>';

            $.each(zone[$(element).val()].zones, function(index, value) {
                html += '<option value="' + index.replace("_", "") + '"';

                if (index.replace("_", "") == $(element).attr('data-zone-id')) {
                    html += ' selected';
                }

                html += '>' + value + '</option>';
            });

            $('#zone_to_geo_zone_list select[name=\'zone_to_geo_zones[' + $(element).attr('data-zone-to-geo-zone-row') + '][zone_id]\']').html(html);

            $(element).prop('disabled', false);

            $('#zone_to_geo_zone_list select[name$=\'[country_id]\']:disabled:first').trigger('change');
        }
    });

    $('#zone_to_geo_zone_list select[name$=\'[country_id]\']:first').trigger('change');
</script>
