<?php
add_action( 'wp_footer', 'my_action_javascript' );

function my_action_javascript() { ?>
	<script type="text/javascript" >
		jQuery(document).ready(function($) {

			var page_count = '<?php echo ceil(wp_count_posts('post')->publish / 2); ?>';
			// alert(page_count);
			
			var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
				var page = 1;

			jQuery('#load_more').click(function(){
				var data = {
				'action' : 'my_action',
				'page' : page
			};

			jQuery.post(ajaxurl, data, function(response) {
				jQuery('#home-posts-data').append(response);

				if(page_count == page){
					jQuery('#load_more').hide();
				}
				page = page + 1;
				// alert('Got this from server' + response);
			});

		});
		});
		</script> <?php 
}


//** Add action for AJAX request */ 

add_action('wp_ajax_my_action', 'my_action');
add_action('wp_ajax_nopriv_my_action', 'my_action');

function my_action() {
	
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => get_option('posts_per_page'),
		'paged' => $_POST['page']
		// 'paged' => 1
	
	);
	
	$posts = new WP_Query($args);
	
					if ($posts->have_posts() ) {
						echo '<div id="home-posts-data">';
                        while ( $posts->have_posts() ) : $posts->the_post(); 
                        $posts->the_post();
                        
                            get_template_part( 'template-parts/content', get_post_type() );
                        
                        endwhile;
                        echo '</div>';
                    
					}
                        else {
							echo'No More Posts Found';
                            // get_template_part( 'template-parts/content', 'none' );
						}
                        
					wp_reset_postdata();

					wp_die();
}
