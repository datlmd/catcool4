var is_country_processing = false;

$(function () {
    if ($('.country-changed').length) {
        $(document).on('change', '.country-changed', function(event) {
            event.preventDefault();
            if (is_country_processing) {
                return false;
            }

            is_country_processing = true;
            var zone = $(this).attr("target_id"); //.zone-changed
            var district = $(zone).attr("target_id"); //.district-changed
            var ward     = $(district).attr("target_id"); //.ward-changed

            $.ajax({
                url: 'countries/api/zones',
                data: {
                    'country_id' : this.value,
                    [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
                },
                type: 'POST',
                success: function (data) {
                    is_country_processing = false;

                    $(zone).removeAttr("disabled").find('option').remove();

                    if (data.token) {
                        // Update CSRF hash
                        $("input[name*='" + csrf_token + "']").val(data.token);
                    }
                    
                    if (data.zones && data.zones != undefined && $(zone).length) {

                        if ($(district).length) {
                            $(district).attr("disabled","disabled").find('option').remove();
                            $(district).append('<option>' + data.none + '</option>');
                        }
    
                        if ($(ward).length) {
                            $(ward).attr("disabled","disabled").find('option').remove();
                            $(ward).append('<option>' + data.none + '</option>');
                        }
                        
                        $.each(data.zones, function(index, value) {
                            $(zone).append('<option value="' + index.replace("_", "") + '">' + value + '</option>');
                            
                        });

                        if ($(zone).hasClass('cc-form-select-single')) {
                            $(zone).select2({
                                theme: "bootstrap-5",
                                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                                placeholder: $( this ).data( 'placeholder' ),
                                selectionCssClass: 'select2--small',
                                dropdownCssClass: 'select2--small',
                            });
                            $(zone).select2('open');
                        }

                    } else {
                        $(zone).attr("disabled", "disabled");
                        $(zone).append('<option>' + data.none + '</option>');
                    }
                },
                error: function (xhr, errorType, error) {
                    console.log(error);
                    is_country_processing = false;
                }
            });
        });
    }
    if ($('.zone-changed').length) {
        $(document).on('change', '.zone-changed', function(event) {
            event.preventDefault();
            if (is_country_processing) {
                return false;
            }

            is_country_processing = true;
            var district = $(this).attr("target_id"); //.district-changed
            var ward     = $(district).attr("target_id"); //.ward-changed

            $.ajax({
                url: 'countries/api/districts',
                data: {
                    'zone_id' : this.value,
                    [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
                },
                type:'POST',
                success: function (data) {
                    is_country_processing = false;

                    $(district).removeAttr("disabled").find('option').remove();

                    if (data.districts && data.districts != undefined && $(district).length) {
                        if ($(ward).length) {
                            $(ward).attr("disabled","disabled").find('option').remove();
                            $(ward).append('<option>' + data.none + '</option>');
                        }

                        $.each(data.districts, function(index, value) {
                            $(district).append('<option value="' + index.replace("_", "") + '">' + value + '</option>');
                        });

                        if ($(district).hasClass('cc-form-select-single')) {
                            $(district).select2({
                                theme: "bootstrap-5",
                                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                                placeholder: $( this ).data( 'placeholder' ),
                                selectionCssClass: 'select2--small',
                                dropdownCssClass: 'select2--small',
                            });
                            $(district).select2('open');
                        }

                    } else {
                        $(district).attr("disabled","disabled");
                        $(district).append('<option>' + data.none + '</option>');
                    }
                },
                error: function (xhr, errorType, error) {
                    console.log(error);
                    is_country_processing = false;
                }
            });
        });
    }
    if ($('.district-changed').length) {
        $(document).on('change', '.district-changed', function(event) {
            event.preventDefault();
            if (is_country_processing) {
                return false;
            }
            is_country_processing = true;
            var ward = $(this).attr("target_id"); //.ward-changed
            $.ajax({
                url: 'countries/api/wards',
                data: {
                    'district_id' : this.value,
                    [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
                },
                type:'POST',
                success: function (data) {
                    is_country_processing = false;

                    $(ward).removeAttr("disabled").find('option').remove();

                    if (data.wards && data.wards != undefined && $(ward).length) {
                        $.each(data.wards, function(index, value) {
                            $(ward).append('<option value="' + index.replace("_", "") + '">' + value + '</option>');
                        });

                        if ($(ward).hasClass('cc-form-select-single')) {
                            $(ward).select2({
                                theme: "bootstrap-5",
                                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                                placeholder: $( this ).data( 'placeholder' ),
                                selectionCssClass: 'select2--small',
                                dropdownCssClass: 'select2--small',
                            });
                            $(ward).select2('open');
                        }

                    } else {
                        $(ward).attr("disabled","disabled");
                        $(ward).append('<option>' + data.none + '</option>');
                    }
                },
                error: function (xhr, errorType, error) {
                    console.log(error);
                    is_country_processing = false;
                }
            });
        });
    }
});
