{strip}
	<div id="div_{$related_input_name}" data-url="{$related_url}">
		<div class="input-group related-form">
			<input type="text" name="{$related_input_name}" id="input_{$related_input_name}" class="form-control" onkeypress="relatedKeypress(this);" />
			<button type="button" class="input-group-text" onclick="searchRelated(this);"><i class="fa fa-search"></i></button>
			<div id="error_{$related_input_name}" class="invalid-feedback"></div>
		</div>
		<div class="related-result p-2 bg-light" style="max-height: 250px; overflow: auto; overflow-x: hidden; {if empty($related_list_html)}display: none;{/if}">
			{if !empty($related_list_html)}
				{$related_list_html}
				<hr>
			{/if}
			<div class="related-data"></div>
		</div>
	</div>
{/strip}
