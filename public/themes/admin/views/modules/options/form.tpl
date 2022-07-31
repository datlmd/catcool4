{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ["id" => "validationform", "method" => "post", "data-cc-toggle" => "ajax"])}

            {if !empty($edit_data.option_id)}
                {form_hidden('option_id', $edit_data.option_id)}
            {/if}
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-7 col-12">
                            {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('OptionAdmin.heading_title')}
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
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.option_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">

                            {foreach $language_list as $language}
                                <div class="form-group row required has-error">
                                    <label class="col-12 col-sm-3 col-form-label required-label text-sm-end">
                                        {lang('Admin.text_name')} ({$language.name})
                                    </label>
                                    <div class="col-12 col-sm-8 col-lg-7">
                                        <div class="input-group">
                                            <span class="input-group-text">{$language.icon}</span>
                                            <input type="text" name="lang[{$language.id}][name]" value='{old("lang.`$language.id`.name", $edit_data.lang[$language.id].name)}' id="input_name_{$language.id}" class="form-control {if $validator->hasError("lang.`$language.id`.name")}is-invalid{/if}">
                                            <div class="invalid-feedback">
                                                {$validator->getError("lang.`$language.id`.name")}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}

                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_type')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <select name="type" id="input-type" class="form-select">
                                        <optgroup label="{lang('OptionAdmin.text_choose')}">
                                            <option value="select" {if $edit_data.type == 'select'}selected{/if}>{lang('OptionAdmin.text_select')}</option>
                                            <option value="radio" {if $edit_data.type == 'radio'}selected{/if}>{ text_radio }</option>
                                            <option value="checkbox" {if $edit_data.type == 'checkbox'}selected{/if}>{ text_checkbox }</option>
                                        </optgroup>
                                        <optgroup label="{lang('OptionAdmin.text_input')}">
                                            <option value="text" {if $edit_data.type == 'text'}selected{/if}>{lang('OptionAdmin.text_text')}</option>
                                            <option value="textarea" {if $edit_data.type == 'textarea'}selected{/if}>{lang('OptionAdmin.text_textarea')}</option>
                                        </optgroup>
                                        <optgroup label="{lang('OptionAdmin.text_file')}">
                                            <option value="file" {if $edit_data.type == 'file'}selected{/if}>{lang('OptionAdmin.text_file')}</option>
                                        </optgroup>
                                        <optgroup label="{lang('OptionAdmin.text_date')}">
                                            <option value="date" {if $edit_data.type == 'date'}selected{/if}>{lang('OptionAdmin.text_date')}</option>
                                            <option value="time" {if $edit_data.type == 'time'}selected{/if}>{lang('OptionAdmin.text_time')}</option>
                                            <option value="datetime" {if $edit_data.type == 'datetime'}selected{/if}>{lang('OptionAdmin.text_datetime')}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row pb-3">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('Admin.text_sort_order')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-7">
                                    <input type="number" name="sort_order" value="{old('sort_order', $edit_data.sort_order)|default:0}" id="sort_order" min="0" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <h5 class="card-header">{lang('OptionAdmin.text_value')}</h5>
                        <div class="card-body">
                            <table id="option-value" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td class="text-start required">{lang('OptionAdmin.text_option_value')}</td>
                                    <td class="text-center">{lang('Admin.text_image')}</td>
                                    <td class="text-end">{lang('Admin.text_sort_order')}</td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                {old('option_values', $edit_data.option_values)}
                                {foreach old('option_values', $edit_data.option_values) as $option_value}
                                    <tr id="option-value-row-">
                                        <td class="text-start">
                                            <input type="hidden" name="option_value[][option_value_id]" value="" />
                                            {foreach $language_list as $language}
                                                <div class="input-group">
                                                    <span class="input-group-text">{$language.icon}</span>
                                                    <input type="text" name="option_value[][lang][{$language.id}][name]" value='{$option_value.lang[$language.id].name}' id="input_option_value_lang_{$language.id}" class="form-control">
                                                </div>
                                            {/foreach}
                                        </td>
                                        <td class="text-center">
                                            <div class="card image">
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <input type="text" name="option_value[][sort_order]" value="{$option_value.sort_order}" placeholder="{lang('Admin.text_sort_order')}" class="form-control"/>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" onclick="$('#option-value-row-' + option_value_row).remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                {/foreach}
{*                                {% set option_value_row = 0 %}*}
{*                                {% for option_value in option_values %}*}
{*                                <tr id="option-value-row-{{ option_value_row }}">*}
{*                                    <td class="text-center"><input type="hidden" name="option_value[{{ option_value_row }}][option_value_id]" value="{{ option_value.option_value_id }}"/>*}
{*                                        {% for language in languages %}*}
{*                                        <div class="input-group">*}
{*                                            <div class="input-group-text"><img src="language/{{ language.code }}/{{ language.code }}.png" title="{{ language.name }}"/></div>*}
{*                                            <input type="text" name="option_value[{{ option_value_row }}][option_value_description][{{ language.language_id }}][name]" value="{{ option_value.option_value_description[language.language_id] ? option_value.option_value_description[language.language_id].name }}" placeholder="{{ entry_option_value }}" id="input-option-value-{{ option_value_row }}-{{ language.language_id }}" class="form-control"/>*}
{*                                        </div>*}
{*                                        <div id="error-option-value-{{ option_value_row }}-{{ language.language_id }}" class="invalid-feedback"></div>*}
{*                                        {% endfor %}</td>*}
{*                                    <td class="text-center">*}
{*                                        <div class="card image">*}
{*                                            <img src="{{ option_value.thumb }}" alt="" title="" id="thumb-image-{{ option_value_row }}" data-oc-placeholder="{{ placeholder }}" class="card-img-top"/> <input type="hidden" name="option_value[{{ option_value_row }}][image]" value="{{ option_value.image }}" id="input-image-{{ option_value_row }}"/>*}
{*                                            <div class="card-body">*}
{*                                                <button type="button" data-oc-toggle="image" data-oc-target="#input-image-{{ option_value_row }}" data-oc-thumb="#thumb-image-{{ option_value_row }}" class="btn btn-primary btn-sm btn-block"><i class="fa-solid fa-pencil"></i> {{ button_edit }}</button>*}
{*                                                <button type="button" data-oc-toggle="clear" data-oc-target="#input-image-{{ option_value_row }}" data-oc-thumb="#thumb-image-{{ option_value_row }}" class="btn btn-warning btn-sm btn-block"><i class="fa-regular fa-trash-can"></i> {{ button_clear }}</button>*}
{*                                            </div>*}
{*                                        </div>*}
{*                                    </td>*}
{*                                    <td class="text-end"><input type="text" name="option_value[{{ option_value_row }}][sort_order]" value="{{ option_value.sort_order }}" placeholder="{{ entry_sort_order }}" class="form-control"/></td>*}
{*                                    <td class="text-end"><button type="button" onclick="$('#option-value-row-{{ option_value_row }}').remove();" data-bs-toggle="tooltip" title="{{ button_remove }}" class="btn btn-danger"><i class="fa-solid fa-minus-circle"></i></button></td>*}
{*                                </tr>*}
{*                                {% set option_value_row = option_value_row + 1 %}*}
{*                                {% endfor %}*}
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-end"><button type="button" onclick="addOptionValue();" data-bs-toggle="tooltip" title="{{ button_option_value_add }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></button></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        {form_close()}
    </div>
    <div id="html_option_value" style="display: none">
        <table>
            <tbody>
                <tr id="option-value-row-">
                    <td class="text-start">
                        <input type="hidden" name="option_value[][option_value_id]" value="" />
                        {foreach $language_list as $language}
                            <div class="input-group">
                                <span class="input-group-text">{$language.icon}</span>
                                <input type="text" name="option_value[][lang][{$language.id}][name]" value='{old("option_value[][lang][{$language.id}][name]")}' id="input_option_value_lang_{$language.id}" class="form-control">
                            </div>
                        {/foreach}
                    </td>
                    <td class="text-center">
                        <div class="card image">
                        </div>
                    </td>
                    <td class="text-end">
                        <input type="text" name="option_value[][sort_order]" value="" placeholder="{lang('Admin.text_sort_order')}" class="form-control"/>
                    </td>
                    <td class="text-end">
                        <button type="button" onclick="$('#option-value-row-' + option_value_row).remove();" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{lang('Admin.button_delete')}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" name="option_value_row" value="">
{/strip}
<script type="text/javascript"><!--
    $('#input-type').on('change', function() {
        if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox' || this.value == 'image') {
            $('#option-value').parent().show();
        } else {
            $('#option-value').parent().hide();
        }
    });

    $('#input-type').trigger('change');

    {*var option_value_row = {{ option_value_row }};*}

    function addOptionValue() {
        {*html = '<tr id="option-value-row-' + option_value_row + '">';*}
        {*html += '  <td class="text-start"><input type="hidden" name="option_value[' + option_value_row + '][option_value_id]" value="" />';*}
        {*{% for language in languages %}*}
        {*html += '    <div class="input-group">';*}
        {*html += '      <div class="input-group-text"><img src="language/{{ language.code }}/{{ language.code }}.png" title="{{ language.name }}" /></div>';*}
        {*html += '      <input type="text" name="option_value[' + option_value_row + '][option_value_description][{{ language.language_id }}][name]" value="" placeholder="{{ entry_option_value }}" id="input-option-value-' + option_value_row + '-{{ language.language_id }}" class="form-control"/>';*}
        {*html += '    </div>';*}
        {*html += '    <div id="error-option-value-' + option_value_row + '-{{ language.language_id }}" class="invalid-feedback"></div>';*}
        {*{% endfor %}*}
        {*html += '  </td>';*}
        {*html += '  <td class="text-center">';*}
        {*html += '    <div class="card image">';*}
        {*html += '      <img src="{{ placeholder }}" alt="" title="" id="thumb-image-' + option_value_row + '" data-oc-placeholder="{{ placeholder }}" class="card-img-top"/>';*}
        {*html += '      <input type="hidden" name="option_value[' + option_value_row + '][image]" value="" id="input-image-' + option_value_row + '"/>';*}
        {*html += '      <div class="card-body">';*}
        {*html += '        <button type="button" data-oc-toggle="image" data-oc-target="#input-image-' + option_value_row + '" data-oc-thumb="#thumb-image-' + option_value_row + '" class="btn btn-primary btn-sm btn-block"><i class="fa-solid fa-pencil"></i> {{ button_edit }}</button>';*}
        {*html += '        <button type="button" data-oc-toggle="clear" data-oc-target="#input-image-' + option_value_row + '" data-oc-thumb="#thumb-image-' + option_value_row + '" class="btn btn-warning btn-sm btn-block"><i class="fa-regular fa-trash-can"></i> {{ button_clear }}</button>';*}
        {*html += '      </div>';*}
        {*html += '    </div>';*}
        {*html += '  </td>';*}
        {*html += '  <td class="text-end"><input type="text" name="option_value[' + option_value_row + '][sort_order]" value="" placeholder="{{ entry_sort_order }}" class="form-control"/></td>';*}
        {*html += '  <td class="text-end"><button type="button" onclick="$(\'#option-value-row-' + option_value_row + '\').remove();" data-bs-toggle="tooltip" title="{{ button_remove }}" class="btn btn-danger"><i class="fa-solid fa-minus-circle"></i></button></td>';*}
        {*html += '</tr>';*}
        html = $('#html_option_value table tbody').html();
        $('#option-value tbody').append(html);

        //option_value_row++;
    }
    //--></script>