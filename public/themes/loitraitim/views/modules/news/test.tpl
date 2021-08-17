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

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-W8TSFFW');</script>
    <!-- End Google Tag Manager -->

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8TSFFW"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

{/literal}
{if $val < 300}
    {literal}
        <script>
            dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
            dataLayer.push({
              event: "purchase",
              ecommerce: {
                  transaction_id: "T12345",
                  affiliation: "Online Store",
                  value: "59.89",
                  tax: "4.90",
                  shipping: "5.99",
                  currency: "EUR",
                  coupon: "SUMMER_SALE",
                  items: [{
                    item_name: "Triblend Android T-Shirt",
                    item_id: "12345",
                    price: "15.25",
                    item_brand: "Google",
                    item_category: "Apparel",
                    item_variant: "Gray",
                    quantity: 1
                  }, {
                    item_name: "Donut Friday Scented T-Shirt",
                    item_id: "67890",
                    price: 33.75,
                    item_brand: "Google",
                    item_category: "Apparel",
                    item_variant: "Black",
                    quantity: 1
                  }]
              }
            });
        </script>
    {/literal}
{else}
    {literal}
        <script>
            dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
            dataLayer.push({
                event: "purchase",
                ecommerce: {
                    affiliation: "Online Store 3",
                    value: "59.89",
                    tax: "4.90",
                    shipping: "5.99",
                    currency: "EUR",
                    coupon: "SUMMER_SALE",
                    items: [{
                        item_name: "Triblend Android T-Shirt 33",
                        item_id: "12345",
                        price: "15.25",
                        item_brand: "Google",
                        item_category: "Apparel",
                        item_variant: "Gray",
                        quantity: 1
                    }, {
                        item_name: "Donut Friday Scented T-Shirt 44",
                        item_id: "67890",
                        price: 33.75,
                        item_brand: "Google",
                        item_category: "Apparel",
                        item_variant: "Black",
                        quantity: 1
                    }]
                }
            });
        </script>
    {/literal}
{/if}

{*dataLayer = [];*}
{*user_id = 1012828603;*}
{*user_sex = 1;*}

{*// purchase event*}
{*ga_is_purchase_event        = true;*}
{*ga_purchase_event_value     = {/literal}{$val}{literal};*}
{*ga_purchase_event_coupon    = "FIRE_first_free";*}
{*ga_purchase_event_items     = [{"item_id":"gacha_2118_1","item_name":"8\u6708FIRE \u590f\u7a7a\u306b\u604b\u3057\u3066","quantity":"1","discount":"300","price":"300","item_category":"gacha","item_category2":"FIRE","item_category3":"","item_category4":"","item_category5":""}];*}


{*dataLayer.push({'user_id': user_id});*}
{*dataLayer.push({'user_sex': user_sex});*}

{*// push purchase event*}
{*if (ga_is_purchase_event) {*}
{*dataLayer.push({*}
{*'event': 'purchase',*}
{*'ecommerce': {*}
{*'value': ga_purchase_event_value,*}
{*'coupon': ga_purchase_event_coupon,*}
{*'items': ga_purchase_event_items*}
{*}*}
{*});*}
{*}*}