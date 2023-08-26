	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-12">
						<div class="site-info">
							<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'chada-base-theme' ) ); ?>">
								<?php
								/* translators: %s: CMS name, i.e. WordPress. */
								printf( esc_html__( 'Proudly powered by %s', 'chada-base-theme' ), 'WordPress' );
								?>
							</a>
							<span class="sep"> | </span>
								<?php
								/* translators: 1: Theme name, 2: Theme author. */
								printf( esc_html__( 'Theme: %1$s by %2$s.', 'chada-base-theme' ), 'chada-base-theme', '<a href="#">Christian</a>' );
								?>
						</div><!-- .site-info -->
				</div>
			</div>
		</div>
	</footer>
</main>

<?php wp_footer(); ?>

</body>
</html>
