<?php

  
  $cat_collection = array(
        'taxonomy'               => 'ice_cream_cat',
        'orderby'                => 'name',
        'order'                  => 'ASC',
        'hide_empty'             => false,
        'include'                => array(),
        'exclude'                => array(),
        'exclude_tree'           => array(),
        'number'                 => '',
        'offset'                 => '',
        'fields'                 => 'all',
        'name'                   => '',
        'slug'                   => '',
        'hierarchical'           => true,
        'search'                 => '',
        'name__like'             => '',
        'description__like'      => '',
        'pad_counts'             => false,
        'get'                    => '',
        'child_of'               => 0,
        'parent'                 => '',
        'childless'              => false,
        'cache_domain'           => 'core',
        'update_term_meta_cache' => true,
        'meta_query'             => ''
    );
 
  $collection_terms = get_terms( $cat_collection );
  
  //print_r($collection_terms);
  
  $i = 1;
  foreach($collection_terms as $collection_terms_data){
 
if($i==1) {
$cls = 'cream_bg home-margin-top';
} else {
$cls = 'padding_v sp_p_padding_hf_h sp_l_padding_hf_h cream_bg';
}
 ?>

<div class="<?php echo $cls; ?>">
  <div class="circle_cream_t">&nbsp;</div>
  <div class="container">
    <div class="page fluid_100 border_b">
      <article class="margin_hf_h">
      <div class="fluid_33 sp_p_hide sp_l_fluid_20 ">&nbsp;</div>
      <div class="fluid_100 sp_p_fluid_100 sp_l_fluid_60">
        <div class="border_b">
          <h2 class="title center"><span><?php echo $collection_terms_data->name; ?></span></h2>
        </div>
      </div>
      <div class="fluid_100">
        <div class=" border_b padding_v margin_b">
          <h5 class="center"><?php echo $collection_terms_data->description; ?></h5>
          
        </div>
      </div>
      <div class="fluid_100 margin_b padding_b">
        <nav class="subs border_h mfp-gallery">
          <ul>
          <?php
		  
		  
     $args = array(
	 'post_type' => 'icecream',
	  'posts_per_page' => -1,
	'tax_query' => array(
		array(
			'taxonomy' => 'ice_cream_cat',
			'field' => 'id',
			'terms' => $collection_terms_data->term_id
		)
	)
);
$query = new WP_Query( $args );
		  
		  
	while ( $query->have_posts() ) : $query->the_post();

	 $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large' );	 
		 
?>


<li class="fluid_20 sp_p_fluid_50 sp_l_fluid_33 tb_p_fluid_25 ls_fluid_16">
              <div class="margin center"> <a data-title="<?php echo get_the_content(); ?>" title="<?php echo get_the_title(); ?>" class="mfp-image" href="<?php echo $large_image_url[0]; ?>"> 
              <img src="<?php echo $large_image_url[0]; ?>" data-other-src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/circles_mask_hover.png" class="mask"> 
              <img src="<?php echo $large_image_url[0]; ?>" alt="<?php echo get_the_title(); ?>" class="img"> </a>
                <h6><?php echo get_the_title(); ?></h6>
              </div>
            </li>
 
<?php 

		// End the loop.
		endwhile;
		 wp_reset_postdata();	  
		   ?>
          
             
          </ul>
        </nav>
        <div class="clear"></div>
      </div>
       
      <div class="clear"></div>
    </div>
    </article>
  </div>
  <div class="clear"></div>
</div>
 
 <?php $i++; } ?>
 
</div>
<div class="clear"></div>







//Second logic


<script type="text/javascript">
  jQuery(".search").keyup(function(){
    var serach=jQuery(this).val();
    if(serach.length>2)
    {
       jQuery('.list_suggest').html();
      jQuery.ajax({
        type:"POST",
        url:"<?php echo admin_url('admin-ajax.php'); ?>",
        data:{action:'search_list',serach:serach},
        dataType:"html",
        success:function(data){
          jQuery(".list_suggest").html(data);
          jQuery('.list_suggest').fadeIn();
        }
      });
    }
  })
</script>

<?php
    function search_list() {
      if(isset($_POST['serach']))
      {
        $serach=$_POST['serach'];
      $args = array(
      'taxonomy'      => array( 'category' ), // taxonomy name
      'orderby'       => 'id', 
      'order'         => 'ASC',
      'hide_empty'    => false,
      'fields'        => 'all',
      'name__like'    => $serach
      ); 
      $terms = get_terms( $args );
      $count = count($terms);
      $html_data='<ul>';
      if($count > 0){
        foreach ($terms as $term) {
        $term_id=$term->slug;
        $title=$term->name;
              $html_data.='<li class="item_list" data="'.$term_id.'" id="'.$title.'">'.$title.'</li>';
        }
      }else
      {
        $html_data.='<li class="item_list" data="" id="">Recored Not Found</li>'; 
      }

      echo "</ul>";
         global $post;
      $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
         's' => esc_attr($serach) 
      );
    $myposts = get_posts( $args );
    $html_data='<ul>';
    $count=count($myposts);
    if($count>=1)
    {
      foreach ( $myposts as $post ) : setup_postdata( $post );
        $title=get_the_title();
        $post_id=get_the_id(); 
        $html_data.='<li class="item_list" data="'.$post_id.'" id="'.$title.'">'.$title.'</li>';
      endforeach; 
    }else
    {
      $html_data.='<li class="item_list" data="" id="">Recored Not Found</li>';
    }
    $html_data.='</ul>';
    echo $html_data;
    ?>
    <script type="text/javascript">
      jQuery('.item_list').click(function(){
        var id=jQuery(this).attr('id');
        var title=jQuery(this).attr('data');
        jQuery('.search').val(id);
        jQuery(".city_list").val(title);
        jQuery('.list_suggest').fadeOut();
    })
    </script>
      <?php  }
      die();
    }
    add_action( 'wp_ajax_search_list', 'search_list' );
    add_action( 'wp_ajax_nopriv_search_list', 'search_list' );
  ?>


  <div class="block">
      <form action="<?php echo site_url().'/search-list/'; ?>" method="GET">
        <?php 
        if(isset($_GET['city']))
        {
          $city=$_GET['city'];
          $cat=$_GET['cat'];
        }
        ?>
        <div class="city_box">
          <input class="search_by_addr city_search" type="text" value="<?php echo $city; ?>" placeholder="City">
          <input type="hidden" name="city" class="city_list" value="<?php echo $city; ?>">
          <div class="city_list_suggest">
          </div>
        </div>
        <div class="cat_box">
          <input class="search_by_addr cat_search" value="<?php echo $cat; ?>" type="text" placeholder="Shop or category" class="search_by_addr">
          <input type="hidden" name="cat" class="cat_list" value="<?php echo $cat; ?>">
          <div class="cat_list_suggest">
          </div>
        </div>
        <input type="submit" name="" value="Search">
      </form>