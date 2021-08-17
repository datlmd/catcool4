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
