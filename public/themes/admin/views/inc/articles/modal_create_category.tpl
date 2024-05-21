<!-- Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCategoryModalLabel">{lang('add_heading')}</h5>
				<a href="#" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</a>
			</div>
			<div class="modal-body">
				<div id="validation_error" class="text-danger"></div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    {form_open('manage/categories/api_add', ['id' => 'modal_add_data'])}
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label text-sm-end">
								{lang('text_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_input($title)}
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label text-sm-end">
								{lang('text_description')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_textarea($description)}
							</div>
						</div>
						<div class="form-group row text-center">
							<div class="col-12 col-sm-3"></div>
							<div class="col-12 col-sm-8 col-lg-6">
								<input type="hidden" name="content" value="{$content}">
								<button type="button" id="btn_submit_modal" class="btn btn-sm btn-space btn-primary">{lang('button_save')}</button>
								{anchor("`$manage_url`", lang('button_close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-sm btn-space btn-secondary'])}
							</div>
						</div>
                    {form_close()}
				</div>
			</div>
		</div>
	</div>
</div>