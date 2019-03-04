<div class="col-md-4">
	<div class="box_pro" style="height: 350px;">
		<div class="price_tag">&#8377;<?php echo $data->price; ?></div>
		<div>
			<a href="<?php echo base_url(); ?>/product?name=<?php echo $data->slug; ?>">
				<img height="156px" width="222px" src="<?php echo base_url(); ?>/images/products/<?php echo $data->product_main_image[0]->image; ?>" alt="">
			</a>
		</div>
		<h1><?php echo $data->name; ?></h1>
		<p><?php echo $data->short_desc; ?></p>
	</div>
</div>