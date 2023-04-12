<?php 
/*Template Name:Portfolio Page*/
get_header();
?>
<style type="text/css">
  .second_image{display:none;}
</style>
<div class="top_banner_head" style="background-color:#1d1c1c">
	<div class="container">
		<div class="top_banner_head_content">
			<h1><?php echo get_the_title();?></h1>
		</div>
	</div>
</div>
<?php
$posts = new WP_Query( array(
 'post_type' => 'portfolios', 
 'post_status' => 'publish', 
 'posts_per_page' => -1, 
 'orderby' => 'date', 
 'order' => 'ASC',
) );  ?>
<div class="container">
<div class="row">
  <div class="col-lg-12 d-flex justify-content-center">
    <ul id="portfolio-flters">
      <li data="all" class="filter active">All</a></li>
      <?php 
      $categories = get_terms( array(
        'taxonomy' => 'portfolios_category',
        'hide_empty' => false,
        'parent' => 0,
      ) );
      foreach($categories as $category) { 
       $category_link = get_category_link($category->term_id);
       ?>
       <li class="filter" data="<?php echo $category->slug; ?>"><?php echo $category->name; ?></li>
     <?php } ?>
   </ul>
 </div>
</div>
</div>
<div class="projects_section">
  <div class="container"> 
    <div class="row">
      <?php while ($posts->have_posts()) : $posts->the_post(); 
        $cat_slug='';
        $post_id=get_the_ID();
        $categories = get_the_terms($post_id, "portfolios_category");
        $post_title = get_the_title();
        $portfolio_image=wp_get_attachment_url(get_post_thumbnail_id($post_id));
        foreach($categories as $cat){$cat_slug.='cat_'.$cat->slug;}
        $address=get_field('full_address',$post_id);
        $gallery=get_field('gallery',$post_id)[0]['sizes'];
        ?>
        <div class="col-lg-4 col-md-4 cat_all <?php echo $cat_slug; ?>">
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
      <?php endwhile; 
      wp_reset_postdata();?>
    </div>
  </div>
</div>
<div class="container portfolio_content">
  <?php echo get_the_content();?>
</div>
<script type="text/javascript">
  show_property('all');
  jQuery('.filter').click(function(){
    var data=jQuery(this).attr('data');
    show_property(data);
    jQuery('.filter').removeClass('active');
    jQuery(this).addClass('active');
  })
  function show_property(data)
  { 
    if(data=='all')
    {
      jQuery('.cat_all').show();
    }else{
      jQuery('.cat_all').hide();
      jQuery('.cat_'+data).show();
    }
  }
</script>
<?php get_footer(); ?>