var is_country_processing = false;

$(function () {
    
    var zone = [];
    var district = [];

    function openSelect(element)
    {
        if ($(element).hasClass('cc-form-select-single')) {
            $(element).select2();

            $(element).select2({
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                selectionCssClass: 'select2--small',
                dropdownCssClass: 'select2--small',
            });

            if ($(element).data('is-open')) {
                $(element).select2('open');
            }
        }
    }

    if ($('.country-changed').length) {
        $(document).on('change', '.country-changed', function(event) {
            event.preventDefault();
            
            if (is_country_processing) {
                return false;
            }

            is_country_processing = true;

            var element = this;

            $(element).prop('disabled', true);
            
            var element_zone = $(element).data("target"); //.zone-changed

            $(element_zone).prop('disabled', false);

            //var district = $(zone).attr("target_id"); //.district-changed
            //var ward     = $(district).attr("target_id"); //.ward-changed

            if (!zone[$(element).val()]) {

                $.ajax({
                    url: 'countries/api/zones',
                    data: {
                        'country_id' : this.value,
                        [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function (json) {
                        is_country_processing = false;

                        zone[$(element).val()] = json;

                        if (json.token) {
                            // Update CSRF hash
                            $("input[name*='" + csrf_token + "']").val(json.token);
                        }

                        html = '';

                        $(element_zone).html("");

                        if (json.zones && json.zones != undefined && json.zones.length != 0) {
                            $.each(json.zones, function(index, value) {
              
                                html += '<option value="' + index.replace("_", "") + '"';
        
                                if (index.replace("_", "") == $(element).attr('data-zone-id')) {
                                    html += ' selected';
                                }
        
                                html += '>' + value + '</option>';
                            }); 

                            $(element_zone).prop('disabled', false);

                            $(element_zone).html(html);

                            openSelect(element_zone);

                        } else {
                            html += '<option value=0>' + json.none + '</option>';

                            $(element_zone).html(html);

                            $(element_zone).prop('disabled', true);
                        }

                        var element_district = $(element_zone).data("target");
                        if ($(element_district).length) {
                            $(element_district).prop('disabled', true).find('option').remove();
                            $(element_district).append('<option>' + json.none + '</option>');
                        }
                        
                        if ($($(element_district).data("target")).length) {
                            $($(element_district).data("target")).prop('disabled', true).find('option').remove();
                            $($(element_district).data("target")).append('<option>' + json.none + '</option>');
                        }
                
                        $(element).prop('disabled', false);                        
                    },
                    error: function (xhr, errorType, error) {
                        console.log(error + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        is_country_processing = false;
                    }
                });

            } else {
                is_country_processing = false;

                html = '';
                
                $(element_zone).html("");

                if (zone[$(element).val()].zones && zone[$(element).val()].zones != undefined && zone[$(element).val()].zones.length != 0) {
                    $.each(zone[$(element).val()].zones, function(index, value) {
                        html += '<option value="' + index.replace("_", "") + '"';

                        if (index.replace("_", "") == $(element).attr('data-zone-id')) {
                            html += ' selected';
                        }

                        html += '>' + value + '</option>';
                    });

                    $(element_zone).html(html);

                    $(element_zone).prop('disabled', false);

                    openSelect(element_zone);
                } else {
                    html = '<option value=0>' + zone[$(element).val()].none + '</option>';

                    $(element_zone).html(html);

                    $(element_zone).prop('disabled', true);
                }

                $(element).prop('disabled', false);

                //$('select[name$=\'[country_id]\']:disabled:first').trigger('change');
            }

        });
    }
    if ($('.zone-changed').length) {
        $(document).on('change', '.zone-changed', function(event) {
            event.preventDefault();
            if (is_country_processing) {
                return false;
            }

            is_country_processing = true;

            var element = this;

            $(element).prop('disabled', true);

            var element_district = $(element).data("target"); //.district-changed

            $(element_district).prop('disabled', false);

            if (!district[$(element).val()]) {

                $.ajax({
                    url: 'countries/api/districts',
                    data: {
                        'zone_id' : this.value,
                        [$("input[name*='" + csrf_token + "']").attr('name')] : $("input[name*='" + csrf_token + "']").val()
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function (json) {
                        is_country_processing = false;

                        district[$(element).val()] = json;

                        if (json.token) {
                            // Update CSRF hash
                            $("input[name*='" + csrf_token + "']").val(json.token);
                        }

                        html = '';

                        $(element_district).html("");

                        if (json.districts && json.districts != undefined && json.districts.length != 0) {
                            $.each(json.districts, function(index, value) {
              
                                html += '<option value="' + index.replace("_", "") + '"';
        
                                if (index.replace("_", "") == $(element).attr('data-district-id')) {
                                    html += ' selected';
                                }
        
                                html += '>' + value + '</option>';
                            }); 

                            $(element_district).prop('disabled', false);

                            $(element_district).html(html);

                            openSelect(element_district);

                        } else {
                            html += '<option value=0>' + json.none + '</option>';

                            $(element_district).html(html);

                            $(element_district).prop('disabled', true);
                        }

                        var element_ward = $(element_district).data("target");

                        if ($(element_ward).length) {
                            $(element_ward).prop('disabled', true).find('option').remove();
                            $(element_ward).append('<option>' + json.none + '</option>');
                        }
                
                        $(element).prop('disabled', false);                        
                    },
                    error: function (xhr, errorType, error) {
                        console.log(error + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        is_country_processing = false;
                    }
                });

            } else {
                is_country_processing = false;

                html = '';
                
                $(element_district).html("");

                if (district[$(element).val()].districts && district[$(element).val()].districts != undefined && district[$(element).val()].districts.length != 0) {
                    $.each(district[$(element).val()].districts, function(index, value) {
                        html += '<option value="' + index.replace("_", "") + '"';

                        if (index.replace("_", "") == $(element).attr('data-district-id')) {
                            html += ' selected';
                        }

                        html += '>' + value + '</option>';
                    });

                    $(element_district).html(html);

                    $(element_district).prop('disabled', false);

                    openSelect(element_district);
                } else {
                    html = '<option value=0>' + district[$(element).val()].none + '</option>';

                    $(element_district).html(html);

                    $(element_district).prop('disabled', true);
                }

                $(element).prop('disabled', false);

            }

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
