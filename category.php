<?php
/**
 * The template for displaying Category Archive pages
 *
 */
?>
<?php Theme_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div class="wrapper-content index-wrapper target-wrapper"></div>

	<div class="container body-container">

		<div class="title-container">

			<h1 class="page-title">KNOW<br>THIS SH!T</h1>

			<div class="page-description">
				<span>
				You know the fundamentals of design, but have you brushed
				up on your business fundamentals? Helpful tips & tricks to
				put you in total control of your financial freedom.
				</span>
			</div>

			<div class="clear"></div>
		</div>


		<div class="ktsmap-container">
			<div id="ktsmap">
				<img class="map-bg" src="<?php echo get_stylesheet_directory_uri(); ?>/img/map-back.png"/>

				<img class="start-here" src="<?php echo get_stylesheet_directory_uri(); ?>/img/Meas_KTS_Web_Nav_StartHere.png"/>

				<div class="guide">Click on any stage to filter content</div>
				<div class="label">
				</div>

				<!-- NODES -->
				<div class="node node-ud" data-slug="utopia-design">Utopia Design</div>
				<div class="node node-bd" data-slug="business-design">Business Design</div>
				<div class="node node-fm" data-slug="financial-model">Financial Model</div>
				<div class="node node-se" data-slug="strategy-execution">Strategy Execution</div>
				<div class="node node-p" data-slug="positioning">Positioning</div>
				<div class="node node-o" data-slug="operations">Operations</div>
				<div class="node node-f" data-slug="financial">Financial</div>
				<div class="node node-u" data-slug="utopia">Utopia</div>
				<div class="node node-c" data-slug="calibrate">Calibrate</div>
			</div>
		</div>




		<div class="container content-container">

			<div class="content-header">
				<div class="content-header-left">
					<span class="filter">Filter by Stage:</span>
					<select id="category-chooser" data-category="<?php echo single_cat_title( '', false ); ?>" class="chosen-select-no-single" tabindex="-1">
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

				<div class="content-header-right">
					<span>Featured Insights</span>
				</div>
			</div>


			<div class="content-main">
				<div class="content-main-left">
					<?php if ( have_posts() ): ?>
						<ol>
						<?php while ( have_posts() ) : the_post(); ?>
							<li>
								<article>
									<h3 class="category">Utopia Design</h3>

									<div class="title-wrapper">
										<h2><a href="<?php esc_url( the_permalink() ); ?>" 
											title="Permalink to <?php the_title(); ?>" 
											rel="bookmark"><?php the_title(); ?></a></h2>

										<div class="author">By <?php the_author(); ?></div>
									</div>


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
									
									<div class="article-body">
										<?php Theme_Utilities::get_first_paragraph(get_the_content()); ?>
									</div>

									<div class="article-links">
										<a href="<?php esc_url( the_permalink() ); ?>">View full article</a>
 										<a class="share-article" href="#"
											data-url="<?php esc_url( the_permalink() ); ?>"
											data-text="<?php the_title(); ?>"
											>Share</a>
									</div>
								</article>
							</li>
						<?php endwhile; ?>
						</ol>

						<div class="more-link"><?php next_posts_link( 'LOAD MORE ...' ); ?></div>

						<?php else: ?>
						<div style="min-height: 800px; padding: 64px; font-size: 25px;"><h2>No posts to display</h2></div>
					<?php endif; ?>
				</div>


				<div class="content-main-right">

					<?php query_posts('category_name=Featured'); ?>
					<?php if ( have_posts() ): ?>
						<ol>
						<?php while ( have_posts() ) : the_post(); ?>
							<li>
								<div class="feature">
									<h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
									<div class="subtitle"><?php echo $cfs->get('tagline'); ?></div>
									<div class="author">By <?php the_author(); ?></div>
								</div>
							</li>
						<?php endwhile; ?>
						</ol>
						<?php else: ?>
						<h2>No posts to display</h2>
					<?php endif; ?>

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
<!-- === END - WRAPPER === -->

<?php Theme_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>