<?php get_header(); ?>

<main class="main-content guides-archive">
    
    <!-- Guides Archive Header -->
    <header class="archive-header" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); color: white; text-align: center; overflow: hidden;">
        
        <!-- Background Pattern -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; z-index: -1; background-image: url('data:image/svg+xml,<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.3"><path d="M20 20l10-10v10h-10zm0 0l-10 10h10v-10z"/></g></svg>');"></div>
        
        <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 2;">
            
            <div class="archive-icon" style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
            
            <h1 class="archive-title" style="font-size: clamp(3rem, 8vw, 5rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.1;">
                Travel Guides
            </h1>
            
            <p class="archive-description" style="font-size: 1.5rem; margin-bottom: 3rem; opacity: 0.9; max-width: 700px; margin-left: auto; margin-right: auto;">
                Expert insights, practical tips, and comprehensive guides to help you plan the perfect Milford Sound adventure. Written by local experts who know the region inside and out.
            </p>
            
            <!-- Archive Stats -->
            <div class="archive-stats" style="display: flex; justify-content: center; gap: 4rem; flex-wrap: wrap; margin-bottom: 3rem;">
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;"><?php echo wp_count_posts('guides')->publish; ?></div>
                    <div style="opacity: 0.9;">Travel Guides</div>
                </div>
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">10+</div>
                    <div style="opacity: 0.9;">Topics Covered</div>
                </div>
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">5 min</div>
                    <div style="opacity: 0.9;">Average Read</div>
                </div>
            </div>
            
            <!-- Guide Type Filters -->
            <div class="guide-type-filters" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <button class="filter-btn active" data-filter="all" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 25px; font-weight: 600; cursor: pointer;">
                    All Guides
                </button>
                <button class="filter-btn" data-filter="planning" style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 25px; font-weight: 600; cursor: pointer;">
                    Planning
                </button>
                <button class="filter-btn" data-filter="activities" style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 25px; font-weight: 600; cursor: pointer;">
                    Activities
                </button>
                <button class="filter-btn" data-filter="photography" style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 25px; font-weight: 600; cursor: pointer;">
                    Photography
                </button>
            </div>
            
        </div>
    </header>

    <!-- Featured Guides Section -->
    <?php
    $featured_guides = new WP_Query(array(
        'post_type' => 'guides',
        'posts_per_page' => 2,
        'meta_query' => array(
            array(
                'key' => 'featured_guide',
                'value' => '1',
                'compare' => '='
            )
        )
    ));
    
    if ($featured_guides->have_posts()) :
    ?>
        <section class="featured-guides" style="padding: 4rem 0; background: #f8fafc;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                
                <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                    <span style="background: linear-gradient(135deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700; font-size: 1rem; text-transform: uppercase; letter-spacing: 2px;">Editor's Choice</span>
                    <h2 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin: 1rem 0; color: #1e293b;">Essential Reading</h2>
                    <p style="color: #64748b; font-size: 1.25rem; max-width: 600px; margin: 0 auto;">Must-read guides that every Milford Sound visitor should know about</p>
                </div>
                
                <div class="featured-guides-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 3rem;">
                    <?php while ($featured_guides->have_posts()) : $featured_guides->the_post(); ?>
                        <?php
                        $guide_overview = get_field('guide_overview');
                        $guide_quick_facts = get_field('guide_quick_facts');
                        $guide_categories = get_the_terms(get_the_ID(), 'guide_category');
                        
                        // Guide type colors
                        $type_colors = array(
                            'planning' => '#3b82f6',
                            'activities' => '#22c55e',
                            'accommodation' => '#f59e0b',
                            'transportation' => '#8b5cf6',
                            'dining' => '#ef4444',
                            'photography' => '#ec4899',
                            'weather' => '#06b6d4',
                            'budget' => '#10b981',
                            'family' => '#f97316',
                            'adventure' => '#84cc16'
                        );
                        
                        $guide_color = $type_colors[$guide_overview['guide_type']] ?? '#3b82f6';
                        ?>
                        
                        <article class="featured-guide-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            
                            <div style="display: grid; grid-template-columns: 1fr 250px; gap: 0; min-height: 300px;">
                                
                                <div class="guide-content" style="padding: 2.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                                    
                                    <div>
                                        <!-- Guide Categories -->
                                        <?php if ($guide_categories) : ?>
                                            <div class="guide-categories" style="margin-bottom: 1rem;">
                                                <span style="background: <?php echo esc_attr($guide_color); ?>; color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                                    <?php echo esc_html($guide_categories[0]->name); ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <h3 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.3;">
                                            <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        
                                        <!-- Guide Meta -->
                                        <?php if ($guide_overview) : ?>
                                            <div class="guide-meta" style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem; font-size: 0.8rem; color: #64748b; flex-wrap: wrap;">
                                                <?php if ($guide_overview['guide_type']) : ?>
                                                    <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                        <span>📋</span>
                                                        <span><?php echo esc_html(ucfirst(str_replace('_', ' ', $guide_overview['guide_type']))); ?></span>
                                                    </span>
                                                <?php endif; ?>
                                                
                                                <?php if ($guide_overview['guide_difficulty']) : ?>
                                                    <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                        <span>📊</span>
                                                        <span><?php echo esc_html(ucfirst($guide_overview['guide_difficulty'])); ?></span>
                                                    </span>
                                                <?php endif; ?>
                                                
                                                <?php if ($guide_overview['estimated_reading_time']) : ?>
                                                    <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                        <span>⏱️</span>
                                                        <span><?php echo esc_html($guide_overview['estimated_reading_time']); ?> min read</span>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <p style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">
                                            <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                                        </p>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="guide-cta-btn" style="background: <?php echo esc_attr($guide_color); ?>; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; align-self: flex-start; transition: all 0.3s ease;">
                                        Read Full Guide →
                                    </a>
                                    
                                </div>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="guide-image" style="overflow: hidden; position: relative;">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                        </a>
                                        
                                        <!-- Featured Badge -->
                                        <div class="featured-badge" style="position: absolute; top: 1rem; right: 1rem; background: linear-gradient(135deg, #f59e0b, #f97316); color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                            ⭐ Featured
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                            </div>
                        </article>
                        
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
                
            </div>
        </section>
    <?php endif; ?>

    <!-- Browse by Category Section -->
    <?php
    $guide_categories = get_terms(array(
        'taxonomy' => 'guide_category',
        'hide_empty' => true
    ));
    
    if ($guide_categories) :
    ?>
        <section class="guide-categories-section" style="padding: 4rem 0; background: white;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                
                <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                    <h2 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 1rem; color: #1e293b;">Browse by Topic</h2>
                    <p style="color: #64748b; font-size: 1.25rem;">Find guides tailored to your specific interests and travel style</p>
                </div>
                
                <div class="categories-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
                    <?php foreach ($guide_categories as $category) : ?>
                        <?php
                        $category_count = $category->count;
                        $category_icon = get_field('category_icon', 'guide_category_' . $category->term_id) ?: '📖';
                        $category_color = get_field('category_color', 'guide_category_' . $category->term_id) ?: '#3b82f6';
                        ?>
                        
                        <div class="category-card" style="background: white; border: 2px solid #f1f5f9; border-radius: 15px; padding: 2rem; text-align: center; transition: all 0.3s ease; cursor: pointer;" onclick="window.location.href='<?php echo get_term_link($category); ?>'">
                            
                            <div class="category-icon" style="font-size: 3rem; margin-bottom: 1rem;">
                                <?php echo esc_html($category_icon); ?>
                            </div>
                            
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">
                                <?php echo esc_html($category->name); ?>
                            </h3>
                            
                            <p style="color: #64748b; margin-bottom: 1rem; font-size: 0.9rem; line-height: 1.5;">
                                <?php echo esc_html($category->description ?: 'Helpful guides and tips for ' . strtolower($category->name)); ?>
                            </p>
                            
                            <div style="color: <?php echo esc_attr($category_color); ?>; font-weight: 600; font-size: 0.9rem; margin-bottom: 1rem;">
                                <?php echo esc_html($category_count); ?> guide<?php echo $category_count !== 1 ? 's' : ''; ?>
                            </div>
                            
                            <a href="<?php echo get_term_link($category); ?>" style="background: <?php echo esc_attr($category_color); ?>; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                                Explore <?php echo esc_html($category->name); ?> →
                            </a>
                            
                        </div>
                        
                    <?php endforeach; ?>
                </div>
                
            </div>
        </section>
    <?php endif; ?>

    <!-- All Guides Section -->
    <section class="all-guides" style="padding: 4rem 0; background: #f8fafc;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            
            <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 1rem; color: #1e293b;">All Travel Guides</h2>
                <p style="color: #64748b; font-size: 1.25rem;">Complete collection of expert guides and practical advice</p>
            </div>
            
            <!-- Filter & Sort Controls -->
            <div class="guide-controls" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; flex-wrap: wrap; gap: 1rem;">
                
                <!-- Category Filter -->
                <div class="category-filters" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <span style="color: #64748b; font-weight: 600; margin-right: 0.5rem; align-self: center;">Filter:</span>
                    <a href="<?php echo get_post_type_archive_link('guides'); ?>" class="category-filter active" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                        All
                    </a>
                    <?php if ($guide_categories) : ?>
                        <?php foreach ($guide_categories as $category) : ?>
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
                        <option value="title">Title A-Z</option>
                        <option value="date">Newest First</option>
                        <option value="reading_time">Quick Reads</option>
                        <option value="comprehensive">Most Comprehensive</option>
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
                        $guide_categories = get_the_terms(get_the_ID(), 'guide_category');
                        $guide_author = get_field('guide_author');
                        
                        // Guide type colors
                        $type_colors = array(
                            'planning' => '#3b82f6',
                            'activities' => '#22c55e',
                            'accommodation' => '#f59e0b',
                            'transportation' => '#8b5cf6',
                            'dining' => '#ef4444',
                            'photography' => '#ec4899',
                            'weather' => '#06b6d4',
                            'budget' => '#10b981',
                            'family' => '#f97316',
                            'adventure' => '#84cc16'
                        );
                        
                        $guide_color = $type_colors[$guide_overview['guide_type']] ?? '#3b82f6';
                        ?>
                        
                        <article class="guide-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f1f5f9;">
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="guide-image" style="height: 180px; overflow: hidden; position: relative;">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                    </a>
                                    
                                    <!-- Guide Type Badge -->
                                    <?php if ($guide_overview && $guide_overview['guide_type']) : ?>
                                        <div class="type-badge" style="position: absolute; top: 1rem; left: 1rem; background: <?php echo esc_attr($guide_color); ?>; color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                            <?php echo esc_html(ucfirst(str_replace('_', ' ', $guide_overview['guide_type']))); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Reading Time Badge -->
                                    <?php if ($guide_overview && $guide_overview['estimated_reading_time']) : ?>
                                        <div class="reading-time-badge" style="position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.7); color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600; backdrop-filter: blur(10px);">
                                            <?php echo esc_html($guide_overview['estimated_reading_time']); ?> min
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="guide-content" style="padding: 1.5rem;">
                                
                                <!-- Guide Categories -->
                                <?php if ($guide_categories) : ?>
                                    <div class="guide-categories" style="margin-bottom: 1rem;">
                                        <span style="background: #f1f5f9; color: #64748b; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                            <?php echo esc_html($guide_categories[0]->name); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
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
                                        <div style="font-size: 0.8rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">Quick Facts:</div>
                                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                            <?php foreach (array_slice($guide_quick_facts, 0, 3) as $fact) : ?>
                                                <span style="background: white; color: #64748b; padding: 0.25rem 0.5rem; border-radius: 8px; font-size: 0.7rem; display: flex; align-items: center; gap: 0.25rem;">
                                                    <span><?php echo esc_html($fact['fact_icon']); ?></span>
                                                    <span><?php echo esc_html($fact['fact_value']); ?></span>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="guide-cta-btn" style="background: <?php echo esc_attr($guide_color); ?>; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; width: 100%; justify-content: center; transition: all 0.3s ease;">
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
                <div class="no-guides" style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 20px;">
                    <div style="font-size: 4rem; margin-bottom: 2rem;">📚</div>
                    <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #1e293b;">No Guides Found</h2>
                    <p style="color: #64748b; font-size: 1.25rem; margin-bottom: 2rem;">We're working on new travel guides. Check back soon for expert advice and tips!</p>
                    <a href="<?php echo home_url(); ?>" class="btn btn-primary" style="background: #3b82f6; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                        Return to Homepage →
                    </a>
                </div>
            <?php endif; ?>
            
        </div>
    </section>
    
