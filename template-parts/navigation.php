<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'xnique-base-theme' ); ?></a>

<nav class="navbar navbar-expand-md navbar-light bg-light">
	<div class="container">
		<div class="col-3">
			<a class="navbar-brand" href="<?php echo site_url(); ?>">Navbar</a>
		</div>
	
		<div class="col-9">
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="main-menu">
				<?php
					wp_nav_menu(array(
						'theme_location' => 'menu-1',
						'container' => false,
						'menu_class' => '',
						'fallback_cb' => '__return_false',
						'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
						'depth' => 2,
						'walker' => new bootstrap_5_wp_nav_menu_walker()
					));
				?>
			</div>
		</div>
	</div>
</nav>