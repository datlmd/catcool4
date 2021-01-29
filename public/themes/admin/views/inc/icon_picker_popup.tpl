<div id="icon_picker_modal" class="modal fade">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="photoModalLabel"><i class="fas fa-fw fa-columns me-2"></i>Icon Picker</h4>
				<button  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row px-2 mb-3">
					<div class="col-sm-8 col-6">
						<input type="text" id="search_icon_picker" class="form-control" placeholder="Search icon">
					</div>
					<div class="col-sm-4 col-6">
						<button type="button" id="change_icon_picker" class="btn btn-sm btn-space btn-primary w-100"><i class="fa fa-check-circle me-2"></i>{lang('Admin.button_use_icon')}</button>
					</div>
				</div>
				<div>
					<ul class="icon-picker-list">
						<li>
							<a data-class="--item-- --activeState--" data-index="--index--" title="--item--">
								<span class="--item--"></span>
								<span class="name-class">--item--</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