</main>

<style>
/* Guides Archive Specific Styles */
.featured-guide-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.featured-guide-card:hover img {
    transform: scale(1.05);
}

.guide-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

.guide-card:hover img {
    transform: scale(1.03);
}

.category-card:hover {
    transform: translateY(-5px);
    border-color: #3b82f6;
    box-shadow: 0 15px 35px rgba(59, 130, 246, 0.15);
}

.guide-cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
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
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .archive-stats {
        gap: 2rem !important;
    }
    
    .guide-type-filters {
        gap: 0.5rem !important;
    }
    
    .filter-btn {
        font-size: 0.8rem !important;
        padding: 0.5rem 1rem !important;
    }
    
    .guide-controls {
        flex-direction: column !important;
        align-items: stretch !important;
    }
    
    .category-filters {
        justify-content: center;
    }
    
    .featured-guide-card > div {
        grid-template-columns: 1fr !important;
    }
    
    .guides-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)) !important;
    }
    
    .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)) !important;
    }
}

@media (max-width: 480px) {
    .featured-guides-grid {
        grid-template-columns: 1fr !important;
    }
    
    .guides-grid {
        grid-template-columns: 1fr !important;
    }
    
    .guide-meta {
        flex-direction: column !important;
        gap: 0.5rem !important;
    }
}
</style>

<?php get_footer(); ?>