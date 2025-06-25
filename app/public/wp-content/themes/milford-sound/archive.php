<?php get_header(); ?>

<main class="main-content">
    <!-- Archive Header -->
    <header class="archive-header" style="padding: 8rem 0 4rem; background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%); color: white; text-align: center;">
        <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 2rem;">
            <h1 class="archive-title" style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 1rem;">
                <?php
                if (is_post_type_archive('tours')) {
                    echo 'Our Tours';
                } elseif (is_post_type_archive('guides')) {
                    echo 'Travel Guides';
                } else {
                    the_archive_title();
                }
                ?>
            </h1>
            <p style="font-size: 1.25rem; opacity: 0.9;">
                <?php
                if (is_post_type_archive('tours')) {
                    echo 'Discover unforgettable experiences in Milford Sound';
                } elseif (is_post_type_archive('guides')) {
                    echo 'Everything you need to know for your adventure';
                } else {
                    the_archive_description();
                }
                ?>
            </p>
        </div>
    </header>

    <!-- Archive Content -->
    <div class="archive-content" style="padding: 4rem 0; background: #f8fafc;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            <?php if (have_posts()) : ?>
                <div class="posts-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?> style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail" style="height: 250px; overflow: hidden;">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="post-content" style="padding: 2rem;">
                                <?php if (get_post_type() == 'tours') : ?>
                                    <?php $tour_details = get_tour_details(get_the_ID()); ?>
                                    <?php if ($tour_details['price']) : ?>
                                        <div class="tour-price" style="color: #2dd4bf; font-weight: 700; font-size: 1.25rem; margin-bottom: 1rem;">
                                            From <?php echo esc_html($tour_details['price']); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <h2 class="post-title" style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b;">
                                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <div class="post-excerpt" style="color: #64748b; margin-bottom: 2rem; line-height: 1.6;">
                                    <?php the_excerpt(); ?>
                                </div>

                                <?php if (get_post_type() == 'tours' && $tour_details) : ?>
                                    <div class="tour-meta" style="display: flex; gap: 1rem; margin-bottom: 2rem; font-size: 0.9rem; color: #64748b;">
                                        <?php if ($tour_details['duration']) : ?>
                                            <span>⏰ <?php echo esc_html($tour_details['duration']); ?></span>
                                        <?php endif; ?>
                                        <?php if ($tour_details['group_size']) : ?>
                                            <span>👥 <?php echo esc_html($tour_details['group_size']); ?></span>
                                        <?php endif; ?>
                                        <?php if ($tour_details['difficulty']) : ?>
                                            <span>📊 <?php echo esc_html(ucfirst($tour_details['difficulty'])); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <a href="<?php the_permalink(); ?>" class="read-more" style="background: #2dd4bf; color: white; padding: 0.75rem 1.5rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: background 0.3s ease;">
                                    <?php echo get_post_type() == 'tours' ? 'View Tour →' : 'Read More →'; ?>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="pagination" style="margin-top: 4rem; text-align: center;">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                    ));
                    ?>
                </div>

            <?php else : ?>
                <div class="no-posts" style="text-align: center; padding: 4rem 2rem;">
                    <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #1e293b;">Nothing Found</h2>
                    <p style="color: #64748b; font-size: 1.25rem; margin-bottom: 2rem;">Sorry, but nothing matched your search terms.</p>
                    <a href="<?php echo home_url(); ?>" class="btn btn-primary" style="background: #2dd4bf; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                        Return Home
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>