<?php

if ( ! class_exists( 'katen_Walker_Comment' ) ) {

	class katen_Walker_Comment extends Walker_Comment {

		protected function html5_comment( $comment, $depth, $args ) {

			$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

			?>
			<<?php echo esc_attr($tag); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : 'rounded', $comment ); ?>>

				<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

					<div class="thumb">
						<?php
						$comment_author_url = get_comment_author_url( $comment );
						$comment_author     = get_comment_author( $comment );
						$avatar             = get_avatar( $comment, $args['avatar_size'] );
						if ( 0 !== $args['avatar_size'] ) {
							if ( empty( $comment_author_url ) ) {
								echo wp_kses_post( $avatar );
							} else {
								printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --Escaped in https://developer.wordpress.org/reference/functions/get_comment_author_url/
								echo wp_kses_post( $avatar );
							}
						}

						?>
					</div><!-- .thumb -->

					<div class="details">
						<?php
						printf(
							'<h4 class="name">%1$s</span><span class="screen-reader-text says">%2$s</h4>',
							esc_html( $comment_author ),
							esc_attr__( 'says:', 'katen' )
						);

						if ( ! empty( $comment_author_url ) ) {
							echo '</a>';
						}
						?>
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<?php
							/* Translators: 1 = comment date, 2 = comment time */
							$comment_timestamp = sprintf( esc_attr__( '%1$s at %2$s', 'katen' ), get_comment_date( '', $comment ), get_comment_time() );
							?>
							<span datetime="<?php comment_time( 'c' ); ?>" title="<?php echo esc_attr( $comment_timestamp ); ?>" class="date">
								<?php echo esc_html( $comment_timestamp ); ?>
							</span>
						</a>

						<?php

						comment_text();

						if ( '0' === $comment->comment_approved ) {
							?>
							<p class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'katen' ); ?></p>
							<?php
						}

						?>

						<?php

						$comment_reply_link = get_comment_reply_link(
							array_merge(
								$args,
								array(
									'add_below' => 'div-comment',
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
									'before'    => '<span class="comment-reply">',
									'after'     => '</span>',
								)
							)
						);

						$by_post_author = katen_is_comment_by_post_author( $comment );

						if ( $comment_reply_link || $by_post_author ) {
							?>

							<footer class="comment-footer-meta">

								<?php
								if ( $comment_reply_link ) {
									comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
								}
								if ( $by_post_author ) {
									echo '<span class="by-post-author">' . esc_attr__( 'By Post Author', 'katen' ) . '</span>';
								}
								?>

							</footer>

							<?php
						}
						?>

					</div><!-- .details -->

				</article><!-- .comment-body -->

			<?php
		}
	}
}

function katen_is_comment_by_post_author( $comment = null ) {

	if ( is_object( $comment ) && $comment->user_id > 0 ) {

		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );

		if ( ! empty( $user ) && ! empty( $post ) ) {

			return $comment->user_id === $post->post_author;

		}
	}
	return false;

}

if ( post_password_required() ) {
	return;
}

if ( $comments ) {
	?>

	<div class="comments" id="comments">

		<?php
		$comments_number = absint( get_comments_number() );
		
		?>

		<div class="section-header">

			<h3 class="section-title">
				<?php
					esc_attr_e( 'Comments (', 'katen' );
					echo esc_attr( $comments_number );
					esc_attr_e( ')', 'katen' );
				?>
			</h3><!-- .comments-title -->
			<?php 
				$primary_color = esc_attr(get_theme_mod('primary_color', '#FE4F70'));
				$secondary_color = esc_attr(get_theme_mod('secondary_color', '#FFA387'));
			?>
			<svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
				<defs>
					<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
						<stop offset="0%" stop-color="<?php echo esc_attr($primary_color) ?>"></stop>
						<stop offset="100%" stop-color="<?php echo esc_attr($secondary_color) ?>"></stop>
					</linearGradient>
					</defs>
				<path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient)" stroke-width="2" fill="none"></path>
			</svg>

		</div><!-- .comments-header -->

		<div class="bordered padding-30 pt-0 pb-0 rounded">

			<ul class="comments-list ps-0 mb-0">

				<?php
				wp_list_comments(
					array(
						'walker'      => new katen_Walker_Comment(),
						'avatar_size' => 70,
						'style'       => 'li',
					)
				);

				$comment_pagination = paginate_comments_links(
					array(
						'echo'      => false,
						'end_size'  => 0,
						'mid_size'  => 0,
						'next_text' => esc_attr__( 'Newer Comments', 'katen' ) . ' <span aria-hidden="true">&rarr;</span>',
						'prev_text' => '<span aria-hidden="true">&larr;</span> ' . esc_attr__( 'Older Comments', 'katen' ),
					)
				);

				if ( $comment_pagination ) {
					$pagination_classes = '';

					// If we're only showing the "Next" link, add a class indicating so.
					if ( false === strpos( $comment_pagination, 'prev page-numbers' ) ) {
						$pagination_classes = ' only-next';
					}
					?>

					<nav class="comments-pagination pagination<?php echo esc_html($pagination_classes); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>" aria-label="<?php esc_attr_e( 'Comments', 'katen' ); ?>">
						<?php echo wp_kses_post( $comment_pagination ); ?>
					</nav>

					<?php
				}
				?>

			</ul>

		</div><!-- .comments-inner -->

	</div><!-- comments -->

	<?php
}

if ( comments_open() || pings_open() ) {

	$primary_color = esc_attr(get_theme_mod('primary_color', '#FE4F70'));
	$secondary_color = esc_attr(get_theme_mod('secondary_color', '#FFA387'));

	comment_form(
		array(
			'class_form'         => 'comment-form rounded bordered padding-30',
			'title_reply_before' => '<div class="section-header"><h3 id="reply-title" class="section-title">',
			'title_reply_after'  => '</h3><svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
			<defs>
				<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
					<stop offset="0%" stop-color="'.$primary_color.'"></stop>
					<stop offset="100%" stop-color="'.$secondary_color.'"></stop>
				</linearGradient>
				</defs>
			<path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient)" stroke-width="2" fill="none"></path>
		</svg></div>',
		)
	);

} elseif ( is_single() ) {

	?>

	<div class="comment-respond" id="respond">

		<p class="comments-closed"><?php esc_attr_e( 'Comments are closed.', 'katen' ); ?></p>

	</div><!-- #respond -->

	<?php
}
