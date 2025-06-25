<?php get_header(); ?>

<main class="main-content tours-archive">
    
    <!-- Tours Archive Header -->
    <header class="archive-header" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%); color: white; text-align: center; overflow: hidden;">
        
        <!-- Background Pattern -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; z-index: -1; background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.4"><circle cx="30" cy="30" r="3"/></g></svg>');"></div>
        
        <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 2;">
            
            <div class="archive-icon" style="font-size: 4rem; margin-bottom: 1rem;">🏔️</div>
            
            <h1 class="archive-title" style="font-size: clamp(3rem, 8vw, 5rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.1;">
                Milford Sound Tours
            </h1>
            
            <p class="archive-description" style="font-size: 1.5rem; margin-bottom: 3rem; opacity: 0.9; max-width: 700px; margin-left: auto; margin-right: auto;">
                Discover breathtaking experiences in one of the world's most spectacular natural wonders. From scenic cruises to helicopter flights, find your perfect adventure.
            </p>
            
            <!-- Archive Stats -->
            <div class="archive-stats" style="display: flex; justify-content: center; gap: 4rem; flex-wrap: wrap; margin-bottom: 3rem;">
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;"><?php echo wp_count_posts('tours')->publish; ?></div>
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
            
            <!-- Quick Filter Buttons -->
            <div class="quick-filters" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <button class="filter-btn active" data-filter="all" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 25px; font-weight: 600; cursor: pointer;">
                    All Tours
                </button>
                <button class="filter-btn" data-filter="cruises" style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 25px; font-weight: 600; cursor: pointer;">
                    Cruises
                </button>
                <button class="filter-btn" data-filter="helicopter" style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 25px; font-weight: 600; cursor: pointer;">
                    Helicopter
                </button>
                <button class="filter-btn" data-filter="adventure" style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 25px; font-weight: 600; cursor: pointer;">
                    Adventure
                </button>
            </div>
            
        </div>
    </header>

    <!-- Featured Tours Section -->
    <?php
    $featured_tours = new WP_Query(array(
        'post_type' => 'tours',
        'posts_per_page' => 3,
        'meta_query' => array(
            array(
                'key' => 'featured_tour',
                'value' => '1',
                'compare' => '='
            )
        )
    ));
    
    if ($featured_tours->have_posts()) :
    ?>
        <section class="featured-tours" style="padding: 4rem 0; background: #f8fafc;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                
                <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                    <span style="background: linear-gradient(135deg, #2dd4bf, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700; font-size: 1rem; text-transform: uppercase; letter-spacing: 2px;">Featured Experiences</span>
                    <h2 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin: 1rem 0; color: #1e293b;">Our Most Popular Tours</h2>
                    <p style="color: #64748b; font-size: 1.25rem; max-width: 600px; margin: 0 auto;">Hand-picked adventures that showcase the very best of Milford Sound's natural beauty</p>
                </div>
                
                <div class="featured-tours-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                    <?php while ($featured_tours->have_posts()) : $featured_tours->the_post(); ?>
                        <?php
                        $tour_overview = get_field('tour_overview');
                        $tour_highlights = get_field('tour_highlights');
                        $tour_reviews = get_field('tour_reviews');
                        ?>
                        
                        <article class="featured-tour-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="tour-image" style="height: 250px; overflow: hidden; position: relative;">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                    </a>
                                    
                                    <!-- Price Badge -->
                                    <?php if ($tour_overview && $tour_overview['tour_price']) : ?>
                                        <div class="price-badge" style="position: absolute; top: 1rem; right: 1rem; background: #2dd4bf; color: white; padding: 0.5rem 1rem; border-radius: 25px; font-weight: 700; box-shadow: 0 4px 12px rgba(45, 212, 191, 0.3);">
                                            <?php echo esc_html($tour_overview['tour_price']); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Featured Badge -->
                                    <div class="featured-badge" style="position: absolute; top: 1rem; left: 1rem; background: linear-gradient(135deg, #f59e0b, #f97316); color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                        ⭐ Featured
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="tour-content" style="padding: 2rem;">
                                
                                <!-- Tour Meta -->
                                <?php if ($tour_overview) : ?>
                                    <div class="tour-meta" style="display: flex; gap: 1.5rem; margin-bottom: 1rem; font-size: 0.8rem; color: #64748b;">
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
                                        
                                        <?php if ($tour_reviews && $tour_reviews['average_rating']) : ?>
                                            <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                <span>⭐</span>
                                                <span><?php echo esc_html($tour_reviews['average_rating']); ?></span>
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
                                                <span style="background: #f1f5f9; color: #64748b; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; display: flex; align-items: center; gap: 0.25rem;">
                                                    <span><?php echo esc_html($highlight['highlight_icon']); ?></span>
                                                    <span><?php echo esc_html($highlight['highlight_title']); ?></span>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="tour-cta-btn" style="background: linear-gradient(135deg, #2dd4bf, #3b82f6); color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; width: 100%; justify-content: center; transition: all 0.3s ease;">
                    View Details & Book →
                </a>
                                
                            </div>
                        </article>
                        
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
                
            </div>
        </section>
    <?php endif; ?>

    <!-- All Tours Section -->
    <section class="all-tours" style="padding: 4rem 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            
            <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 1rem; color: #1e293b;">All Available Tours</h2>
                <p style="color: #64748b; font-size: 1.25rem;">Choose from our complete collection of Milford Sound experiences</p>
            </div>
            
            <!-- Filter & Sort Controls -->
            <div class="tour-controls" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; flex-wrap: wrap; gap: 1rem;">
                
                <!-- Category Filter -->
                <div class="category-filters" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <?php
                    $tour_categories = get_terms(array(
                        'taxonomy' => 'tour_category',
                        'hide_empty' => true
                    ));
                    
                    if ($tour_categories) :
                    ?>
                        <span style="color: #64748b; font-weight: 600; margin-right: 0.5rem; align-self: center;">Filter:</span>
                        <a href="<?php echo get_post_type_archive_link('tours'); ?>" class="category-filter active" style="background: #2dd4bf; color: white; padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                            All
                        </a>
                        <?php foreach ($tour_categories as $category) : ?>
                            <a href="<?php echo get_term_link($category); ?>" class="category-filter" style="background: #f1f5f9; color: #64748b; padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Sort Options -->
                <div class="sort-options" style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="color: #64748b; font-weight: 600;">Sort by:</span>
                    <select class="sort-select" style="background: white; border: 1px solid #e2e8f0; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.9rem;">
                        <option value="menu_order">Recommended</option>
                        <option value="title">Name A-Z</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="rating">Highest Rated</option>
                    </select>
                </div>
                
            </div>
            
            <!-- Tours Grid -->
            <?php if (have_posts()) : ?>
                <div class="tours-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
                    
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                        $tour_overview = get_field('tour_overview');
                        $tour_highlights = get_field('tour_highlights');
                        $tour_reviews = get_field('tour_reviews');
                        $tour_categories = get_the_terms(get_the_ID(), 'tour_category');
                        ?>
                        
                        <article class="tour-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f1f5f9;">
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="tour-image" style="height: 200px; overflow: hidden; position: relative;">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                    </a>
                                    
                                    <!-- Price Badge -->
                                    <?php if ($tour_overview && $tour_overview['tour_price']) : ?>
                                        <div class="price-badge" style="position: absolute; top: 1rem; right: 1rem; background: rgba(45, 212, 191, 0.9); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 700; backdrop-filter: blur(10px);">
                                            <?php echo esc_html($tour_overview['tour_price']); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Category Badge -->
                                    <?php if ($tour_categories) : ?>
                                        <div class="category-badge" style="position: absolute; bottom: 1rem; left: 1rem; background: rgba(255,255,255,0.9); color: #1e293b; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                            <?php echo esc_html($tour_categories[0]->name); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="tour-content" style="padding: 1.5rem;">
                                
                                <!-- Tour Meta -->
                                <?php if ($tour_overview) : ?>
                                    <div class="tour-meta" style="display: flex; gap: 1rem; margin-bottom: 1rem; font-size: 0.8rem; color: #64748b; flex-wrap: wrap;">
                                        <?php if ($tour_overview['tour_duration']) : ?>
                                            <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                <span>⏰</span>
                                                <span><?php echo esc_html($tour_overview['tour_duration']); ?></span>
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
                                
                                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.4;">
                                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                
                                <p style="color: #64748b; margin-bottom: 1rem; line-height: 1.6; font-size: 0.9rem;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                </p>
                                
                                <!-- Tour Highlights -->
                                <?php if ($tour_highlights && !empty($tour_highlights)) : ?>
                                    <div class="tour-highlights" style="margin-bottom: 1rem;">
                                        <div style="display: flex; flex-wrap: wrap; gap: 0.25rem;">
                                            <?php foreach (array_slice($tour_highlights, 0, 2) as $highlight) : ?>
                                                <span style="background: #f8fafc; color: #64748b; padding: 0.2rem 0.5rem; border-radius: 10px; font-size: 0.7rem; display: flex; align-items: center; gap: 0.25rem;">
                                                    <span><?php echo esc_html($highlight['highlight_icon']); ?></span>
                                                    <span><?php echo esc_html($highlight['highlight_title']); ?></span>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="tour-cta-btn" style="background: #2dd4bf; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; width: 100%; justify-content: center; transition: all 0.3s ease;">
                                    View Details →
                                </a>
                                
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
                    <div style="font-size: 4rem; margin-bottom: 2rem;">🏔️</div>
                    <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #1e293b;">No Tours Found</h2>
                    <p style="color: #64748b; font-size: 1.25rem; margin-bottom: 2rem;">We're currently updating our tour offerings. Check back soon for amazing new experiences!</p>
                    <a href="<?php echo home_url(); ?>" class="btn btn-primary" style="background: #2dd4bf; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                        Return to Homepage →
                    </a>
                </div>
            <?php endif; ?>
            
        </div>
    </section>
    
