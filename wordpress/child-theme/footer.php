<?php
/**
 * Harbour Island Insider — footer.php
 *
 * @package harbour-island-insider
 */
?>

<!-- ============================================================
     SITE FOOTER
     ============================================================ -->
<footer class="footer" role="contentinfo">
	<div class="container">
		<div class="footer-grid">

			<!-- ── Column 1: Blog brand + social ── -->
			<div class="footer-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo-link" rel="home">
					<div class="resort-name"><?php bloginfo( 'name' ); ?></div>
					<div class="resort-sub">Independent Travel Blog &middot; Bahamas</div>
				</a>
				<p>
					<?php esc_html_e( 'An independent guide to Harbour Island — honest reviews, local knowledge, and everything you need for a perfect trip to one of the world\'s most beautiful islands.', 'harbour-island-insider' ); ?>
				</p>
				<p class="footer-disclosure">
					<strong><?php esc_html_e( 'Disclosure:', 'harbour-island-insider' ); ?></strong>
					<?php esc_html_e( 'We partner with Valentines Resort &amp; Marina as a featured sponsor. We only recommend what we genuinely believe in.', 'harbour-island-insider' ); ?>
					<a href="<?php echo esc_url( home_url( '/editorial-policy/' ) ); ?>"><?php esc_html_e( 'Editorial policy &rarr;', 'harbour-island-insider' ); ?></a>
				</p>

				<!-- Social icons from Social nav menu -->
				<?php
				if ( has_nav_menu( 'social' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'social',
						'container'      => 'div',
						'container_class' => 'footer-socials',
						'menu_class'     => 'footer-social-list',
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>',
						'depth'          => 1,
						'fallback_cb'    => false,
					) );
				} else {
					?>
					<div class="footer-socials">
						<a href="#" class="footer-social-btn" aria-label="<?php esc_attr_e( 'Facebook', 'harbour-island-insider' ); ?>">f</a>
						<a href="#" class="footer-social-btn" aria-label="<?php esc_attr_e( 'Instagram', 'harbour-island-insider' ); ?>">&#128247;</a>
						<a href="#" class="footer-social-btn" aria-label="<?php esc_attr_e( 'YouTube', 'harbour-island-insider' ); ?>">&#9654;</a>
						<a href="#" class="footer-social-btn" aria-label="<?php esc_attr_e( 'X / Twitter', 'harbour-island-insider' ); ?>">&#120143;</a>
					</div>
					<?php
				}
				?>
			</div><!-- /.footer-brand -->

			<!-- ── Column 2: Quick Links (Footer nav menu) ── -->
			<div class="footer-col">
				<h5><?php esc_html_e( 'Quick Links', 'harbour-island-insider' ); ?></h5>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => '',
					'depth'          => 1,
					'fallback_cb'    => function() {
						echo '<ul>';
						$links = array(
							home_url( '/where-to-stay/' ) => 'Where to Stay',
							home_url( '/?cat=food-drink' ) => 'Food &amp; Drink',
							home_url( '/?cat=diving' )    => 'Diving &amp; Snorkelling',
							home_url( '/?cat=beach' )     => 'Pink Sand Beach',
							home_url( '/?cat=marina-sailing' ) => 'Marina Life',
							home_url( '/?cat=travel-tips' ) => 'Getting Here',
							home_url( '/about/' )         => 'About This Blog',
						);
						foreach ( $links as $url => $label ) {
							echo '<li><a href="' . esc_url( $url ) . '">' . $label . '</a></li>';
						}
						echo '</ul>';
					},
				) );
				?>
			</div><!-- /.footer-col -->

			<!-- ── Column 3: Island Info (hardcoded) ── -->
			<div class="footer-col">
				<h5><?php esc_html_e( 'Island Info', 'harbour-island-insider' ); ?></h5>
				<ul>
					<li>
						<a href="<?php echo esc_url( home_url( '/?cat=travel-tips' ) ); ?>">
							<?php esc_html_e( 'Best Time to Visit', 'harbour-island-insider' ); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( home_url( '/?cat=travel-tips' ) ); ?>">
							<?php esc_html_e( 'Getting There', 'harbour-island-insider' ); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( home_url( '/?cat=beach' ) ); ?>">
							<?php esc_html_e( 'Pink Sand Beach', 'harbour-island-insider' ); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( home_url( '/?cat=marina-sailing' ) ); ?>">
							<?php esc_html_e( 'Marina &amp; Docking', 'harbour-island-insider' ); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( home_url( '/?cat=diving' ) ); ?>">
							<?php esc_html_e( 'Diving &amp; Snorkelling', 'harbour-island-insider' ); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( home_url( '/?cat=food-drink' ) ); ?>">
							<?php esc_html_e( 'Food &amp; Restaurants', 'harbour-island-insider' ); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( home_url( '/editorial-policy/' ) ); ?>">
							<?php esc_html_e( 'Editorial Policy', 'harbour-island-insider' ); ?>
						</a>
					</li>
				</ul>
			</div><!-- /.footer-col -->

			<!-- ── Column 4: Featured Partner ── -->
			<div class="footer-col">
				<h5><?php esc_html_e( 'Featured Partner', 'harbour-island-insider' ); ?></h5>
				<div class="footer-partner-card">
					<div class="footer-partner-header">
						<span class="footer-partner-icon">&#9875;</span>
						<div>
							<strong class="footer-partner-name">Valentines Resort &amp; Marina</strong>
							<span class="footer-partner-tagline">Harbour Island&rsquo;s Premier Marina &amp; Resort</span>
						</div>
					</div>
					<p class="footer-partner-desc">
						<?php esc_html_e( 'Our #1 recommendation for marina berths, hotel accommodation, PADI diving, and waterfront dining on Harbour Island. The only full-service marina on the island.', 'harbour-island-insider' ); ?>
					</p>
					<div class="footer-contact-item"><span class="icon">&#128222;</span><span>+1 (242) 333-2142</span></div>
					<div class="footer-contact-item"><span class="icon">&#128225;</span><span>VHF Channel 16</span></div>
					<div class="footer-contact-item"><span class="icon">&#9993;</span><span>info@valentinesresort.com</span></div>
					<a href="https://www.valentinesresort.com" class="btn btn-primary btn-sm footer-partner-btn" target="_blank" rel="noopener noreferrer nofollow">
						<?php esc_html_e( 'Visit Valentines &rarr;', 'harbour-island-insider' ); ?>
					</a>
				</div>
			</div><!-- /.footer-col -->

		</div><!-- /.footer-grid -->

		<!-- Footer bottom bar -->
		<div class="footer-bottom">
			<span>
				&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?>
				<?php bloginfo( 'name' ); ?>.
				<?php esc_html_e( 'Independent editorial. Not affiliated with any resort.', 'harbour-island-insider' ); ?>
			</span>
			<div class="footer-bottom-links">
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy', 'harbour-island-insider' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms', 'harbour-island-insider' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/editorial-policy/' ) ); ?>"><?php esc_html_e( 'Editorial Disclosure', 'harbour-island-insider' ); ?></a>
			</div>
			<span>Harbour Island, Bahamas &#127463;&#127480;</span>
		</div><!-- /.footer-bottom -->

	</div><!-- /.container -->
</footer><!-- /.footer -->

<?php wp_footer(); ?>
</body>
</html>
