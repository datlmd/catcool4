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

        dataLayer.push({
            "event": "addToCart",
            "ecommerce": {
                "currencyCode": "USD",
                "add": {
                    "products": [{
                        "id": "57b9d",
                        "name": "Kiosk T-Shirt",
                        "price": "55.00",
                        "brand": "Kiosk",
                        "category": "T-Shirts",
                        "variant": "red",
                        "dimension1": "M",
                        "quantity": 1
                    }]
                }
            }
        });

        gtag('event', 'purchase', {
            "transaction_id": "24.031608523954162",
            "affiliation": "Google online store",
            "value": 23.07,
            "currency": "USD",
            "tax": 1.24,
            "shipping": 0,
            "items": [
                {
                    "id": "P12345",
                    "name": "Android Warhol T-Shirt",
                    "list_name": "Search Results",
                    "brand": "Google",
                    "category": "Apparel/T-Shirts",
                    "variant": "Black",
                    "list_position": 1,
                    "quantity": 2,
                    "price": "2.0"
                },
                {
                    "id": "P67890",
                    "name": "Flame challenge TShirt",
                    "list_name": "Search Results",
                    "brand": "MyBrand",
                    "category": "Apparel/T-Shirts",
                    "variant": "Red",
                    "list_position": 2,
                    "quantity": 1,
                    "price": "3.0"
                }
            ]
        });

        dataLayer.push({
            event: 'eec.purchase',
            ecommerce: {
                currencyCode: 'EUR',
                purchase: {
                    actionField: {
                        id: 'order_id_001',
                        revenue: '11.00'
                    },
                    products: [{
                        id: 'product_id_001',
                        price: '11.00',
                        quantity: 2
                    }]
                }
            }
        });
    </script>
{/literal}
