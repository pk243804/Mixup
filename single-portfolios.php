<?php
get_header(); 
$post_id=get_the_ID();
$address=get_field('full_address',$post_id);
?>
<style type="text/css">
	.second_image{display:none;}
</style>
<div class="top_banner_head inner_header">
	<div class="top_banner_head_content">
		<h1><?php echo get_the_title(); ?></h1> 
		<?php if($address!=''){?>
			<p class="address"><svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.5 2.25C3.25934 2.25 2.25 3.25934 2.25 4.5C2.25 5.74067 3.25934 6.75 4.5 6.75C5.74067 6.75 6.75 5.74067 6.75 4.5C6.75 3.25934 5.74067 2.25 4.5 2.25ZM4.5 6C3.67289 6 3 5.32711 3 4.5C3 3.67289 3.67289 3 4.5 3C5.32711 3 6 3.67289 6 4.5C6 5.32711 5.32711 6 4.5 6ZM4.5 0C2.01471 0 0 2.01471 0 4.5C0 6.31437 0.63211 6.82104 4.03753 11.7579C4.26099 12.0807 4.73899 12.0807 4.96249 11.7579C8.36789 6.82104 9 6.31437 9 4.5C9 2.01471 6.98529 0 4.5 0ZM4.5 11.1078C1.23527 6.38644 0.75 6.01158 0.75 4.5C0.75 3.49833 1.14007 2.55663 1.84835 1.84835C2.55663 1.14007 3.49833 0.75 4.5 0.75C5.50167 0.75 6.44337 1.14007 7.15165 1.84835C7.85993 2.55663 8.25 3.49833 8.25 4.5C8.25 6.01149 7.76503 6.38602 4.5 11.1078Z" fill="black" fill-opacity="0.8"></path> </svg> <?php echo $address; ?></p>
		<?php }?>
	</div>
