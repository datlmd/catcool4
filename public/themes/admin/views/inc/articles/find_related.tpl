{strip}
	<div class="input-group" id="related_find">
		<input type="text" name="related" id="related" class="form-control" />
		<button class="input-group-text"><i class="fa fa-search"></i></button>
	</div>
	<div id="related_result" class="mt-4 mb-2" style="max-height: 250px; overflow: scroll; overflow-x: hidden; display: none;"></div>
{/strip}
{literal}
	<script>
		var is_releated_processing = false;
		var logical_off = false;

		var related_url = "{/literal}{$related_url}{literal}";
		var related_text = "";

		$( "#related_find #related" ).keypress(function(e) {
			if (logical_off) {
				return true;
			}

			if(e.which == 32) {
				logical_off = true; // stop keypress function
				setTimeout(function () { // restart keypress function
					logical_off = false;
					searchRelated();
				}, 3000);
			}
		});

		$(document).on('click', "#related_find button", function(e) {
			e.preventDefault();
			searchRelated();
		});

		function searchRelated() {
			if (related_url == "" || related_url == null) {
				return false;
			}
			if (is_releated_processing) {
				return false;
			}
			if (related_text == $("#related").val()) {
				return false;
			}

			related_text = $("#related").val();
			if (related_text != "" && related_text.length < 3) {
				return false;
			}

			is_releated_processing = true;
			$.ajax({
				url: related_url,
				type: 'POST',
				data: {
					related: related_text,
				},
				beforeSend: function () {
					$('#related_find').find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
				},
				complete: function () {
					$('#related_find').find('i').replaceWith('<i class="fa fa-search"></i>');
				},
				success: function (data) {
					is_releated_processing = false;

					var response = JSON.stringify(data);
					response = JSON.parse(response);

					if (response.status == 'ng') {
						$.notify(response.msg, {'type': 'danger'});
						return false;
					}
					$('#related_result').html(response.view).show();
				},
				error: function (xhr, errorType, error) {
					$.notify(xhr.responseJSON.message, {'type': 'danger'});
					is_releated_processing = false;
				}
			});
		}
	</script>
{/literal}
