var is_country_processing = false;

$(function () {
    if ($('.country-changed').length && $('.province-changed').length) {
        $(document).on('change', '.country-changed', function(event) {
            event.preventDefault();
            if (is_country_processing) {
                return false;
            }
            is_country_processing = true;
            var province = $(this).attr("target_id"); //.province-changed
            var district = $(province).attr("target_id"); //.district-changed
            var ward     = $(district).attr("target_id"); //.ward-changed

            $.ajax({
                url: 'countries/provinces',
                data: {'country_id' : this.value},
                type:'POST',
                success: function (data) {
                    is_country_processing = false;
                    $(province).removeAttr("disabled").find('option').remove();
                    var response = JSON.stringify(data);
                    response = JSON.parse(response);

                    if ($(district).length) {
                        $(district).attr("disabled","disabled").find('option').remove();
                        $(district).append('<option>' + response.none + '</option>');
                    }

                    if ($(ward).length) {
                        $(ward).attr("disabled","disabled").find('option').remove();
                        $(ward).append('<option>' + response.none + '</option>');
                    }

                    if (response.status == 'ng') {
                        $(province).attr("disabled","disabled");
                        $(province).append('<option>' + response.none + '</option>');
                        return false;
                    }
                    if (response.provinces != null) {
                        $.each(response.provinces, function(index, value) {
                            $(province).append('<option value="' + index.replace("_", "") + '">' + value + '</option>');
                        });
                    }
                },
                error: function (xhr, errorType, error) {
                    is_country_processing = false;
                }
            });
        });
    }
    if ($('.province-changed').length && $('.district-changed').length) {
        $(document).on('change', '.province-changed', function(event) {
            event.preventDefault();
            if (is_country_processing) {
                return false;
            }
            is_country_processing = true;
            var district = $(this).attr("target_id"); //.district-changed
            var ward     = $(district).attr("target_id"); //.ward-changed
            $.ajax({
                url: 'countries/districts',
                data: {'province_id' : this.value},
                type:'POST',
                success: function (data) {
                    is_country_processing = false;
                    $(district).removeAttr("disabled").find('option').remove();
                    var response = JSON.stringify(data);
                    response = JSON.parse(response);

                    if ($(ward).length) {
                        $(ward).attr("disabled","disabled").find('option').remove();
                        $(ward).append('<option>' + response.none + '</option>');
                    }

                    if (response.status == 'ng') {
                        $(district).attr("disabled","disabled");
                        $(district).append('<option>' + response.none + '</option>');
                        return false;
                    }
                    if (response.districts != null) {
                        $.each(response.districts, function(index, value) {
                            $(district).append('<option value="' + index.replace("_", "") + '">' + value + '</option>');
                        });
                    }
                },
                error: function (xhr, errorType, error) {
                    is_country_processing = false;
                }
            });
        });
    }
    if ($('.district-changed').length && $('.ward-changed').length) {
        $(document).on('change', '.district-changed', function(event) {
            event.preventDefault();
            if (is_country_processing) {
                return false;
            }
            is_country_processing = true;
            var ward = $(this).attr("target_id"); //.ward-changed
            $.ajax({
                url: 'countries/wards',
                data: {'district_id' : this.value},
                type:'POST',
                success: function (data) {
                    is_country_processing = false;
                    $(ward).removeAttr("disabled").find('option').remove();
                    var response = JSON.stringify(data);
                    response = JSON.parse(response);
                    if (response.status == 'ng') {
                        $(ward).attr("disabled","disabled");
                        $(ward).append('<option>' + response.none + '</option>');
                        return false;
                    }
                    if (response.wards != null) {
                        $.each(response.wards, function(index, value) {
                            $(ward).append('<option value="' + index.replace("_", "") + '">' + value + '</option>');
                        });
                    }
                },
                error: function (xhr, errorType, error) {
                    is_country_processing = false;
                }
            });
        });
    }
});
