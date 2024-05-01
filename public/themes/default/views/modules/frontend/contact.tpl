{strip}
    <h1 class="text-start mb-4">{lang('Contact.text_contact')}</h1>

    <div id="map"></div>
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