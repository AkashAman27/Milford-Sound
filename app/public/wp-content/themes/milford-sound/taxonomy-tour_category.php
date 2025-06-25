<?php get_header(); ?>

<?php
// Get current taxonomy term
$current_term = get_queried_object();
$term_id = $current_term->term_id;

// Get ACF fields for this term (if available)
$term_icon = get_field('category_icon', 'tour_category_' . $term_id) ?: '🏔️';
$term_color = get_field('category_color', 'tour_category_' . $term_id) ?: '#2dd4bf';
$term_image = get_field('category_image', 'tour_category_' . $term_id);
$term_features = get_field('category_features', 'tour_category_' . $term_id);

// Category specific colors based on common tour categories
$category_colors = array(
    'cruises' => '#2dd4bf',
    'adventure' => '#ef4444',
    'helicopter-tours' => '#8b5cf6',
    'kayaking' => '#06b6d4',
    'walking-tours' => '#22c55e',
    'photography-tours' => '#ec4899',
    'wildlife-tours' => '#f59e0b',
    'cultural-tours' => '#f97316'
);

$category_slug = $current_term->slug;
$category_color = $category_colors[$category_slug] ?? $term_color;
?>

<main class="main-content tour-category-archive">
    
    <!-- Category Header -->
    <header class="category-header" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, <?php echo esc_attr($category_color); ?> 0%, #3b82f6 100%); color: white; text-align: center; overflow: hidden;">
        
        <?php if ($term_image) : ?>
            <div class="category-bg-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?php echo esc_url($term_image['url']); ?>'); background-size: cover; background-position: center; opacity: 0.3; z-index: -1;"></div>
        <?php endif; ?>
        
        <!-- Background Pattern -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; z-index: -1; background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.4"><circle cx="30" cy="30" r="3"/></g></svg>');"></div>
        
        <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 2;">
            
            <div class="category-icon" style="font-size: 4rem; margin-bottom: 1rem;">
                <?php echo esc_html($term_icon); ?>
            </div>
            
            <h1 class="category-title" style="font-size: clamp(3rem, 8vw, 5rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.1;">
                <?php echo esc_html($current_term->name); ?> Tours
            </h1>
            
            <?php if ($current_term->description) : ?>
                <p class="category-description" style="font-size: 1.5rem; margin-bottom: 3rem; opacity: 0.9; max-width: 700px; margin-left: auto; margin-right: auto;">
                    <?php echo esc_html($current_term->description); ?>
                </p>
            <?php endif; ?>
            
            <!-- Category Stats -->
            <div class="category-stats" style="display: flex; justify-content: center; gap: 4rem; flex-wrap: wrap; margin-bottom: 3rem;">
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;"><?php echo esc_html($current_term->count); ?></div>
                    <div style="opacity: 0.9;">Available Tours</div>
                </div>
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">4.8</div>
                    <div style="opacity: 0.9;">Average Rating</div>
                </div>
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">From $89</div>
                    <div style="opacity: 0.9;">Starting Price</div>
                </div>
            </div>
            
            <!-- Navigation Breadcrumb -->
            <div class="category-breadcrumb" style="margin-top: 2rem;">
                <a href="<?php echo home_url(); ?>" style="color: rgba(255,255,255,0.8); text-decoration: none;">Home</a>
                <span style="margin: 0 0.5rem; opacity: 0.6;">></span>
                <a href="<?php echo get_post_type_archive_link('tours'); ?>" style="color: rgba(255,255,255,0.8); text-decoration: none;">All Tours</a>
                <span style="margin: 0 0.5rem; opacity: 0.6;">></span>
                <span style="color: white; font-weight: 600;"><?php echo esc_html($current_term->name); ?></span>
            </div>
            
        </div>
    </header>

    <!-- Category Features (if available) -->
    <?php if ($term_features && !empty($term_features)) : ?>
        <section class="category-features" style="padding: 4rem 0; background: #f8fafc;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                
                <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; color: #1e293b;">Why Choose <?php echo esc_html($current_term->name); ?> Tours?</h2>
                    <p style="color: #64748b; font-size: 1.25rem;">Discover what makes these experiences special</p>
                </div>
                
                <div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    <?php foreach ($term_features as $feature) : ?>
                        <div class="feature-card" style="background: white; padding: 2.5rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
                            <div style="font-size: 3rem; margin-bottom: 1.5rem;"><?php echo esc_html($feature['feature_icon']); ?></div>
                            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b;"><?php echo esc_html($feature['feature_title']); ?></h3>
                            <p style="color: #64748b; line-height: 1.6;"><?php echo esc_html($feature['feature_description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                
            </div>
        </section>
    <?php endif; ?>

    <!-- Tours Listing -->
    <section class="category-tours" style="padding: 4rem 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            
            <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; color: #1e293b;">Available <?php echo esc_html($current_term->name); ?> Tours</h2>
                    <p style="color: #64748b;">Showing <?php echo esc_html($current_term->count); ?> tour<?php echo $current_term->count !== 1 ? 's' : ''; ?> in this category</p>
                </div>
                
                <!-- Sort Options -->
                <div class="sort-options" style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="color: #64748b; font-weight: 600;">Sort by:</span>
                    <select class="sort-select" style="background: white; border: 2px solid #e2e8f0; padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.9rem; min-width: 140px;">
                        <option value="menu_order">Recommended</option>
                        <option value="title">Name A-Z</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="rating">Highest Rated</option>
                        <option value="duration">Duration</option>
                    </select>
                </div>
            </div>
            
            <!-- Tours Grid -->
            <?php if (have_posts()) : ?>
                <div class="tours-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
                    
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                        $tour_overview = get_field('tour_overview');
                        $tour_highlights = get_field('tour_highlights');
                        $tour_reviews = get_field('tour_reviews');
                        $tour_booking = get_field('tour_booking');
                        ?>
                        
                        <article class="tour-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.1); transition: all 0.3s ease; border: 1px solid #f1f5f9;">
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="tour-image" style="height: 220px; overflow: hidden; position: relative;">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                    </a>
                                    
                                    <!-- Price Badge -->
                                    <?php if ($tour_overview && $tour_overview['tour_price']) : ?>
                                        <div class="price-badge" style="position: absolute; top: 1rem; right: 1rem; background: <?php echo esc_attr($category_color); ?>; color: white; padding: 0.5rem 1rem; border-radius: 25px; font-weight: 700; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                                            <?php echo esc_html($tour_overview['tour_price']); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Category Badge -->
                                    <div class="category-badge" style="position: absolute; bottom: 1rem; left: 1rem; background: rgba(255,255,255,0.9); color: <?php echo esc_attr($category_color); ?>; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600; backdrop-filter: blur(10px);">
                                        <?php echo esc_html($current_term->name); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="tour-content" style="padding: 2rem;">
                                
                                <!-- Tour Meta -->
                                <?php if ($tour_overview) : ?>
                                    <div class="tour-meta" style="display: flex; gap: 1.5rem; margin-bottom: 1rem; font-size: 0.8rem; color: #64748b; flex-wrap: wrap;">
                                        <?php if ($tour_overview['tour_duration']) : ?>
                                            <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                <span>⏰</span>
                                                <span><?php echo esc_html($tour_overview['tour_duration']); ?></span>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if ($tour_overview['tour_group_size']) : ?>
                                            <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                <span>👥</span>
                                                <span><?php echo esc_html($tour_overview['tour_group_size']); ?></span>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if ($tour_overview['tour_difficulty']) : ?>
                                            <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                <span>📊</span>
                                                <span><?php echo esc_html(ucfirst(str_replace('_', ' ', $tour_overview['tour_difficulty']))); ?></span>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if ($tour_reviews && $tour_reviews['average_rating']) : ?>
                                            <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                <span>⭐</span>
                                                <span><?php echo esc_html($tour_reviews['average_rating']); ?> (<?php echo esc_html($tour_reviews['total_reviews'] ?: 0); ?>)</span>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.3;">
                                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                
                                <p style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>
                                
                                <!-- Tour Highlights -->
                                <?php if ($tour_highlights && !empty($tour_highlights)) : ?>
                                    <div class="tour-highlights" style="margin-bottom: 1.5rem;">
                                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                            <?php foreach (array_slice($tour_highlights, 0, 3) as $highlight) : ?>
                                                <span style="background: #f8fafc; color: #64748b; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; display: flex; align-items: center; gap: 0.25rem;">
                                                    <span><?php echo esc_html($highlight['highlight_icon']); ?></span>
                                                    <span><?php echo esc_html($highlight['highlight_title']); ?></span>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Action Buttons -->
                                <div style="display: flex; gap: 1rem;">
                                    <a href="<?php the_permalink(); ?>" class="tour-details-btn" style="background: transparent; color: <?php echo esc_attr($category_color); ?>; border: 2px solid <?php echo esc_attr($category_color); ?>; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; flex: 1; justify-content: center; transition: all 0.3s ease;">
                                        View Details
                                    </a>
                                    
                                    <?php if ($tour_booking && $tour_booking['booking_link']) : ?>
                                        <a href="<?php echo esc_url($tour_booking['booking_link']['url']); ?>" class="tour-book-btn" style="background: <?php echo esc_attr($category_color); ?>; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; flex: 1; justify-content: center; transition: all 0.3s ease;" <?php if ($tour_booking['booking_link']['target']) echo 'target="' . esc_attr($tour_booking['booking_link']['target']) . '"'; ?>>
                                            Book Now →
                                        </a>
                                    <?php endif; ?>
                                </div>
                                
                            </div>
                        </article>
                        
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="tours-pagination" style="text-align: center;">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '← Previous Tours',
                        'next_text' => 'Next Tours →',
                    ));
                    ?>
                </div>

            <?php else : ?>
                <!-- No Tours Found -->
                <div class="no-tours" style="text-align: center; padding: 4rem 2rem; background: #f8fafc; border-radius: 20px;">
                    <div style="font-size: 4rem; margin-bottom: 2rem;"><?php echo esc_html($term_icon); ?></div>
                    <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #1e293b;">No <?php echo esc_html($current_term->name); ?> Tours Available</h2>
                    <p style="color: #64748b; font-size: 1.25rem; margin-bottom: 2rem;">We're currently updating our <?php echo esc_html(strtolower($current_term->name)); ?> tour offerings. Check back soon or explore other tour categories!</p>
                    <a href="<?php echo get_post_type_archive_link('tours'); ?>" class="btn btn-primary" style="background: <?php echo esc_attr($category_color); ?>; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; margin-right: 1rem;">
                        Browse All Tours →
                    </a>
                    <a href="<?php echo home_url(); ?>" class="btn btn-secondary" style="background: transparent; color: <?php echo esc_attr($category_color); ?>; border: 2px solid <?php echo esc_attr($category_color); ?>; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                        Return Home
                    </a>
                </div>
            <?php endif; ?>
            
        </div>
    </section>

    <!-- Related Categories -->
    <?php
    $related_categories = get_terms(array(
        'taxonomy' => 'tour_category',
        'exclude' => $term_id,
        'hide_empty' => true,
        'number' => 4
    ));
    
    if ($related_categories) :
    ?>
        <section class="related-categories" style="padding: 4rem 0; background: #f8fafc;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                
                <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; color: #1e293b;">Other Tour Categories</h2>
                    <p style="color: #64748b; font-size: 1.25rem;">Discover more amazing experiences in Milford Sound</p>
                </div>
                
                <div class="categories-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                    <?php foreach ($related_categories as $category) : ?>
                        <?php
                        $cat_icon = get_field('category_icon', 'tour_category_' . $category->term_id) ?: '🏔️';
                        $cat_color = $category_colors[$category->slug] ?? '#2dd4bf';
                        ?>
                        
                        <div class="category-card" style="background: white; border-radius: 15px; padding: 2rem; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s ease; cursor: pointer;" onclick="window.location.href='<?php echo get_term_link($category); ?>'">
                            
                            <div class="category-icon" style="font-size: 3rem; margin-bottom: 1rem;">
                                <?php echo esc_html($cat_icon); ?>
                            </div>
                            
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">
                                <?php echo esc_html($category->name); ?>
                            </h3>
                            
                            <p style="color: #64748b; margin-bottom: 1rem; font-size: 0.9rem;">
                                <?php echo esc_html($category->description ?: $category->count . ' amazing tour' . ($category->count !== 1 ? 's' : '') . ' available'); ?>
                            </p>
                            
                            <div style="color: <?php echo esc_attr($cat_color); ?>; font-weight: 600; font-size: 0.9rem; margin-bottom: 1rem;">
                                <?php echo esc_html($category->count); ?> tour<?php echo $category->count !== 1 ? 's' : ''; ?>
                            </div>
                            
                            <a href="<?php echo get_term_link($category); ?>" style="background: <?php echo esc_attr($cat_color); ?>; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                                Explore →
                            </a>
                            
                        </div>
                        
                    <?php endforeach; ?>
                </div>
                
            </div>
        </section>
    <?php endif; ?>
    
