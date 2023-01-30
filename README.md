# peacock-slider
Wordpress Slider using Bootstrap

1. Install Plugin
2. Add CPT in admin dashboard
3. Create a page template for home and assign it

Code inside the template:

```bash
<section id="home-slider">
    <div id="peacockCarousel" class="carousel slide carousel-fade" data-bs-ride="false">
        <div class="carousel-indicators">
            <?php
                $i = 0;
                $args = array(
                'post_type' => 'peacock_slider',
                'posts_per_page' => -1
                );
                $query = new WP_Query( $args );
                while ( $query->have_posts() ) : $query->the_post();
            ?>
            <button type="button" data-bs-target="#peacock-slider" data-bs-slide-to="<?php echo $i; ?>" <?php if ( $i == 0 ) { echo 'class="active" aria-current="true"'; } ?> aria-label="Slide <?php echo $i; ?>"></button>
            <?php
                $i++;
                endwhile;
                wp_reset_postdata();
            ?>
        </div>
        <div class="carousel-inner">
            <?php
                $i = 0;
                $args = array(
                'post_type' => 'peacock_slider',
                'posts_per_page' => -1
                );
                $query = new WP_Query( $args );
                while ( $query->have_posts() ) : $query->the_post();
                $peacock_slider_image = get_post_meta( get_the_ID(), 'peacock-slider-image', true );
                $peacock_slider_header = get_post_meta( get_the_ID(), 'peacock-slider-header', true );
            ?>
            <div class="carousel-item <?php if ( $i == 0 ) { echo 'active'; } ?>" data-bs-interval="2000">
                <img src="<?php echo esc_url( $peacock_slider_image ); ?>" class="d-block w-100" alt="<?php the_title(); ?>">
                <div class="carousel-caption d-none d-md-block">
                    <h5><?php echo esc_html( $peacock_slider_header ); ?></h5>
                    <p>Some representative placeholder content for the <?php echo $i; ?> slide.</p>
                </div>
            </div>
            <?php
                $i++;
                endwhile;
                wp_reset_postdata();
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#peacockCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#peacockCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section><!-- .home-slider -->
```
