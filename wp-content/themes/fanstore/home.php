<?php get_template_part('parts/header'); ?>
<main>
    <section id="fs_slider" class="fs_slider_container">
        <div class="flexslider">
            <ul class="slides">
            <?php query_posts(array('post_type' => 'fs_product','orderby' => 'rand')); if(have_posts()) : while(have_posts()) : the_post();?>
                <li class="slide">
                    <p class="fs_slider_title"><?php the_title(); ?></p>
                    <p class="fs_slider_short_desc"><?= get_post_meta(get_the_ID(), 'short_description', true) ?></p>
                    <div class="fs_post_thumbnail">
                        <a href="<?= the_permalink() ?>">
                            <?php the_post_thumbnail(); ?>
                        </a>
                    </div>
                </li>
            <?php endwhile; endif; wp_reset_query(); ?>
            </ul>
        </div>
    </section>
</main>
<?php get_template_part('parts/footer'); ?>
