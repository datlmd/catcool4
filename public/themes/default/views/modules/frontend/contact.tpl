{strip}
    <h1 class="text-start mb-4">{lang('Contact.text_contact')}</h1>

    <div id="map"></div>

    <h3 class="text-start mb-3 border-bottom pb-2">{lang('Contact.text_location')}</h3>
    <div class="row pb-4">
        {if !empty(config_item('store_image'))}
            <div class="col-sm-6 col-md-3 mb-3">
                <img alt="{config_item('store_name')}" class="img-thumbnail" src="{image_thumb_url(config_item('store_image'), 400, 400)}">

            </div>
        {/if}
        <div class="col-sm-6 col-md-3 mb-3">
            <div class="fs-4 text-primary mb-2">{config_item('store_name')}</div>
            <address>
                {config_item('store_address')}
            </address>
            {if config_item('store_geocode')}
                <a href="https://maps.google.com/maps?q={config_item('store_geocode')|urlencode}&hl={get_lang()}&t=m&z=15" target="_blank" class="btn btn-info">
                    <i class="fa-solid fa-location-dot"></i> {lang('Contact.text_google_map')}
                </a>
            {/if}

        </div>

        <div class="col-sm-6 col-md-3 mb-3">
            <strong>{lang('Contact.text_phone')}</strong>
            <br/>
            {config_item('store_phone')}
        </div>

        <div class="col-sm-6 col-md-3">
            {if !empty(config_item('store_open'))}
                <strong>{lang('Contact.text_open')}</strong>
                <br/>
                {config_item('store_open')}
            {/if}
            {if !empty(config_item('store_comment'))}
                <br/>
                <br/>
                <strong>{lang('Contact.text_comment')}</strong>
                <br/>
                {config_item('store_comment')}
            {/if}
        </div>

    </div>

    <h3 class="text-start my-3 border-bottom pb-2">{lang('Contact.text_contact_form')}</h3>
    {form_open(site_url("contact/send"), ["id" => "contact_form", "method" => "post", "data-cc-toggle" => "ajax", "data-alert" => "#contact_alert"])}
        <div id="contact_alert"></div>
        <div class="mb-3">
            <label for="name" class="form-label required-label">{lang('Contact.text_name')}</label>
            <input type="text" class="form-control" name="name"  id="input_name" placeholder="{lang('Contact.text_name_holder')}">
            <div id="error_name" class="invalid-feedback"></div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label required-label">{lang('Contact.text_email')}</label>
            <input type="text" class="form-control" name="email"  id="input_email" placeholder="{lang('Contact.text_email_holder')}">
            <div id="error_email" class="invalid-feedback"></div>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label required-label">{lang('Contact.text_message')}</label>
            <textarea class="form-control" name="message" id="input_message" rows="5" placeholder="{lang('Contact.text_message_holder')}"></textarea>
            <div id="error_message" class="invalid-feedback"></div>
        </div>
        <div class="text-start">
            <button type="submit" class="btn btn-primary px-3">{lang('Contact.text_send')}</button>
        </div>

    {form_close()}
{/strip}
{literal}

{/literal}