<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JM-theme
 */

get_header();
?>
    $args = array(
	'post_type' => 'post',
	'posts_per_page' => get_option('posts_per_page'),
	// 'paged' => 1
);
$posts = new WP_Query($args);

?>
    <div class="home-main">
		<div class="row ml-0 mr-0">
		  <main id="primary" class="site-main col-8">
			<div id="home-posts-data" class="home-posts">
				<?php
					if ($posts->have_posts() ) :

					if ( is_home() && ! is_front_page() ) :
					?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
					<?php
						endif;

						/* Start the Loop */
						while ($posts->have_posts() ) :
							$posts->the_post();

							get_template_part( 'template-parts/content', get_post_type() );

						endwhile;

						// the_posts_pagination();

						else :

						// get_template_part( 'template-parts/content', 'none' );

						endif;
					?>
			</div>
			<button id="load_more" class="btn btn-primary mt-3 mb-3 btn-lg">Load More</button>
		 </main><!-- #main -->
		 
		 <div class="home-sidebar col-4">
			<?php get_sidebar();?> 
        </div>
		</div>
		</div>
		
	</div>
<?php
// get_sidebar();
get_footer();
