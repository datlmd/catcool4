var is_processing = false;

$(function () {
    if ($('.country-changed').length && $('.province-changed').length) {
        $(document).on('change', '.country-changed', function(event) {
            event.preventDefault();
            if (is_processing) {
                return false;
            }
            is_processing = true;
            $.ajax({
                url: 'countries/provinces',
                data: {'country_id' : this.value},
                type:'POST',
                success: function (data) {
                    is_processing = false;
                    $('.province-changed').removeAttr("disabled").find('option').remove();
                    var response = JSON.stringify(data);
                    response = JSON.parse(response);

                    if ($('.district-changed').length) {
                        $('.district-changed').attr("disabled","disabled").find('option').remove();
                        $('.district-changed').append('<option>' + response.none + '</option>');
                    }

                    if ($('.ward-changed').length) {
                        $('.ward-changed').attr("disabled","disabled").find('option').remove();
                        $('.ward-changed').append('<option>' + response.none + '</option>');
                    }

                    if (response.status == 'ng') {
                        $('.province-changed').attr("disabled","disabled");
                        $('.province-changed').append('<option>' + response.none + '</option>');
                        return false;
                    }
                    if (response.provinces != null) {
                        $.each(response.provinces, function(index, value) {
                            $('.province-changed').append('<option value="' + index.replace("_", "") + '">' + value + '</option>');
                        });
                    }
                },
                error: function (xhr, errorType, error) {
                    is_processing = false;
                }
            });
        });
    }
    if ($('.province-changed').length && $('.district-changed').length) {
        $(document).on('change', '.province-changed', function(event) {
            event.preventDefault();
            if (is_processing) {
                return false;
            }
            is_processing = true;
            $.ajax({
                url: 'countries/districts',
                data: {'province_id' : this.value},
                type:'POST',
                success: function (data) {
                    is_processing = false;
                    $('.district-changed').removeAttr("disabled").find('option').remove();
                    var response = JSON.stringify(data);
                    response = JSON.parse(response);

                    if ($('.ward-changed').length) {
                        $('.ward-changed').attr("disabled","disabled").find('option').remove();
                        $('.ward-changed').append('<option>' + response.none + '</option>');
                    }

                    if (response.status == 'ng') {
                        $('.district-changed').attr("disabled","disabled");
                        $('.district-changed').append('<option>' + response.none + '</option>');
                        return false;
                    }
                    if (response.districts != null) {
                        $.each(response.districts, function(index, value) {
                            $('.district-changed').append('<option value="' + index.replace("_", "") + '">' + value + '</option>');
                        });
                    }
                },
                error: function (xhr, errorType, error) {
                    is_processing = false;
                }
            });
        });
    }
    if ($('.district-changed').length && $('.ward-changed').length) {
        $(document).on('change', '.district-changed', function(event) {
            event.preventDefault();
            if (is_processing) {
                return false;
            }
            is_processing = true;
            $.ajax({
                url: 'countries/wards',
                data: {'district_id' : this.value},
                type:'POST',
                success: function (data) {
                    is_processing = false;
                    $('.ward-changed').removeAttr("disabled").find('option').remove();
                    var response = JSON.stringify(data);
                    response = JSON.parse(response);
                    if (response.status == 'ng') {
                        $('.ward-changed').attr("disabled","disabled");
                        $('.ward-changed').append('<option>' + response.none + '</option>');
                        return false;
                    }
                    if (response.wards != null) {
                        $.each(response.wards, function(index, value) {
                            $('.ward-changed').append('<option value="' + index.replace("_", "") + '">' + value + '</option>');
                        });
                    }
                },
                error: function (xhr, errorType, error) {
                    is_processing = false;
                }
            });
        });
    }
});
