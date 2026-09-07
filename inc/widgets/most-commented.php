<?php
/**
 * Most Commented Theme Widget.
 *
 * Displays most commented posts widget.
 *
 * @link https://codex.wordpress.org/Widgets_API#Developing_Widgets
 *
 * @package Melina
 */

class Melina_Most_Commented_Widget extends WP_Widget {
	/**
	 * Constructor.
	 *
	 * @return Melina_Most_Commented_Widget
	 */
	public function __construct() {
		parent::__construct( 'widget_melina_most_commented_posts', esc_html__( 'Melina Most Commented Posts', 'melina' ), array(
			'classname'   => 'widget_melina_most_commented_posts',
			'description' => esc_html__( 'Use this widget to list your most commented posts. Well-suited to display in the sidebar.', 'melina' ),
			'customize_selective_refresh' => true,
		) );
	}

	/**
	 * Output the HTML for this widget.
	 *
	 * @access public
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme.
	 * @param array $instance An array of settings for this widget instance.
	 */
	public function widget( $args, $instance ) {
		global $post;

		$number = empty( $instance['number'] ) ? 4 : absint( $instance['number'] );
		$title  = apply_filters( 'widget_title', empty( $instance['title'] ) ? esc_html__( 'Most Commented', 'melina' ) : $instance['title'], $instance, $this->id_base );

		// Params for our query.
		$query_args = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $number,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'orderby'             => 'comment_count'
		);

		if ( is_singular() ) {
			$query_args['post__not_in'] = array( $post->ID );
		}

		// The Query.
		$mostCommented = new WP_Query( $query_args );

		if ( $mostCommented->have_posts() ) :
			echo wp_kses_post( $args['before_widget'] ); ?>

			<h2 class="widget-title"><?php echo esc_html( $title ); ?></h2>

			<div class="post-list">
				<?php // Start the loop.
				while ( $mostCommented->have_posts() ) : $mostCommented->the_post(); ?>

					<div class="post-list__item">
						<article class="post-card<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?> post-card--has-thumbnail<?php endif; ?>">
							<?php melina_post_thumbnail( 'post-thumbnail', 'post-card__thumbnail', array( 'sizes' => '(max-width: 479px) 90vw, (max-width: 599px) 432px, (max-width: 767px) 536px, (max-width: 959px) 328px, (max-width: 1023px) 368px, (max-width: 1279px) 364px, 324px' ), true ); ?>

							<div class="post-card__body">
								<?php
								the_title( '<h3 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
								melina_postcard_meta(); ?>
							</div>
						</article><!-- .post-card -->
					</div><!-- .post-list__item -->

				<?php
				endwhile; ?>
			</div><!-- .post-list -->

			<?php
			echo wp_kses_post( $args['after_widget'] );

			// Reset the post globals as this query will have stomped on it.
			wp_reset_postdata();
		endif; // End check for most commented posts.
	}

	/**
	 * Deal with the settings when they are saved by the admin.
	 *
	 * Here is where any validation should happen.
	 *
	 * @param array $new_instance New widget instance.
	 * @param array $instance     Original widget instance.
	 * @return array Updated widget instance.
	 */
	function update( $new_instance, $instance ) {
		$instance['title']  = strip_tags( $new_instance['title'] );
		$instance['number'] = empty( $new_instance['number'] ) ? 4 : absint( $new_instance['number'] );

		return $instance;
	}

	/**
	 * Display the form for this widget on the Widgets page of the Admin area.
	 *
	 * @param array $instance
	 */
	function form( $instance ) {
		$title  = empty( $instance['title'] ) ? '' : esc_attr( $instance['title'] );
		$number = empty( $instance['number'] ) ? 4 : absint( $instance['number'] );
		?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'melina' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" type="text"></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'melina' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" class="tiny-text" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" type="number"></p>
		<?php
	}
}
