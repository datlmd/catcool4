<div class="blog-posts mt-5">
    {if !empty($list)}
        {foreach $list as $item}
			<article class="post post-medium">
				<div class="row mb-3">
					<div class="col-lg-5">
						<div class="post-image">
							<a href="blog-post.html">
								<img src="{image_url($item.images)}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="" />
							</a>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="post-content">
							<h2 class="font-weight-semibold pt-4 pt-lg-0 text-5 line-height-4 mb-2"><a href="blog-post.html">{$item.detail.name}</a></h2>
							<p class="mb-0">{$item.detail.description}</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="post-meta">
							<span><i class="far fa-calendar-alt"></i> {$item.publish_date|date_format:config_item('date_format')} </span>
							<span><i class="far fa-user"></i> By <a href="#">John Doe</a> </span>
							<span><i class="far fa-folder"></i> <a href="#">Lifestyle</a>, <a href="#">Design</a> </span>
							<span><i class="far fa-comments"></i> <a href="#">{$item.counter_comment} Comments</a></span>
							<span class="d-block d-sm-inline-block float-sm-right mt-3 mt-sm-0">
								<a href="blog-post.html" class="btn btn-xs btn-light text-1 text-uppercase">Read More</a>
							</span>
						</div>
					</div>
				</div>
			</article>
        {/foreach}
    {/if}
    {include file=get_theme_path('views/inc/paging.tpl')}
</div>