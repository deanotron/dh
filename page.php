<?php Theme_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php the_post(); ?>

<div class="wrapper-content page-wrapper target-wrapper"></div>

	<div class="container body-container">

		<div class="title-container">

			<h1 class="page-title"><?php echo $cfs->get('page_title_display'); ?></h1>

			<div class="page-description">
				<span>
				<?php echo $cfs->get('description'); ?>
				</span>
			</div>

			<div class="clear"></div>
		</div>


		<div class="container content-container">

			<div class="content-main full-article">
				<div class="content-single">
					<?php if ($post->post_name == 'workshops'): ?>

						<?php 
							$query = new WP_Query( array('post_type' => 'workshop', 'order' => 'ASC') );

							// The Loop
							if ( $query->have_posts() ) {
								while ( $query->have_posts() ) {
									$query->the_post();

									?>


							<div class="workshop-container">

								<div class="info-left">
									<div class="session-num"><?php echo $cfs->get('session_number'); ?></div>
									<div class="session-title"><?php the_title(); ?></div>
									<div class="session-date"><?php echo $cfs->get('session_date'); ?></div>
									<div class="session-info"><?php echo $cfs->get('session_info'); ?></div>
									<div class="session-price"><?php echo $cfs->get('price_string'); ?></div>

									<a class="signup-button"
										href="<?php echo $cfs->get('signup_url'); ?>">
										Sign-Up</a>
								</div>

								<div class="info-right">
									<?php the_content(); ?>
								</div>

								<div class="clear"></div>
							</div>


						<?php 
								}
							} else {
								// no posts found
							}
						?>

					<?php else: ?>

						<article>

							<div class="article-body">
								<?php the_content(); ?>
							</div>

						</article>

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

<a href="<?php echo get_post_type_archive_link( 'workshop' ); ?>">Workshop Archive</a>

<?php Theme_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>