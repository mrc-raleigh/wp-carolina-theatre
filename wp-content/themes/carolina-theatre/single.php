<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


<section class="mainContent contain">
  <div class="mainContent__content">
    <div class="container">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				echo get_the_date('F j');
				the_title();
				the_content();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				the_post_navigation( array(
					'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'carolinatheatre' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'carolinatheatre' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . carolinatheatre_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'carolinatheatre' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'carolinatheatre' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . carolinatheatre_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
				) );

			endwhile; // End of the loop.
			?>
		</div>
	</div>
	<?php get_sidebar(); ?>
</section>

	

<?php get_footer();
