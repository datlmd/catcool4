{strip}

    <div id="newsletter_content">
        <h5 class="text-4 text-color-light mb-2">{lang('Frontend.text_newsletter')|unescape}</h5>
        <p class="text-3 mb-2">{lang('Frontend.text_newsletter_description')}</p>
        <div class="alert alert-danger d-none" id="newsletterError"></div>
        <form id="newsletter_form" action="php/newsletter-subscribe.php" method="POST" class="mw-100">
            <div class="input-group input-group-rounded">
                <input class="form-control form-control-sm bg-light px-4 text-3" placeholder="{lang('General.text_subscribe_email')}" name="newsletterEmail" id="newsletterEmail" type="text">
                <span class="input-group-append">
                    <button class="btn btn-primary text-color-light text-2 py-3 px-4" type="submit"><strong>{lang('General.button_subscribe')|unescape}</strong></button>
                </span>
            </div>
        </form>
    </div>
{/strip}