</main>

<style>
/* Tours Archive Specific Styles */
.featured-tour-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.featured-tour-card:hover img {
    transform: scale(1.05);
}

.tour-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

.tour-card:hover img {
    transform: scale(1.03);
}

.tour-cta-btn:hover {
    background: #22c55e !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(45, 212, 191, 0.4);
}

.filter-btn:hover,
.category-filter:hover {
    background: rgba(255,255,255,0.2) !important;
    color: white !important;
    transform: translateY(-2px);
}

.filter-btn.active {
    background: rgba(255,255,255,0.2) !important;
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
    background: #2dd4bf;
    color: white;
    border-color: #2dd4bf;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .archive-stats {
        gap: 2rem !important;
    }
    
    .quick-filters {
        gap: 0.5rem !important;
    }
    
    .filter-btn {
        font-size: 0.8rem !important;
        padding: 0.5rem 1rem !important;
    }
    
    .tour-controls {
        flex-direction: column !important;
        align-items: stretch !important;
    }
    
    .category-filters {
        justify-content: center;
    }
    
    .tours-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important;
    }
}

@media (max-width: 480px) {
    .featured-tours-grid {
        grid-template-columns: 1fr !important;
    }
    
    .tours-grid {
        grid-template-columns: 1fr !important;
    }
    
    .tour-meta {
        flex-direction: column !important;
        gap: 0.5rem !important;
    }
}
</style>

<?php get_footer(); ?>