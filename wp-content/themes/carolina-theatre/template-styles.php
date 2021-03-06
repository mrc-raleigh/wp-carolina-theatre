<?php
/**
 * Template Name: Style Tests
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>

<div class="container contain">
	<section>
		<?php 
		// CACHE THE EVENT DROPDOWN / HOMEPAGE EVENT SLIDER FOR 6 HOURS
		// This speeds up page load tremendously

		// $cache_key = 'event_slider_query_cache';
		// if(!$ids = get_transient($cache_key)){
		  date_default_timezone_set('America/New_York');
		  $today = date("Ymd", strtotime('today'));
			$upcoming_event_args = array(
				'fields' => 'ids',
				'post_type' => array('event', 'film'),
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'meta_query'	=> array(
					array (
						'key'		=> 'end_date', // double check that end date hasnt happened yet
						'compare'	=> '>=',
						'value'		=> $today,
					),
				),
				'meta_key' => 'soonest_date', // order by the soonest date (may not be most recent, but close enough)
		    'orderby' => 'meta_value_num', // 'soonest_date' is a number (ie 20180704)
		    'order' => 'ASC',
			);
			$upcoming_event_IDs = new WP_Query($upcoming_event_args);

		  $ids = $upcoming_event_IDs->posts;
		  // set_transient( $cache_key, $ids, 60*60*1 ); // 6 hours = 60*60*6
		// }
		?>

			<?php
				date_default_timezone_set('America/New_York');
			  $today = date("Ymd", strtotime('today'));  
			  $event_term = false;
			  $meta_query = false;
			  if($event_term === "coming-soon" || $event_term === "now-playing") {
				  $meta_query = array(
						'relation' => 'AND',
						array (
							'key'		=> 'end_date', // double check that end date hasnt happened yet
							'compare'	=> '>=',
							'value'		=> $today,
						),
						array (
							'key'		=> 'event_filter_string', // see if event has filter 
							'value'		=> ',film,',
							'compare'	=> 'LIKE',
						)
					);
			  } else if($event_term){
					$meta_query = array(
						'relation' => 'AND',
						array (
							'key'		=> 'end_date', // double check that end date hasnt happened yet
							'compare'	=> '>=',
							'value'		=> $today,
						),
						array (
							'key'		=> 'event_filter_string', // see if event has filter 
							'value'		=> ','.$event_term.',',
							'compare'	=> 'LIKE',
						)
					);
			  } else {
				  $meta_query = array( 
				  	array (
							'key'		=> 'end_date', // double check that end date hasnt happened yet
							'compare'	=> '>=',
							'value'		=> $today,
						) 
				  );
				}

				$upcoming_event_query = new WP_Query(array(
					'post_type' => array('event', 'film'),
					'post__in' => $ids,
					'post_status' => 'publish',
					'posts_per_page' => 10,
					'meta_query'	=> $meta_query,
					'meta_key' => 'soonest_date', // order by the soonest date (may not be most recent, but close enough)
			    'orderby' => 'meta_value_num', // 'soonest_date' is a number (ie 20180704)
			    'order' => 'ASC',
					'paged' => $paged,
				)); 

				if ($upcoming_event_query->have_posts()) { ?>
					<div class="card__wrapper events">

					<?php while ($upcoming_event_query->have_posts()) { $upcoming_event_query->the_post();
						$this_post_id = get_the_ID();

						get_template_part('template-parts/event', 'thumbnail_card');
		  		} // endwhile have_posts upcoming_event_query
		  		?>
		  		</div>
		  		<div class="paginate" id="event-filter-navigation">
			    <?php 
		        $paginate_links = paginate_links( array(
		          'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
		          'total' 			 => $upcoming_event_query->max_num_pages,
		          'current' 		 => max( 1, $paged ),
		          'format'       => '?paged=%#%',
		          'show_all'     => false,
		          'type'         => 'array',
		          'end_size'     => 1,
		          'mid_size'     => 0,
		          'prev_next'    => true,
		          'prev_text'    => '<i class="fas fa-chevron-left"></i>',
		          'next_text'    => '<i class="fas fa-chevron-right"></i>',
		          'add_args'     => false,
		          'add_fragment' => '',
		        ) );

		        $paginate_next       = '';
						$paginate_current    = '1';
						$paginate_prev       = '';
						$paginate_pages			 = '1';

						if($upcoming_event_query->max_num_pages != 0) {
							$paginate_pages = $upcoming_event_query->max_num_pages;
						}

						if (is_array($paginate_links) || is_object($paginate_links)){
							foreach( $paginate_links as $link ) {           
						    if( false !== strpos( $link, 'prev ' ) ){
					        $paginate_prev = $link;
						    } else if( false !== strpos( $link, ' current' ) ){
					        $paginate_current = $link;       
						    } else if( false !== strpos( $link, 'next ' ) ){
					        $paginate_next = $link;
						    }
							}
						}
			    ?>
			    <div class="paginate__prev change-page"><?php echo $paginate_prev; ?></div>
			    <div class="paginate__current"><?php echo 'Page '. $paginate_current . ' of '. $paginate_pages; ?></div>
			    <div class="paginate__next change-page"><?php echo $paginate_next; ?></div>
				</div>
				<?php
				} else {
					echo 'No events at this time';
				} // endif have_posts upcoming_event_query
				wp_reset_postdata();
			?>
		</div>
	</section>


	<section>
		<div class="contain">
			<?php the_content(); ?>
		</div>
	</section>
	
	<section>
		<div class="contain">
			<h5 class="section-title">Heading Text</h5>
			<h1>This is an H1 tag element</h1>
			<p class="h1">This is an .h1 class</p>
			<p class="h1">Bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi. Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque.</p>
			<hr>
			<h2>This is an H2 tag element</h2>
			<p class="h2">This is an .h2 class</p>
			<p class="h2">Bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi. Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque.</p>
			<hr>
			<h3>This is an H3 tag element</h3>
			<p class="h3">This is an .h3 class</p>
			<p class="h3">Bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi. Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque.</p>
			<hr>
			<h4>This is an H4 tag element</h4>
			<p class="h4">This is an .h4 class</p>
			<p class="h4">Bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi. Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque.</p>
			<hr>
			<h5>This is an H5 tag element</h5>
			<p class="h5">This is an .h5 class</p>
			<p class="h5">Bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi. Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque.</p>

		</div>
	</section>

	<section>
		<div class="contain">
			<h5 class="section-title">Paragraph Text</h5>
			<p><strong>When you grow up</strong> in a family that’s half-Italian and half-Lebanese, <em>you’re guaranteed to be 100% obsessed with good food</em>. My earliest memories are of spending time with my great grandmother in the kitchen, helping her prepare the delicious, home-cooked meals that brought everyone together around the table. In our family, food is about so much more than just eating.</p>
			<p>Food is a way to tell the story of life. It is the language of holidays and special occasions, the laughter shared between old friends. Food is the story of how you care for those you love. The food I cook today is a continuation of the story my family began <a href="#" class="link">telling generations ago</a>. I hope that every fresh ingredient and authentically prepared dish that comes from my kitchen makes your own life a little more savory.</p>
			<p class="small">Here is a sample of small paragraph text. It is the language of holidays and special occasions, the laughter shared between old friends. Food is the story of how you care for those you love. </p>
		</div>
	</section>

	<section>
		<div class="contain">
			<h5 class="section-title">Blockquote</h5>
			<blockquote>When you grow up in a family that’s half-Italian and half-Lebanese, you’re guaranteed to be 100% obsessed with good food."</blockquote>
		</div>
	</section>

	<section>
		<div class="contain">
			<h5 class="section-title">List Elements</h5>
				<p>Unordered List</p>
				<ul>
					<li>List Item</li>
					<li>List Item</li>
					<li>List Item</li>
					<li>List Item</li>
					<li>List Item</li>
				</ul>
				<p>Ordered List</p>
				<ol>
					<li>List Item</li>
					<li>List Item</li>
					<li>List Item</li>
					<li>List Item</li>
					<li>List Item</li>
				</ol>
			</div>
	</section>

	<section>
		<div class="contain">
			<a href="#" class="button">Default Button</a>
			<a href="#" class="button secondary">Secondary Button</a>
			<a class="button disabled">Default Disabled</a>
			<a class="button secondary disabled">Secondary Disabled</a>
		</div>
	</section>

	<section>
		<div class="contain">
			<h5 class="section-title">Background Styles</h5>
			<section class="bg-black">
				<h1>Suspendisse Dictum Feugiat Nisl Ut Dapibus. Mauris</h1>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est.</p>

				<p>Bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi. Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque.</p>
			</section>
			<section class="bg-white">
				<h1>Suspendisse Dictum Feugiat Nisl Ut Dapibus. Mauris</h1>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est.</p>

				<p>Bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi. Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque.</p>
			</section>
			<section class="bg-green">
				<h1>Suspendisse Dictum Feugiat Nisl Ut Dapibus. Mauris</h1>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est.</p>

				<p>Bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi. Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque.</p>
			</section>
			<section class="bg-gold">
				<h1>Suspendisse Dictum Feugiat Nisl Ut Dapibus. Mauris</h1>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est.</p>

				<p>Bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio. Proin quis tortor orci. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi. Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque.</p>
			</section>
		</div>
	</section>

	<section>
		<h5 class="section-title">Input Elements</h5>
		<form>
		  <span>
      	<input type="text" name="input-01"/>
        <label for="input-01">Text Input</label>
		  </span>
		  <span>
    		<input type="date" name="input-01"/>
    		<label for="date">Date Picker</label>
			</span>
		  <span>
      	<textarea type="textarea" rows="4" name="input-03"></textarea>
        <label for="input-03">Textarea Message Here</label>
		  </span>
		  <select id="f10" name="select1" size="1">
				<option>one
				</option><option selected="">two (default)
				</option><option>three
				</option>
			</select>
		  <fieldset>
				<div><label for="f3"><input id="f3" type="radio" name="radio" value="1"> Radio button 1</label></div>
				<div><label for="f4"><input id="f4" type="radio" name="radio" value="2" checked=""> Radio button 2 (initially checked)</label></div>
			</fieldset>
			<fieldset>
				<div><label for="f5"><input id="f5" type="checkbox" name="checkbox"> Checkbox 1</label></div>
				<div><label for="f6"><input id="f6" type="checkbox" name="checkbox2" checked=""> Checkbox 2 (initially checked)</label></div>
			</fieldset>
			<input type="submit" value="Submit">
		</form>
	</section>
			
<div class="container contain">

<?php } // endwhile; ?>

<?php get_footer();
