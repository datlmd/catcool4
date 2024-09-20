{strip}
	<div class="card mb-3">
		<div class="float-none" style="margin-bottom: -22px;"><div type="button" class="btn-close float-end p-2" disabled aria-label="Close"></div></div>
		<div class="row g-0" >
			{if !empty($content.meta.image.value)}
				<div class="col-md-3">
					<img src="{$content.meta.image.value}" class="img-fluid rounded-start" alt="{$content.title}">
				</div>
			{/if}
			<div {if !empty($content.meta.image.value)}class="col-md-8"{/if}>
				<div class="card-body">
					<h5 class="card-title">{$content.title}</h5>
					<p class="card-text">{$content.meta.description.value}</p>
					<p class="card-text"><small class="text-muted">- {$content.meta.keywords.value} {$content.meta.news_keywords.value}</small></p>
					<a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
				</div>
			</div>
		</div>
	</div>
{/strip}
