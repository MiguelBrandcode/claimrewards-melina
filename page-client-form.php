<?php
/* Template Name: Example Template */

get_header(); ?>

<div id="content-area" class="content-area">
    <div class="container">
        <main id="primary" class="main-content">

            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry__header">
                        <?php
                        if (get_edit_post_link()) : ?>
                            <div class="entry__meta">
                                <?php melina_edit_link(); ?>
                            </div><!-- .entry__meta -->
                        <?php
                        endif;

                        the_title('<h1 class="entry__title">', '</h1>'); ?>
                    </header><!-- .entry__header -->

                    <?php melina_post_thumbnail(); ?>

                    <div class="entry__content">
                        <?php
                        the_content();

                        /**
                         * Functions hooked in to melina_page_content_bottom action:
                         *
                         * @hooked melina_page_links - 10
                         */
                        do_action('melina_page_content_bottom'); ?>
                    </div><!-- .entry__content -->

                    <?php melina_entry_footer(); ?>
                </article><!-- #post-<?php the_ID(); ?> -->



            <?php endwhile; // End of the loop.
            ?>

        </main><!-- #primary -->

        <?php get_sidebar(); ?>
    </div><!-- .container -->
</div><!-- #content-area -->

<?php
get_footer();
