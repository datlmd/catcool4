{strip}
    {form_hidden('manage_url', site_url($manage_url))}
    <div class="container-fluid  dashboard-content">
        {form_open(uri_string(), ['id' => 'validationform'])}
            <div class="row">
                <div class="col-sm-7 col-12">
                    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl') heading_title=lang('LayoutAdmin.heading_title')}
                </div>
                <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-end">
                    <button type="submit" class="btn btn-sm btn-space btn-primary mb-0" title="{lang('Admin.button_save')}"><i class="fas fa-save me-1"></i>{lang('Admin.button_save')}</button>
                    <a href="{back_to($manage_url)}" class="btn btn-sm btn-space btn-secondary mb-0 me-0" title="{lang('Admin.button_cancel')}"><i class="fas fa-reply me-1"></i>{lang('Admin.button_cancel')}</a>
                </div>
            </div>
            {if !empty($edit_data.layout_id)}
                {form_hidden('layout_id', $edit_data.layout_id)}
            {/if}
            <div class="row">
                {if !empty(print_flash_alert())}
                    <div class="col-12">{print_flash_alert()}</div>
                {/if}
                {if !empty($errors)}
                    <div class="col-12">
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    </div>
                {/if}
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header"><i class="fas {if !empty($edit_data.layout_id)}fa-edit{else}fa-plus{/if} me-2"></i>{$text_form}</h5>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 text-sm-end required-label col-form-label">
                                    {lang('Admin.text_name')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" name="name" value="{old('name', $edit_data.name)}" id="name" class="form-control {if validation_show_error('name')}is-invalid{/if}">
                                    <div class="invalid-feedback">{validation_show_error("name")}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-end">
                                    {lang('LayoutAdmin.text_route')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <div id="layout_routes">
                                        {if !empty($edit_data.routes)}
                                            {foreach $edit_data.routes as $route}
                                                <div class="input-group mb-2">
                                                    <input type="text" name="routes[]" class="form-control" value="{$route.route}">
                                                    <button class="btn btn-sm btn-danger" type="button" onclick="removeRoute(this);" title="{lang('Admin.button_delete')}"><i class="fa fa-minus-circle"></i></button>
                                                </div>
                                            {/foreach}
                                        {/if}
                                    </div>

                                    <div class="input-group">
                                        <span class="form-control border-0" style="background-color: #f6f6f6;"></span>
                                        <button class="btn btn-sm btn-primary" type="button" onclick="addRoute();" title="{lang('Admin.button_add')}"><i class="fa fa-plus-circle"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row border-top pt-4 mt-3">

                                <div class="col-12 mb-4">
                                    <table id="module_header_top" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center text-dark bg-light fw-bold"><h3 class="mb-0">{lang('LayoutAdmin.text_header_top')}</h3></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {if !empty($edit_data.modules)}
                                                {foreach $edit_data.modules as $module}
                                                    {if $module.position == 'header_top'}
                                                        <tr>
                                                            <td class="text-left">
                                                                <div class="input-group">
                                                                    <select name="modules[header_top][]" class="form-control">
                                                                        {if !empty($actions)}
                                                                            {foreach $actions as $action}
                                                                                <option value="{$action.layout_action_id}" {if $action.layout_action_id eq $module.layout_action_id}selected{/if}>{$action.name}</option>
                                                                            {/foreach}
                                                                        {/if}
                                                                    </select>
                                                                    <button type="button" onclick="removeModule(this);" title="{lang('Admin.button_delete')}" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-left">
                                                    <div class="input-group">
                                                        <select class="form-control border-0" style="background-color: #f6f6f6;" disabled>
                                                            <option value=""></option>
                                                            {if !empty($actions)}
                                                                {foreach $actions as $action}
                                                                    <option value="{$action.layout_action_id}">{$action.name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                        <button type="button" onclick="addModule('header_top');" title="{lang('Admin.button_add')}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-12 mb-4 border-bottom pb-4">
                                    <table id="module_header_bottom" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center text-dark bg-light fw-bold"><h3 class="mb-0">{lang('LayoutAdmin.text_header_bottom')}</h3></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {if !empty($edit_data.modules)}
                                                {foreach $edit_data.modules as $module}
                                                    {if $module.position == 'header_bottom'}
                                                        <tr>
                                                            <td class="text-left">
                                                                <div class="input-group">
                                                                    <select name="modules[header_bottom][]" class="form-control">
                                                                        {if !empty($actions)}
                                                                            {foreach $actions as $action}
                                                                                <option value="{$action.layout_action_id}" {if $action.layout_action_id eq $module.layout_action_id}selected{/if}>{$action.name}</option>
                                                                            {/foreach}
                                                                        {/if}
                                                                    </select>
                                                                    <button type="button" onclick="removeModule(this);" title="{lang('Admin.button_delete')}" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-left">
                                                    <div class="input-group">
                                                        <select class="form-control border-0" style="background-color: #f6f6f6;" disabled>
                                                            <option value=""></option>
                                                            {if !empty($actions)}
                                                                {foreach $actions as $action}
                                                                    <option value="{$action.layout_action_id}">{$action.name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                        <button type="button" onclick="addModule('header_bottom');" title="{lang('Admin.button_add')}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <table id="module_column_left" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center bg-light fw-bold"><h3 class="mb-0">{lang('LayoutAdmin.text_column_left')}</h3></td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            {if !empty($edit_data.modules)}
                                                {foreach $edit_data.modules as $module}
                                                    {if $module.position == 'column_left'}
                                                        <tr>
                                                            <td class="text-left">
                                                                <div class="input-group">
                                                                    <select name="modules[column_left][]" class="form-control">
                                                                        {if !empty($actions)}
                                                                            {foreach $actions as $action}
                                                                                <option value="{$action.layout_action_id}" {if $action.layout_action_id eq $module.layout_action_id}selected{/if}>{$action.name}</option>
                                                                            {/foreach}
                                                                        {/if}
                                                                    </select>
                                                                    <button type="button" onclick="removeModule(this);" title="{lang('Admin.button_delete')}" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    {/if}
                                                {/foreach}
                                            {/if}

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-left">
                                                    <div class="input-group">
                                                        <select class="form-control border-0" style="background-color: #f6f6f6;" disabled>
                                                            <option value=""></option>
                                                            {if !empty($actions)}
                                                                {foreach $actions as $action}
                                                                    <option value="{$action.layout_action_id}">{$action.name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                        <button type="button" onclick="addModule('column_left');" title="{lang('Admin.button_add')}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-lg-6 col-md-4 col-sm-12">

                                    <table id="module_content_top" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center bg-dark fw-bold"><h3 class="mb-0 text-white">{lang('LayoutAdmin.text_content_top')}</h3></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        {if !empty($edit_data.modules)}
                                            {foreach $edit_data.modules as $module}
                                                {if $module.position == 'content_top'}
                                                    <tr>
                                                        <td class="text-left">
                                                            <div class="input-group">
                                                                <select name="modules[content_top][]" class="form-control">
                                                                    {if !empty($actions)}
                                                                        {foreach $actions as $action}
                                                                            <option value="{$action.layout_action_id}" {if $action.layout_action_id eq $module.layout_action_id}selected{/if}>{$action.name}</option>
                                                                        {/foreach}
                                                                    {/if}
                                                                </select>
                                                                <button type="button" onclick="removeModule(this);" title="{lang('Admin.button_delete')}" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                {/if}
                                            {/foreach}
                                        {/if}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-left">
                                                    <div class="input-group">
                                                        <select class="form-control border-0" style="background-color: #f6f6f6;" disabled>
                                                            <option value=""></option>
                                                            {if !empty($actions)}
                                                                {foreach $actions as $action}
                                                                    <option value="{$action.layout_action_id}">{$action.name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                        <button type="button" onclick="addModule('content_top');" title="{lang('Admin.button_add')}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div style="height: 150px;"></div>

                                    <table id="module_content_bottom" class="table table-striped table-bordered table-hover mt-3">
                                        <thead>
                                            <tr>
                                                <td class="text-center bg-dark fw-bold"><h3 class="mb-0 text-white">{lang('LayoutAdmin.text_content_bottom')}</h3></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {if !empty($edit_data.modules)}
                                                {foreach $edit_data.modules as $module}
                                                    {if $module.position == 'content_bottom'}
                                                        <tr>
                                                            <td class="text-left">
                                                                <div class="input-group">
                                                                    <select name="modules[content_bottom][]" class="form-control">
                                                                        {if !empty($actions)}
                                                                            {foreach $actions as $action}
                                                                                <option value="{$action.layout_action_id}" {if $action.layout_action_id eq $module.layout_action_id}selected{/if}>{$action.name}</option>
                                                                            {/foreach}
                                                                        {/if}
                                                                    </select>
                                                                    <button type="button" onclick="removeModule(this);" title="{lang('Admin.button_delete')}" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-left">
                                                    <div class="input-group">
                                                        <select class="form-control border-0" style="background-color: #f6f6f6;" disabled>
                                                            <option value=""></option>
                                                            {if !empty($actions)}
                                                                {foreach $actions as $action}
                                                                    <option value="{$action.layout_action_id}">{$action.name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                        <button type="button" onclick="addModule('content_bottom');" title="{lang('Admin.button_add')}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <table id="module_column_right" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center bg-light fw-bold"><h3 class="mb-0">{lang('LayoutAdmin.text_column_right')}</h3></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {if !empty($edit_data.modules)}
                                                {foreach $edit_data.modules as $module}
                                                    {if $module.position == 'column_right'}
                                                        <tr>
                                                            <td class="text-left">
                                                                <div class="input-group">
                                                                    <select name="modules[column_right][]" class="form-control">
                                                                        {if !empty($actions)}
                                                                            {foreach $actions as $action}
                                                                                <option value="{$action.layout_action_id}" {if $action.layout_action_id eq $module.layout_action_id}selected{/if}>{$action.name}</option>
                                                                            {/foreach}
                                                                        {/if}
                                                                    </select>
                                                                    <button type="button" onclick="removeModule(this);" title="{lang('Admin.button_delete')}" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-left">
                                                    <div class="input-group">
                                                        <select class="form-control border-0" style="background-color: #f6f6f6;" disabled>
                                                            <option value=""></option>
                                                            {if !empty($actions)}
                                                                {foreach $actions as $action}
                                                                    <option value="{$action.layout_action_id}">{$action.name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                        <button type="button" onclick="addModule('column_right');" title="{lang('Admin.button_add')}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-12 mt-4 border-top pt-4">
                                    <table id="module_footer_top" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center text-white bg-light fw-bold"><h3 class="mb-0">{lang('LayoutAdmin.text_footer_top')}</h3></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {if !empty($edit_data.modules)}
                                                {foreach $edit_data.modules as $module}
                                                    {if $module.position == 'footer_top'}
                                                        <tr>
                                                            <td class="text-left">
                                                                <div class="input-group">
                                                                    <select name="modules[footer_top][]" class="form-control">
                                                                        {if !empty($actions)}
                                                                            {foreach $actions as $action}
                                                                                <option value="{$action.layout_action_id}" {if $action.layout_action_id eq $module.layout_action_id}selected{/if}>{$action.name}</option>
                                                                            {/foreach}
                                                                        {/if}
                                                                    </select>
                                                                    <button type="button" onclick="removeModule(this);" title="{lang('Admin.button_delete')}" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-left">
                                                    <div class="input-group">
                                                        <select class="form-control border-0" style="background-color: #f6f6f6;" disabled>
                                                            <option value=""></option>
                                                            {if !empty($actions)}
                                                                {foreach $actions as $action}
                                                                    <option value="{$action.layout_action_id}">{$action.name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                        <button type="button" onclick="addModule('footer_top');" title="{lang('Admin.button_add')}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-12 mt-4">
                                    <table id="module_footer_bottom" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center text-white bg-light fw-bold"><h3 class="mb-0">{lang('LayoutAdmin.text_footer_bottom')}</h3></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {if !empty($edit_data.modules)}
                                                {foreach $edit_data.modules as $module}
                                                    {if $module.position == 'footer_bottom'}
                                                        <tr>
                                                            <td class="text-left">
                                                                <div class="input-group">
                                                                    <select name="modules[footer_bottom][]" class="form-control">
                                                                        {if !empty($actions)}
                                                                            {foreach $actions as $action}
                                                                                <option value="{$action.layout_action_id}" {if $action.layout_action_id eq $module.layout_action_id}selected{/if}>{$action.name}</option>
                                                                            {/foreach}
                                                                        {/if}
                                                                    </select>
                                                                    <button type="button" onclick="removeModule(this);" title="{lang('Admin.button_delete')}" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-left">
                                                    <div class="input-group">
                                                        <select class="form-control border-0" style="background-color: #f6f6f6;" disabled>
                                                            <option value=""></option>
                                                            {if !empty($actions)}
                                                                {foreach $actions as $action}
                                                                    <option value="{$action.layout_action_id}">{$action.name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                        <button type="button" onclick="addModule('footer_bottom');" title="{lang('Admin.button_add')}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        {form_close()}
    </div>

    <script type="text/javascript">
        function addRoute() {
            html  = '<div class="input-group mb-2">';
            html += '<input type="text" name="routes[]" class="form-control" value="">';
            html += '<button class="btn btn-sm btn-danger" type="button" onclick="removeRoute(this);" title="{lang('Admin.button_delete')}"><i class="fa fa-minus-circle"></i></button>';
            html += '</div>';

            $('#layout_routes').append(html).fadeIn();
        }

        function removeRoute(obj) {
            $(obj).parent().remove().fadeOut();
        }

        var module_row = 1;

        function addModule(type) {
            html  = '<tr>';
            html += '<td class="text-left">';
            html += '<div class="input-group">';
            html += '<select id="module_row_' + module_row + '" name="modules[' + type + '][]" class="form-control">';
            html += '</select>';
            html += '<button type="button" onclick="removeModule(this);" title="{lang('Admin.button_delete')}" class="btn btn-danger btn-sm"><i class="fa fa fa-minus-circle"></i></button>';
            html += '</div>';
            html += '</td>';
            html += '</tr>';

            $('#module_' + type + ' tbody').append(html);

            $('#module_' + type + ' tbody select[id=\'module_row_' + module_row + '\']').html($('#module_' + type + ' tfoot select').html());

            $('#module_' + type + ' tbody select[id=\'module_row_' + module_row + '\']').val($('#module_' + type + ' tfoot select').val());

            module_row++;
        }

        function removeModule(obj) {
            $(obj).parent().parent().parent().remove().fadeOut();
        }
    </script>
{/strip}
