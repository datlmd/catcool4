<div style="min-height: 500px; padding: 40px;">
    {$val}
</div>

{literal}

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VLRL96LWF0"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-VLRL96LWF0');
    </script>

    <script>
        dataLayer = [];
        user_id = 1012828603;
        user_sex = 1;

        // purchase event
        ga_is_purchase_event        = true;
        ga_purchase_event_value     = {/literal}{$val}{literal};
        ga_purchase_event_coupon    = "FIRE_first_free";
        ga_purchase_event_items     = [{"item_id":"gacha_2118_1","item_name":"8\u6708FIRE \u590f\u7a7a\u306b\u604b\u3057\u3066","quantity":"1","discount":"300","price":"300","item_category":"gacha","item_category2":"FIRE","item_category3":"","item_category4":"","item_category5":""}];


        dataLayer.push({'user_id': user_id});
        dataLayer.push({'user_sex': user_sex});

        // push purchase event
        if (ga_is_purchase_event) {
            dataLayer.push({
                'event': 'purchase',
                'ecommerce': {
                    'value': ga_purchase_event_value,
                    'coupon': ga_purchase_event_coupon,
                    'items': ga_purchase_event_items
                }
            });
        }

    </script>
{/literal}
