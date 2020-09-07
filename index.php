<?php get_header(); ?>

	<!-- main content -->

	<section id="main-content">

		<!-- main posts loop -->
		<section id="posts">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php endwhile; else: ?>

		<?php endif; ?>

		<!-- end posts -->
		</section>

	<!-- end main-content -->

	</section>

<?php get_footer(); ?>