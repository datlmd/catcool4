{strip}

    <div id="newsletter_content" class="newsletter-content text-center">
        <h5 class="mb-2 text-white">{lang('Frontend.text_newsletter')|unescape}</h5>
        <p class="mb-2">{lang('Frontend.text_newsletter_description')}</p>
        <div class="alert alert-danger d-none" id="newsletterError"></div>

        <form id="newsletter_form" action="php/newsletter-subscribe.php" method="POST" class="mw-100">
            <div class="input-group input-group-rounded">
                <input class="form-control bg-light px-3 fs-5" placeholder="{lang('General.text_subscribe_email')}" name="newsletterEmail" id="newsletterEmail" type="text">
                <button class="input-group-text bg-secondary py-3 px-3" type="submit"><strong>{lang('General.button_subscribe')|unescape}</strong></button>
            </div>
        </form>
    </div>

{/strip}