</main>

<style>
/* Tour Category Specific Styles */
.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.tour-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.tour-card:hover img {
    transform: scale(1.05);
}

.tour-details-btn:hover {
    background: <?php echo esc_attr($category_color); ?> !important;
    color: white !important;
    transform: translateY(-2px);
}

.tour-book-btn:hover {
    background: #1e293b !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.stat-item:hover {
    transform: translateY(-3px);
}

.tours-pagination .page-numbers {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    margin: 0 0.5rem;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    text-decoration: none;
    color: #64748b;
    font-weight: 600;
    transition: all 0.3s ease;
}

.tours-pagination .page-numbers:hover,
.tours-pagination .page-numbers.current {
    background: <?php echo esc_attr($category_color); ?>;
    color: white;
    border-color: <?php echo esc_attr($category_color); ?>;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .category-stats {
        gap: 2rem !important;
    }
    
    .section-header {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 2rem !important;
    }
    
    .tours-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)) !important;
    }
    
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) !important;
    }
    
    .tour-content .tour-meta {
        flex-direction: column !important;
        gap: 0.5rem !important;
    }
}

@media (max-width: 480px) {
    .tours-grid {
        grid-template-columns: 1fr !important;
    }
    
    .categories-grid {
        grid-template-columns: 1fr !important;
    }
    
    .tour-content > div:last-child {
        flex-direction: column !important;
    }
}
</style>

<?php get_footer(); ?>