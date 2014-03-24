
<?php Theme_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div class="wrapper-content index-wrapper target-wrapper"></div>

	<div class="container body-container">

		<div class="title-container">

			<h1 class="page-title"><?php echo get_option('UTL_home_title'); ?></h1>

			<div class="page-description">
				<span>
				<?php echo get_option('UTL_home_label'); ?>
				</span>
			</div>

			<div class="clear"></div>
		</div>


		<div class="ktsmap-container">
			<div id="ktsmap">
				<div class="map-bg">
					<svg id="map-bg-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
						version="1.1" x="0px" y="0px" width="996px" height="341px" viewBox="0 0 809.795 293.486" enable-background="new 0 0 809.795 293.486" xml:space="preserve">
					<g>
						<rect x="694.2" y="149.7" width="3.3" height="45.6" class="style-arrows-svg"/>
						<path d="M88.306 221.701H74.968v3.341h13.338v4.073l10.327-5.961l-10.327-5.962V221.701z M91.649 223 l0.296 0.173l-0.296 0.172V222.981z" class="style-arrows-svg"/>
						<path d="M7.414 0h-3.34v143.298H0l5.961 10.327l5.963-10.327h-4.51V0z M5.961 146.938l-0.172-0.296h0.346 L5.961 146.938z" class="style-arrows-svg"/>
						<path d="M431.32 101.666h-76.518v-4.287l-10.328 5.959l10.328 5.963v-4.293h76.582 c25.225-0.956 43.8 5.1 55.3 17.998c16.329 18.4 14.5 45.4 14.5 45.679h3.301c0.184-1.145 2.105-28.245-15.271-47.874 C477.047 107.1 457.6 100.7 431.3 101.666z" class="style-arrows-svg"/>
						<polygon points="328.4,147 250.3,147 250.3,124.3 246.9,124.3 246.9,147 175.9,147 175.9,163.5 171.3,163.5 177.3,173.8 183.3,163.5 179.3,163.5 179.3,150.3 248.6,150.3 250.3,150.3 325.1,150.3 325.1,163.5 321,163.5 326.9,173.8 332.9,163.5 328.4,163.5" class="style-arrows-svg"/>
						<rect x="694.2" y="247.8" width="3.3" height="45.6" class="style-arrows-svg"/>
						<path d="M250.171 221.701h-13.338v3.341h13.338v4.073l10.325-5.961l-10.325-5.962V221.701z M253.514 223 l0.297 0.173l-0.297 0.172V222.981z" class="style-arrows-svg"/>
						<path d="M421.592 221.701h-13.337v3.341h13.337v4.073l10.327-5.961l-10.327-5.962V221.701z M424.936 223 l0.297 0.173l-0.297 0.172V222.981z" class="style-arrows-svg"/>
						<path d="M594.781 221.701h-13.336v3.341h13.336v4.073l10.327-5.961l-10.327-5.962V221.701z M598.124 223 l0.299 0.173l-0.299 0.172V222.981z" class="style-arrows-svg"/>
						<path d="M809.795 223.154l-10.326-5.962v4.509h-13.338v3.341h13.338v4.073L809.795 223.154z M802.811 223 l0.299 0.173l-0.299 0.172V222.981z" class="style-arrows-svg"/>
					</g>
					</svg>

				</div>

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
									<?php 
										$categoryName = "Utopia";
										$categories = wp_get_post_categories( $post->ID );
										if (count($categories) > 0){
											$categoryName = get_category( $categories[0] )->name;
											if ($categoryName == 'Featured' && count($categories) > 1){
												$categoryName = get_category( $categories[1] )->name;
											}
										}
										?>

									<h3 class="category"><?php echo $categoryName; ?></h3>
									

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
						<h2>No posts to display</h2>
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

<?php Theme_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>