</div>
<div class="projects_section">
<div class="container">
	<div class="image_gallery">
		<div class="row">
			<?php 
			if(get_field('gallery',$post_id)){
				$images = get_field('gallery',$post_id);
				$i=1;
				$total_image=count($images);?>			
				<div class="col-md-8">
					<div class="first_image">
						<a href="<?php echo $portfolio_image=wp_get_attachment_url(get_post_thumbnail_id($post_id)); ?>" data-fancybox="images">
							<img src="<?php echo $portfolio_image=wp_get_attachment_url(get_post_thumbnail_id($post_id)); ?>" />
						</a>
						<div class="single_page worl_list">
				<ul>
					<?php
					$work_list=get_field('work_list',$post_id);
					foreach($work_list as $work){
						?>
						<li><?php echo $work['work_name']; ?></li>
					<?php }?>
				</ul>
			</div>
						<div class="portfolio_details">
							<ul>
								<li><b>ORDER DATE:</b> <?php echo get_field('order_date',$post_id); ?></li>
								<li><b>FINDAL DATE:</b> <?php echo get_field('final_date',$post_id); ?></li>
								<li><b>CLIENT:</b> <?php echo get_field('client',$post_id); ?></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="second_images">
						<a href="<?php echo ($images[0]['url']); ?>" data-fancybox="images">
							<img src="<?php echo ($images[0]['url']); ?>" />
						</a>
					</div>
					<div class="third_image">
						<a href="<?php echo ($images[1]['url']); ?>" data-fancybox="images">
							<img src="<?php echo ($images[1]['url']); ?>" />
							<?php if($total_image-2>=1){?>
								<div class="overlay_effect">
									<span>
										+ <?php echo $total_image-2; ?>
									</span>
								</div>
							<?php }?>
						</a>
					</div>
				</div>
			<?php }else{?>
				<div class="col-md-12">
					<div class="full_image">
						<a href="<?php echo $portfolio_image=wp_get_attachment_url(get_post_thumbnail_id($post_id)); ?>" data-fancybox="images">
							<img src="<?php echo $portfolio_image=wp_get_attachment_url(get_post_thumbnail_id($post_id)); ?>" />
						</a>
						<div class="single_page worl_list">
				<ul>
					<?php
					$work_list=get_field('work_list',$post_id);
					foreach($work_list as $work){
						?>
						<li><?php echo $work['work_name']; ?></li>
					<?php }?>
				</ul>
			</div>
						<div class="portfolio_details">
							<ul>
								<li><b>ORDER DATE:</b> <?php echo get_field('order_date',$post_id); ?></li>
								<li><b>FINDAL DATE:</b> <?php echo get_field('final_date',$post_id); ?></li>
								<li><b>CLIENT:</b> <?php echo get_field('client',$post_id); ?></li>
							</ul>
						</div>
					</div>
				</div>
			<?php }?>
			<div class="remanig_image" style="display:none;">
				<?php for($r=2;$r<$total_image;$r++){?>
					<div class="col-md-4">
						<a href="<?php echo ($images[$r]['url']); ?>" data-fancybox="images">
							<img src="<?php echo ($images[$r]['url']); ?>" />
						</a>
					</div>
				<?php }?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php the_content(); ?>
			</div>
		</div>
	</div> 
	<div class="related_protf">
		<h2>Related Portfolio</h2>
		<div class="row">
			<?php
			global $post;
			$current_post_type = get_post_type( $post );
			$args = array(
				'posts_per_page' => 3,
				'order' => 'DESC',
				'orderby' => 'ID',
				'post_type' => $current_post_type,
				'post__not_in' => array( $post_id)
			);
			$rel_query = new WP_Query( $args );
			while ( $rel_query->have_posts() ) :
				$rel_query->the_post();
				$post_id=get_the_ID();
				$post_title = get_the_title();
				$portfolio_image=wp_get_attachment_url(get_post_thumbnail_id($post_id));
				$address=get_field('full_address',$post_id);
				$gallery=get_field('gallery',$post_id)[0]['sizes'];
				?>
				<div class="col-lg-4 col-md-4">
					<div class="card">
						<a href="<?php echo get_the_permalink(); ?>">
							<div class="portfolio_image">
								<img src="<?php echo $portfolio_image; ?>" class="first_image">
								<?php if($gallery['medium_large']!=''){?>
									<img src="<?php echo $gallery['medium_large']; ?>" class="second_image">
								<?php }?>
							</div>
						</a>
						<div class="Portfolio_worl_list">
							<ul>
								<?php
								$work_list=get_field('work_list',$post_id);
								foreach($work_list as $work){
									?>
									<li><?php echo $work['work_name']; ?></li>
								<?php }?>
							</ul>
						</div>
						<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo $post_title; ?></a></h3><hr>
						<?php if($address!=''){?>
							<p class="address"><svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.5 2.25C3.25934 2.25 2.25 3.25934 2.25 4.5C2.25 5.74067 3.25934 6.75 4.5 6.75C5.74067 6.75 6.75 5.74067 6.75 4.5C6.75 3.25934 5.74067 2.25 4.5 2.25ZM4.5 6C3.67289 6 3 5.32711 3 4.5C3 3.67289 3.67289 3 4.5 3C5.32711 3 6 3.67289 6 4.5C6 5.32711 5.32711 6 4.5 6ZM4.5 0C2.01471 0 0 2.01471 0 4.5C0 6.31437 0.63211 6.82104 4.03753 11.7579C4.26099 12.0807 4.73899 12.0807 4.96249 11.7579C8.36789 6.82104 9 6.31437 9 4.5C9 2.01471 6.98529 0 4.5 0ZM4.5 11.1078C1.23527 6.38644 0.75 6.01158 0.75 4.5C0.75 3.49833 1.14007 2.55663 1.84835 1.84835C2.55663 1.14007 3.49833 0.75 4.5 0.75C5.50167 0.75 6.44337 1.14007 7.15165 1.84835C7.85993 2.55663 8.25 3.49833 8.25 4.5C8.25 6.01149 7.76503 6.38602 4.5 11.1078Z" fill="black" fill-opacity="0.8"></path> </svg> <?php echo $address; ?></p>
						<?php }?>
					</div>
				</div>
			<?php  endwhile;
			wp_reset_postdata(); ?>
		</div>
	</div>
</div>
</div>
<?php 
get_footer();
?>