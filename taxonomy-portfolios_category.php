<?php 
/*Template Name:Portfolio Page*/
get_header();
?>
<div class="top_banner_head" style="background-color:#1d1c1c">
	<div class="container">
		<div class="top_banner_head_content">
			<h1>Portfolio</h1>
		</div>
	</div>
</div>
<?php
$term_id=get_queried_object()->term_id;
$posts = new WP_Query( array(
 'post_type' => 'portfolios', 
 'post_status' => 'publish', 
 'posts_per_page' => -1, 
 'orderby' => 'date', 
 'order' => 'ASC',
 'tax_query' => array(
  array(
    'taxonomy' => 'portfolios_category',
    'field' => 'term_id',
    'terms' =>$term_id
  )
)
) );  ?>


     <div class="row">
      <div class="col-lg-12 d-flex justify-content-center">
        <ul id="portfolio-flters">
          <li data-filter="*" class="filter-active"><a href="https://www.go2architect.com/portfolio/">All</a></li>
          <?php 
          $categories = get_terms( array(
            'taxonomy' => 'portfolios_category',
            'hide_empty' => false,
            'parent' => 0,
          ) );
          foreach($categories as $category) { 
           $category_link = get_category_link($category->term_id);
           ?>
           <li class="<?php if($term_id==$category->term_id){echo 'active';}?>"><a href="<?php echo $category_link; ?>"><?php echo $category->name; ?></a></li>
         <?php } ?>
       </ul>
     </div>
   </div>

  <div class="projects_section">
  <div class="container"> 
   <div class="row">
    <?php while ($posts->have_posts()) : $posts->the_post(); 
      $categories = get_the_terms(get_the_ID(), "portfolios_category")[0];
      $cat_name=$categories->name; 
      $post_title = get_the_title();
      $portfolio_image=wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));?>
      <div class="col-lg-4 col-md-4">
        <div class="card">
          <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $portfolio_image; ?>" class="img-fluid"></a>
          <h3><a href="<?php echo get_the_permalink(); ?>"><?php echo $post_title; ?></a></h3>
        </div>
      </div>
    <?php endwhile; 
    wp_reset_postdata();?>
  </div>
</div>
</div>



<div class="container portfolio_content">
  <?php echo get_the_content();?>
</div>




<?php get_footer(); ?>