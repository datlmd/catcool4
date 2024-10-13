{strip}
	<div class="product-thumb">
		<div class="image">
			<a href="{$href}"><img src="{$thumb}" alt="{$name}" title="{$name}" class="img-fluid" /></a>
		</div>
		<div class="content">
			<div class="description">
				<h4><a href="{$href}">{$name}</a></h4>
				<p>{$description}</p>
				{if $price}
					<div class="price">
						{if empty($special)}
							<span class="price-new">{$price}</span>
						{else}
							<span class="price-new">{$special}</span> <span class="price-old">{$price}</span>
						{/if}
						{if $tax}
							<span class="price-tax">{$text_tax} {$tax}</span>
						{/if}
					</div>
				{/if}

				{if $review_status and $rating}
					<div class="rating">
						{for $i=1 to 5}
							{if $rating < $i}
								<span class="fa-stack"><i class="far fa-star fa-stack-1x"></i></span>
							{else}
								<span class="fa-stack"><i class=" fas fa-star fa-stack-1x"></i><i class="far fa-star fa-stack-1x"></i></span>
							{/if}
						{/for}
					</div>
				{/if}
			</div>
			<form method="post" data-oc-toggle="ajax" data-oc-load="{$cart}" data-oc-target="#header-cart">
				<div class="button-group">
					<button type="submit" formaction="{$add_to_cart}" data-bs-toggle="tooltip" title="{$button_cart}">
						<i class="fas fa-shopping-cart"></i>
					</button>
					<button type="submit" formaction="{$add_to_wishlist}" data-bs-toggle="tooltip" title="{$button_wishlist}">
						<i class="fas fa-heart"></i>
					</button>
					<button type="submit" formaction="{$add_to_compare}" data-bs-toggle="tooltip" title="{$button_compare}">
						<i class="fas fa-exchange-alt"></i>
					</button>
				</div>
				<input type="hidden" name="product_id" value="{$product_id}" />
				<input type="hidden" name="quantity" value="{$minimum}" />
			</form>
		</div>
	</div>	
{/strip}