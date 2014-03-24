<?php
/**
 * The Template for displaying all single posts
 */
?>
<?php Theme_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div class="wrapper-content single-wrapper target-wrapper"></div>
	
	<div class="article-spacer"></div>


	<div class="container content-container">

			<div class="content-header">
				<div class="content-header-left">
					<span class="filter">Filter by Stage:</span>
					<select id="category-chooser" class="chosen-select-no-single" tabindex="-1">
						<option value="ALL">ALL</option>
						<option>Utopia Design</option>
						<option>Business Design</option>
						<option>Financial Model</option>
						<option>Strategy Execution</option>
						<option>Positioning</option>
						<option>Operations</option>
						<option>Financial</option>
						<option>Utopia</option>
						<option>Calibrate</option>
					</select>
				</div>
			</div>


			<div class="content-main full-article">
				<div class="content-single">
					<?php if (has_post_thumbnail( $post->ID ) ): ?>
							<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
							<div id="custom-bg" style="background-image: url('<?php echo $image[0]; ?>')">

							</div>
							<div class="header-image">
								<a href="<?php esc_url( the_permalink() ); ?>" 
									title="Permalink to <?php the_title(); ?>" 
									rel="bookmark">
									<span class="image-block" style="background-image: url('<?php echo $image[0]; ?>')"></span></a>
							</div>
						<?php endif; ?>

					<article>

						<div class="title-wrapper">
							<h2><a href="<?php esc_url( the_permalink() ); ?>" 
								title="Permalink to <?php the_title(); ?>" 
								rel="bookmark"><?php the_title(); ?></a></h2>

							<div class="date"><?php the_date( "F j, Y" ); ?> </div>
							<div class="date-spacer"></div>
						</div>

						<!-- <?php get_post_custom_values( 'description' ); ?> -->
							
						<div class="article-body">
							<?php the_content(); ?>
						</div>

						<div class="author-below">&mdash; <?php the_author(); ?></div>	

						<div class="article-links">
							<a class="share-article" href="#"
								data-url="<?php esc_url( the_permalink() ); ?>"
								data-text="<?php the_title(); ?>"
								>Share</a>
						</div>

					</article>

				</div>

			</div>



			<div class="content-footer">
				<div class="content-footer-left">
					<div class="social-media">
						<a href="/feed" target="_blank">&#59194;</a>
<!-- 						<a href="#" target="_blank">&#62220;</a>
						<a href="#" target="_blank">&#62217;</a>
						<a href="#" target="_blank">&#62253;</a>
						<a href="#" target="_blank">&#62232;</a> -->

					</div>

					<div class="text">
						<span class="powered-by">Powered by <a href="http://wearemeasure.com">Measure</a></span>
					</div>
				</div>

				<div class="content-footer-mid">

				</div>

				<div class="content-footer-right">

				</div>
			</div>
		</div>
	</div>

	
</div>

<?php endwhile; ?>

<?php Theme_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>