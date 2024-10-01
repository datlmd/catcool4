{capture name="lesson_list"}
	{if !empty($lesson_categories.subs)}
		{foreach $lesson_categories.subs as $category}
			<h3>{$category.name}</h3>
			<ul class="list-unstyled">
				{foreach $category.lessons as $lesson}
					<li class="{if $post_id eq $lesson.post_id}active{/if}">
						<a href="{site_url($lesson.detail_url)}">{$lesson.name}</a>
					</li>
				{/foreach}
			</ul>
		{/foreach}
	{else}
		<h3>{$lesson_categories.name}</h3>
		<ul class="list-unstyled">
			{foreach $lesson_categories.lessons as $lesson}
				<li class="{if $post_id eq $lesson.post_id}active{/if}">
					<a href="{site_url($lesson.detail_url)}" class="">{$lesson.name}</a>
				</li>
			{/foreach}
		</ul>
	{/if}
{/capture}
{strip}
	{if !empty($lesson_categories)}
		<div class="lesson-list">
			<div class="d-none {if empty($is_mobile)}d-md-block{/if}">{$smarty.capture.lesson_list}</div>

			<button class="button-menu-detail {if empty($is_mobile)}d-md-none{/if} d-block" data-bs-toggle="offcanvas" data-bs-target="#lesson_list" aria-controls="lesson_list">
				<i class="fas fa-arrows-alt-v"></i>
			</button>
			<div class="offcanvas offcanvas-end" tabindex="-1" id="lesson_list" aria-labelledby="lesson_list_label">
				<div class="offcanvas-header">
					<h5 class="offcanvas-title" id="lesson_list_label"></h5>
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body px-4">
					{$smarty.capture.lesson_list}
				</div>
			</div>
		</div>
	{/if}
{/strip}
