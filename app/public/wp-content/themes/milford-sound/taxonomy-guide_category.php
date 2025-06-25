<?php get_header(); ?>

<?php
// Get current taxonomy term
$current_term = get_queried_object();
$term_id = $current_term->term_id;

// Get ACF fields for this term (if available)
$term_icon = get_field('category_icon', 'guide_category_' . $term_id) ?: '📚';
$term_color = get_field('category_color', 'guide_category_' . $term_id) ?: '#3b82f6';
$term_image = get_field('category_image', 'guide_category_' . $term_id);

// Category specific colors based on common guide categories
$category_colors = array(
    'planning' => '#3b82f6',
    'accommodation' => '#f59e0b',
    'transportation' => '#8b5cf6',
    'activities' => '#22c55e',
    'photography' => '#ec4899',
    'weather-seasons' => '#06b6d4',
    'budget-travel' => '#10b981',
    'family-travel' => '#f97316'
);

$category_slug = $current_term->slug;
$category_color = $category_colors[$category_slug] ?? $term_color;
?>

<main class="main-content guide-category-archive">
    
    <!-- Category Header -->
    <header class="category-header" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, <?php echo esc_attr($category_color); ?> 0%, #8b5cf6 100%); color: white; text-align: center; overflow: hidden;">
        
        <?php if ($term_image) : ?>
            <div class="category-bg-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?php echo esc_url($term_image['url']); ?>'); background-size: cover; background-position: center; opacity: 0.3; z-index: -1;"></div>
        <?php endif; ?>
        
        <!-- Background Pattern -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; z-index: -1; background-image: url('data:image/svg+xml,<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.3"><path d="M20 20l10-10v10h-10zm0 0l-10 10h10v-10z"/></g></svg>');"></div>
        
        <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 2;">
            
            <div class="category-icon" style="font-size: 4rem; margin-bottom: 1rem;">
                <?php echo esc_html($term_icon); ?>
            </div>
            
            <h1 class="category-title" style="font-size: clamp(3rem, 8vw, 5rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.1;">
                <?php echo esc_html($current_term->name); ?> Guides
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
                    <div style="opacity: 0.9;">Expert Guides</div>
                </div>
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">5 min</div>
                    <div style="opacity: 0.9;">Average Read</div>
                </div>
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">Free</div>
                    <div style="opacity: 0.9;">Access</div>
                </div>
            </div>
            
            <!-- Navigation Breadcrumb -->
            <div class="category-breadcrumb" style="margin-top: 2rem;">
                <a href="<?php echo home_url(); ?>" style="color: rgba(255,255,255,0.8); text-decoration: none;">Home</a>
                <span style="margin: 0 0.5rem; opacity: 0.6;">></span>
                <a href="<?php echo get_post_type_archive_link('guides'); ?>" style="color: rgba(255,255,255,0.8); text-decoration: none;">Travel Guides</a>
                <span style="margin: 0 0.5rem; opacity: 0.6;">></span>
                <span style="color: white; font-weight: 600;"><?php echo esc_html($current_term->name); ?></span>
            </div>
            
        </div>
    </header>

    <!-- Featured Guide -->
    <?php
    $featured_guide = new WP_Query(array(
        'post_type' => 'guides',
        'posts_per_page' => 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'guide_category',
                'field' => 'term_id',
                'terms' => $term_id
            )
        ),
        'meta_query' => array(
            array(
                'key' => 'featured_guide',
                'value' => '1',
                'compare' => '='
            )
        )
    ));
    
    if ($featured_guide->have_posts()) :
    ?>
        <section class="featured-guide" style="padding: 4rem 0; background: #f8fafc;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                
                <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                    <span style="background: linear-gradient(135deg, <?php echo esc_attr($category_color); ?>, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700; font-size: 1rem; text-transform: uppercase; letter-spacing: 2px;">Editor's Pick</span>
                    <h2 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin: 1rem 0; color: #1e293b;">Essential Reading</h2>
                    <p style="color: #64748b; font-size: 1.25rem; max-width: 600px; margin: 0 auto;">Start with our most comprehensive <?php echo esc_html(strtolower($current_term->name)); ?> guide</p>
                </div>
                
                <?php while ($featured_guide->have_posts()) : $featured_guide->the_post(); ?>
                    <?php
                    $guide_overview = get_field('guide_overview');
                    $guide_quick_facts = get_field('guide_quick_facts');
                    ?>
                    
                    <article class="featured-guide-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.1); max-width: 900px; margin: 0 auto;">
                        
                        <div style="display: grid; grid-template-columns: 1fr 300px; gap: 0; min-height: 350px;">
                            
                            <div class="guide-content" style="padding: 3rem; display: flex; flex-direction: column; justify-content: space-between;">
                                
                                <div>
                                    <!-- Featured Badge -->
                                    <div style="background: linear-gradient(135deg, #f59e0b, #f97316); color: white; padding: 0.5rem 1rem; border-radius: 25px; font-size: 0.8rem; font-weight: 600; display: inline-block; margin-bottom: 1.5rem;">
                                        ⭐ Featured Guide
                                    </div>
                                    
                                    <h3 style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.3;">
                                        <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    
                                    <!-- Guide Meta -->
                                    <?php if ($guide_overview) : ?>
                                        <div class="guide-meta" style="display: flex; gap: 2rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #64748b; flex-wrap: wrap;">
                                            <?php if ($guide_overview['guide_type']) : ?>
                                                <span style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <span>📋</span>
                                                    <span><?php echo esc_html(ucfirst(str_replace('_', ' ', $guide_overview['guide_type']))); ?></span>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if ($guide_overview['guide_difficulty']) : ?>
                                                <span style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <span>📊</span>
                                                    <span><?php echo esc_html(ucfirst($guide_overview['guide_difficulty'])); ?></span>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if ($guide_overview['estimated_reading_time']) : ?>
                                                <span style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <span>⏱️</span>
                                                    <span><?php echo esc_html($guide_overview['estimated_reading_time']); ?> min read</span>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <p style="color: #64748b; margin-bottom: 2rem; line-height: 1.7; font-size: 1.1rem;">
                                        <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                                    </p>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="featured-guide-btn" style="background: <?php echo esc_attr($category_color); ?>; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; align-self: flex-start; transition: all 0.3s ease;">
                                    Read Complete Guide →
                                </a>
                                
                            </div>
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="guide-image" style="overflow: hidden; position: relative;">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </article>
                    
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
                
            </div>
        </section>
    <?php endif; ?>

    <!-- Guides Listing -->
    <section class="category-guides" style="padding: 4rem 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            
            <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; color: #1e293b;">All <?php echo esc_html($current_term->name); ?> Guides</h2>
                    <p style="color: #64748b;">Showing <?php echo esc_html($current_term->count); ?> guide<?php echo $current_term->count !== 1 ? 's' : ''; ?> in this category</p>
                </div>
                
                <!-- Sort Options -->
                <div class="sort-options" style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="color: #64748b; font-weight: 600;">Sort by:</span>
                    <select class="sort-select" style="background: white; border: 2px solid #e2e8f0; padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.9rem; min-width: 140px;">
                        <option value="menu_order">Recommended</option>
                        <option value="title">Title A-Z</option>
                        <option value="date">Newest First</option>
                        <option value="reading_time">Quick Reads</option>
                        <option value="comprehensive">Most Comprehensive</option>
                        <option value="updated">Recently Updated</option>
                    </select>
                </div>
            </div>
            
            <!-- Guides Grid -->
            <?php if (have_posts()) : ?>
                <div class="guides-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
                    
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                        $guide_overview = get_field('guide_overview');
                        $guide_quick_facts = get_field('guide_quick_facts');
                        $guide_author = get_field('guide_author');
                        ?>
                        
                        <article class="guide-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f1f5f9;">
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="guide-image" style="height: 200px; overflow: hidden; position: relative;">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                    </a>
                                    
                                    <!-- Guide Type Badge -->
                                    <?php if ($guide_overview && $guide_overview['guide_type']) : ?>
                                        <div class="type-badge" style="position: absolute; top: 1rem; left: 1rem; background: <?php echo esc_attr($category_color); ?>; color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                            <?php echo esc_html(ucfirst(str_replace('_', ' ', $guide_overview['guide_type']))); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Reading Time Badge -->
                                    <?php if ($guide_overview && $guide_overview['estimated_reading_time']) : ?>
                                        <div class="reading-time-badge" style="position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.7); color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600; backdrop-filter: blur(10px);">
                                            <?php echo esc_html($guide_overview['estimated_reading_time']); ?> min
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Category Badge -->
                                    <div class="category-badge" style="position: absolute; bottom: 1rem; left: 1rem; background: rgba(255,255,255,0.9); color: <?php echo esc_attr($category_color); ?>; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                        <?php echo esc_html($current_term->name); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="guide-content" style="padding: 1.5rem;">
                                
                                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.4;">
                                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                
                                <!-- Guide Meta -->
                                <?php if ($guide_overview) : ?>
                                    <div class="guide-meta" style="display: flex; gap: 1rem; margin-bottom: 1rem; font-size: 0.8rem; color: #64748b; flex-wrap: wrap;">
                                        <?php if ($guide_overview['guide_difficulty']) : ?>
                                            <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                <span>📊</span>
                                                <span><?php echo esc_html(ucfirst($guide_overview['guide_difficulty'])); ?></span>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if ($guide_overview['last_updated']) : ?>
                                            <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                <span>🔄</span>
                                                <span>Updated <?php echo date('M Y', strtotime($guide_overview['last_updated'])); ?></span>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <span style="display: flex; align-items: center; gap: 0.25rem;">
                                            <span>👤</span>
                                            <span><?php the_author(); ?></span>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <p style="color: #64748b; margin-bottom: 1rem; line-height: 1.6; font-size: 0.9rem;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                                </p>
                                
                                <!-- Quick Facts Preview -->
                                <?php if ($guide_quick_facts && !empty($guide_quick_facts)) : ?>
                                    <div class="quick-facts-preview" style="margin-bottom: 1rem; background: #f8fafc; padding: 1rem; border-radius: 10px;">
                                        <div style="font-size: 0.8rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">Quick Info:</div>
                                        <div style="display: grid; gap: 0.5rem;">
                                            <?php foreach (array_slice($guide_quick_facts, 0, 2) as $fact) : ?>
                                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem;">
                                                    <span style="color: #64748b; display: flex; align-items: center; gap: 0.25rem;">
                                                        <span><?php echo esc_html($fact['fact_icon']); ?></span>
                                                        <span><?php echo esc_html($fact['fact_label']); ?></span>
                                                    </span>
                                                    <span style="font-weight: 600; color: #1e293b;"><?php echo esc_html($fact['fact_value']); ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="guide-cta-btn" style="background: <?php echo esc_attr($category_color); ?>; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; width: 100%; justify-content: center; transition: all 0.3s ease;">
                                    Read Guide →
                                </a>
                                
                            </div>
                        </article>
                        
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="guides-pagination" style="text-align: center;">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '← Previous Guides',
                        'next_text' => 'Next Guides →',
                    ));
                    ?>
                </div>

            <?php else : ?>
                <!-- No Guides Found -->
                <div class="no-guides" style="text-align: center; padding: 4rem 2rem; background: #f8fafc; border-radius: 20px;">
                    <div style="font-size: 4rem; margin-bottom: 2rem;"><?php echo esc_html($term_icon); ?></div>
                    <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #1e293b;">No <?php echo esc_html($current_term->name); ?> Guides Available</h2>
                    <p style="color: #64748b; font-size: 1.25rem; margin-bottom: 2rem;">We're working on comprehensive <?php echo esc_html(strtolower($current_term->name)); ?> guides. Check back soon or explore other categories!</p>
                    <a href="<?php echo get_post_type_archive_link('guides'); ?>" class="btn btn-primary" style="background: <?php echo esc_attr($category_color); ?>; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; margin-right: 1rem;">
                        Browse All Guides →
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
        'taxonomy' => 'guide_category',
        'exclude' => $term_id,
        'hide_empty' => true,
        'number' => 4
    ));
    
    if ($related_categories) :
    ?>
        <section class="related-categories" style="padding: 4rem 0; background: #f8fafc;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                
                <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; color: #1e293b;">Other Guide Categories</h2>
                    <p style="color: #64748b; font-size: 1.25rem;">Explore more expert advice and travel tips</p>
                </div>
                
                <div class="categories-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                    <?php foreach ($related_categories as $category) : ?>
                        <?php
                        $cat_icon = get_field('category_icon', 'guide_category_' . $category->term_id) ?: '📖';
                        $cat_color = $category_colors[$category->slug] ?? '#3b82f6';
                        ?>
                        
                        <div class="category-card" style="background: white; border-radius: 15px; padding: 2rem; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s ease; cursor: pointer;" onclick="window.location.href='<?php echo get_term_link($category); ?>'">
                            
                            <div class="category-icon" style="font-size: 3rem; margin-bottom: 1rem;">
                                <?php echo esc_html($cat_icon); ?>
                            </div>
                            
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">
                                <?php echo esc_html($category->name); ?>
                            </h3>
                            
                            <p style="color: #64748b; margin-bottom: 1rem; font-size: 0.9rem; line-height: 1.5;">
                                <?php echo esc_html($category->description ?: 'Expert guides and practical tips for ' . strtolower($category->name)); ?>
                            </p>
                            
                            <div style="color: <?php echo esc_attr($cat_color); ?>; font-weight: 600; font-size: 0.9rem; margin-bottom: 1rem;">
                                <?php echo esc_html($category->count); ?> guide<?php echo $category->count !== 1 ? 's' : ''; ?>
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
/* Guide Category Specific Styles */
.featured-guide-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.featured-guide-card:hover img {
    transform: scale(1.05);
}

.featured-guide-btn:hover {
    background: #1e293b !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.guide-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

.guide-card:hover img {
    transform: scale(1.03);
}

.guide-cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.stat-item:hover {
    transform: translateY(-3px);
}

.guides-pagination .page-numbers {
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

.guides-pagination .page-numbers:hover,
.guides-pagination .page-numbers.current {
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
    
    .featured-guide-card > div {
        grid-template-columns: 1fr !important;
    }
    
    .guides-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)) !important;
    }
    
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) !important;
    }
    
    .guide-content .guide-meta {
        flex-direction: column !important;
        gap: 0.5rem !important;
    }
}

@media (max-width: 480px) {
    .guides-grid {
        grid-template-columns: 1fr !important;
    }
    
    .categories-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php get_footer(); ?>