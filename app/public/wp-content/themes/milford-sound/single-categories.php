<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <?php
    // Get ACF fields for category pages
    $category_hero = get_field('category_hero') ?: array();
    $category_filters = get_field('category_filters') ?: array();
    $featured_tours = get_field('featured_tours') ?: array();
    $category_highlights = get_field('category_highlights') ?: array();
    $category_gallery = get_field('category_gallery') ?: array();
    $booking_info = get_field('booking_info') ?: array();
    $category_faq = get_field('category_faq') ?: array();
    $category_seo = get_field('category_seo') ?: array();
    
    // Hero background setup
    $hero_bg_type = safe_get($category_hero, 'hero_background_type', 'image');
    $hero_bg_image = safe_get($category_hero, 'hero_background_image');
    $hero_bg_video = safe_get($category_hero, 'hero_background_video');
    $hero_overlay = safe_get($category_hero, 'hero_overlay_color', 'rgba(0, 0, 0, 0.5)');
    
    // Determine if we have custom background
    $has_custom_bg = ($hero_bg_type === 'image' && $hero_bg_image) || ($hero_bg_type === 'video' && $hero_bg_video);
    $default_bg = $has_custom_bg ? 'transparent' : 'linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%)';
    ?>

    <main class="main-content single-category">
        
        <!-- Category Hero Section -->
        <header class="category-hero" style="position: relative; padding: 10rem 0 6rem; background: <?php echo $default_bg; ?>; color: white; overflow: hidden;">
            
            <?php if ($hero_bg_type === 'image' && $hero_bg_image) : ?>
                <div class="hero-bg-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?php echo esc_url($hero_bg_image['url']); ?>'); background-size: cover; background-position: center; z-index: 1;"></div>
                <div class="hero-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: <?php echo esc_attr($hero_overlay); ?>; z-index: 2;"></div>
            <?php elseif ($hero_bg_type === 'video' && $hero_bg_video) : ?>
                <div class="hero-bg-video" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
                    <?php if (strpos($hero_bg_video, 'youtube.com') !== false || strpos($hero_bg_video, 'youtu.be') !== false) : ?>
                        <?php
                        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $hero_bg_video, $matches);
                        $video_id = $matches[1] ?? '';
                        ?>
                        <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo esc_attr($video_id); ?>&controls=0&showinfo=0&rel=0" frameborder="0" allow="autoplay; encrypted-media" style="width: 100%; height: 100%; object-fit: cover; pointer-events: none;"></iframe>
                    <?php else : ?>
                        <video autoplay muted loop style="width: 100%; height: 100%; object-fit: cover; pointer-events: none;">
                            <source src="<?php echo esc_url($hero_bg_video); ?>" type="video/mp4">
                        </video>
                    <?php endif; ?>
                </div>
                <div class="hero-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: <?php echo esc_attr($hero_overlay); ?>; z-index: 2;"></div>
            <?php elseif (has_post_thumbnail()) : ?>
                <div class="hero-bg-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.3; z-index: -1;">
                    <?php the_post_thumbnail('full', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                </div>
            <?php endif; ?>
            
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 10; text-align: center;">
                
                <!-- Category Badge -->
                <?php if (safe_get($category_hero, 'category_badge')) : ?>
                    <div style="background: linear-gradient(135deg, #f59e0b, #f97316); color: white; padding: 0.5rem 1.5rem; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; margin-bottom: 2rem;">
                        <?php echo esc_html($category_hero['category_badge']); ?>
                    </div>
                <?php endif; ?>
                
                <h1 class="category-title" style="font-size: clamp(3rem, 8vw, 5rem); font-weight: 900; margin-bottom: 2rem; line-height: 1.1;">
                    <?php the_title(); ?>
                </h1>
                
                <?php if (safe_get($category_hero, 'category_subtitle')) : ?>
                    <p class="category-subtitle" style="font-size: 1.5rem; margin-bottom: 3rem; opacity: 0.9; line-height: 1.6; max-width: 800px; margin-left: auto; margin-right: auto;">
                        <?php echo esc_html($category_hero['category_subtitle']); ?>
                    </p>
                <?php endif; ?>
                
                <!-- Category Statistics -->
                <?php if (safe_get($category_hero, 'category_stats') && !empty($category_hero['category_stats'])) : ?>
                    <div class="category-stats" style="display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap; margin-bottom: 3rem;">
                        <?php foreach ($category_hero['category_stats'] as $stat) : ?>
                            <div style="text-align: center;">
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;"><?php echo esc_html($stat['stat_icon']); ?></div>
                                <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.25rem; color: #2dd4bf;"><?php echo esc_html($stat['stat_number']); ?></div>
                                <div style="font-size: 0.9rem; opacity: 0.8;"><?php echo esc_html($stat['stat_label']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Quick Action Buttons -->
                <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                    <a href="#tours" style="background: #2dd4bf; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
                        🎯 View All Tours
                    </a>
                    <a href="#booking" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
                        📞 Get Help
                    </a>
                </div>
                
            </div>
        </header>

        <!-- Main Content -->
        <div class="category-content" style="padding: 4rem 0; background: #f8fafc;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                
                <!-- Filter Section -->
                <?php if (safe_get($category_filters, 'enable_filters')) : ?>
                    <section class="filters-section" style="background: white; padding: 2rem; border-radius: 20px; margin-bottom: 4rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; color: #1e293b;">🔍 Filter Tours</h2>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                            
                            <!-- Duration Filters -->
                            <?php if (safe_get($category_filters, 'duration_filters') && !empty($category_filters['duration_filters'])) : ?>
                                <div>
                                    <h3 style="font-weight: 600; margin-bottom: 1rem; color: #64748b;">Duration</h3>
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                        <?php foreach ($category_filters['duration_filters'] as $duration) : ?>
                                            <button class="filter-btn" data-filter="duration" data-value="<?php echo esc_attr($duration['duration_value']); ?>" style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #64748b; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease;">
                                                <?php echo esc_html($duration['duration_label']); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Price Filters -->
                            <?php if (safe_get($category_filters, 'price_filters') && !empty($category_filters['price_filters'])) : ?>
                                <div>
                                    <h3 style="font-weight: 600; margin-bottom: 1rem; color: #64748b;">Price Range</h3>
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                        <?php foreach ($category_filters['price_filters'] as $price) : ?>
                                            <button class="filter-btn" data-filter="price" data-min="<?php echo esc_attr($price['price_min']); ?>" data-max="<?php echo esc_attr($price['price_max']); ?>" style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #64748b; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease;">
                                                <?php echo esc_html($price['price_label']); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Difficulty Filters -->
                            <?php if (safe_get($category_filters, 'difficulty_filters') && !empty($category_filters['difficulty_filters'])) : ?>
                                <div>
                                    <h3 style="font-weight: 600; margin-bottom: 1rem; color: #64748b;">Difficulty</h3>
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                        <?php foreach ($category_filters['difficulty_filters'] as $difficulty) : ?>
                                            <button class="filter-btn" data-filter="difficulty" data-value="<?php echo esc_attr($difficulty); ?>" style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #64748b; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease;">
                                                <?php echo esc_html(ucfirst($difficulty)); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                        
                        <div style="margin-top: 2rem; text-align: center;">
                            <button id="clear-filters" style="background: #64748b; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 25px; font-weight: 600; cursor: pointer;">
                                Clear All Filters
                            </button>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Featured Tours Section -->
                <?php if (safe_get($featured_tours, 'featured_tours_list') && !empty($featured_tours['featured_tours_list'])) : ?>
                    <section id="tours" class="featured-tours-section" style="margin-bottom: 4rem;">
                        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; color: #1e293b; text-align: center;">
                            <?php echo esc_html(safe_get($featured_tours, 'featured_tours_title', 'Top Rated Tours')); ?>
                        </h2>
                        <p style="text-align: center; color: #64748b; margin-bottom: 3rem; font-size: 1.1rem;">Discover the best experiences in this category</p>
                        
                        <?php 
                        $layout = safe_get($featured_tours, 'featured_layout', 'grid');
                        $grid_class = ($layout === 'list') ? 'grid-template-columns: 1fr;' : 'grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));';
                        ?>
                        
                        <div class="tours-grid" style="display: grid; <?php echo $grid_class; ?> gap: 2rem;">
                            <?php foreach ($featured_tours['featured_tours_list'] as $tour) : ?>
                                <?php
                                $tour_overview = get_field('tour_overview', $tour->ID) ?: array();
                                $tour_highlights = get_field('tour_highlights', $tour->ID) ?: array();
                                ?>
                                <div class="tour-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                                    
                                    <?php if (has_post_thumbnail($tour->ID)) : ?>
                                        <div style="height: 200px; overflow: hidden; position: relative;">
                                            <a href="<?php echo get_permalink($tour->ID); ?>">
                                                <?php echo get_the_post_thumbnail($tour->ID, 'medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                            </a>
                                            <?php if (safe_get($tour_overview, 'tour_price')) : ?>
                                                <div style="position: absolute; top: 1rem; right: 1rem; background: #2dd4bf; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                                                    <?php echo esc_html($tour_overview['tour_price']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div style="padding: 2rem;">
                                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; line-height: 1.4;">
                                            <a href="<?php echo get_permalink($tour->ID); ?>" style="text-decoration: none; color: #1e293b;">
                                                <?php echo esc_html($tour->post_title); ?>
                                            </a>
                                        </h3>
                                        
                                        <p style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">
                                            <?php echo wp_trim_words($tour->post_excerpt ?: $tour->post_content, 15); ?>
                                        </p>
                                        
                                        <!-- Tour Meta -->
                                        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; font-size: 0.9rem; color: #64748b;">
                                            <?php if (safe_get($tour_overview, 'tour_duration')) : ?>
                                                <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                    <span>⏰</span>
                                                    <span><?php echo esc_html($tour_overview['tour_duration']); ?></span>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (safe_get($tour_overview, 'tour_group_size')) : ?>
                                                <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                    <span>👥</span>
                                                    <span><?php echo esc_html($tour_overview['tour_group_size']); ?></span>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (safe_get($tour_overview, 'tour_difficulty')) : ?>
                                                <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                    <span>📊</span>
                                                    <span><?php echo esc_html(ucfirst($tour_overview['tour_difficulty'])); ?></span>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <a href="<?php echo get_permalink($tour->ID); ?>" style="background: #2dd4bf; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s ease;">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Description Content -->
                <section class="category-description" style="margin-bottom: 4rem;">
                    <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); line-height: 1.8; font-size: 1.1rem;">
                        <?php the_content(); ?>
                    </div>
                </section>

                <!-- Category Highlights -->
                <?php if (safe_get($category_highlights, 'highlights_list') && !empty($category_highlights['highlights_list'])) : ?>
                    <section class="category-highlights" style="margin-bottom: 4rem;">
                        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; color: #1e293b; text-align: center;">
                            <?php echo esc_html(safe_get($category_highlights, 'highlights_title', 'Why Choose This Experience')); ?>
                        </h2>
                        
                        <?php if (safe_get($category_highlights, 'highlights_subtitle')) : ?>
                            <p style="text-align: center; color: #64748b; margin-bottom: 3rem; font-size: 1.1rem; max-width: 800px; margin-left: auto; margin-right: auto;">
                                <?php echo esc_html($category_highlights['highlights_subtitle']); ?>
                            </p>
                        <?php endif; ?>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                            <?php foreach ($category_highlights['highlights_list'] as $highlight) : ?>
                                <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); text-align: center;">
                                    <div style="font-size: 3rem; margin-bottom: 1rem;"><?php echo esc_html($highlight['highlight_icon']); ?></div>
                                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b;">
                                        <?php echo esc_html($highlight['highlight_title']); ?>
                                    </h3>
                                    <p style="color: #64748b; line-height: 1.6;">
                                        <?php echo esc_html($highlight['highlight_description']); ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Category Gallery -->
                <?php if ($category_gallery && !empty($category_gallery)) : ?>
                    <section class="category-gallery" style="margin-bottom: 4rem;">
                        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 3rem; color: #1e293b; text-align: center;">Gallery</h2>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                            <?php foreach ($category_gallery as $image) : ?>
                                <div style="aspect-ratio: 4/3; overflow: hidden; border-radius: 15px; cursor: pointer;">
                                    <img src="<?php echo esc_url($image['sizes']['medium_large']); ?>" 
                                         alt="<?php echo esc_attr($image['alt']); ?>"
                                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- FAQ Section -->
                <?php if ($category_faq && !empty($category_faq)) : ?>
                    <section class="faq-section" style="margin-bottom: 4rem;">
                        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 3rem; color: #1e293b; text-align: center;">Frequently Asked Questions</h2>
                        <div style="max-width: 800px; margin: 0 auto;">
                            <?php foreach ($category_faq as $index => $faq) : ?>
                                <div class="faq-item" style="background: white; margin-bottom: 1rem; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                                    <button class="faq-question" data-target="faq-<?php echo $index; ?>" style="width: 100%; padding: 1.5rem; text-align: left; background: none; border: none; font-size: 1.1rem; font-weight: 600; color: #1e293b; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                                        <?php echo esc_html($faq['faq_question']); ?>
                                        <span class="faq-icon">+</span>
                                    </button>
                                    <div id="faq-<?php echo $index; ?>" class="faq-answer" style="display: none; padding: 0 1.5rem 1.5rem; color: #64748b; line-height: 1.6;">
                                        <?php echo esc_html($faq['faq_answer']); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Booking Information -->
                <?php if ($booking_info) : ?>
                    <section id="booking" class="booking-section" style="background: linear-gradient(135deg, #2dd4bf, #3b82f6); color: white; padding: 4rem 2rem; border-radius: 20px; text-align: center;">
                        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 2rem;">Ready to Book?</h2>
                        <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto;">Get in touch with our team for personalized recommendations and instant booking</p>
                        
                        <!-- Booking Features -->
                        <?php if (safe_get($booking_info, 'booking_features') && !empty($booking_info['booking_features'])) : ?>
                            <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; margin-bottom: 3rem;">
                                <?php foreach ($booking_info['booking_features'] as $feature) : ?>
                                    <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.2); padding: 0.75rem 1.5rem; border-radius: 25px;">
                                        <span><?php echo esc_html($feature['feature_icon']); ?></span>
                                        <span><?php echo esc_html($feature['feature_text']); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Contact Information -->
                        <?php if (safe_get($booking_info, 'contact_info')) : ?>
                            <div style="display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap; margin-bottom: 3rem;">
                                <?php if (safe_get($booking_info['contact_info'], 'contact_phone')) : ?>
                                    <div>
                                        <div style="font-weight: 600; margin-bottom: 0.5rem;">📞 Phone</div>
                                        <div style="font-size: 1.1rem;"><?php echo esc_html($booking_info['contact_info']['contact_phone']); ?></div>
                                        <?php if (safe_get($booking_info['contact_info'], 'contact_hours')) : ?>
                                            <div style="font-size: 0.9rem; opacity: 0.8;"><?php echo esc_html($booking_info['contact_info']['contact_hours']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (safe_get($booking_info['contact_info'], 'contact_email')) : ?>
                                    <div>
                                        <div style="font-weight: 600; margin-bottom: 0.5rem;">✉️ Email</div>
                                        <div style="font-size: 1.1rem;"><?php echo esc_html($booking_info['contact_info']['contact_email']); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                            <?php if (safe_get($booking_info['contact_info'], 'contact_phone')) : ?>
                                <a href="tel:<?php echo esc_attr($booking_info['contact_info']['contact_phone']); ?>" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                                    📞 Call Now
                                </a>
                            <?php endif; ?>
                            <?php if (safe_get($booking_info['contact_info'], 'contact_email')) : ?>
                                <a href="mailto:<?php echo esc_attr($booking_info['contact_info']['contact_email']); ?>" style="background: white; color: #2dd4bf; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                                    ✉️ Email Us
                                </a>
                            <?php endif; ?>
                        </div>
                        
                    </section>
                <?php endif; ?>
                
            </div>
        </div>
        
    </main>

<?php endwhile; ?>

<style>
/* Category Page Specific Styles */
.tour-card:hover {
    transform: translateY(-5px);
}

.filter-btn:hover,
.filter-btn.active {
    background: #2dd4bf !important;
    color: white !important;
    border-color: #2dd4bf !important;
}

.faq-question:hover {
    background: #f8fafc;
}

.category-gallery img:hover {
    transform: scale(1.05);
}

/* Responsive */
@media (max-width: 768px) {
    .category-hero {
        padding: 6rem 0 4rem !important;
    }
    
    .category-stats {
        flex-direction: column !important;
        align-items: center !important;
        gap: 2rem !important;
    }
    
    .tours-grid {
        grid-template-columns: 1fr !important;
    }
    
    .category-gallery {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 480px) {
    .category-gallery {
        grid-template-columns: 1fr !important;
    }
}
</style>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const tourCards = document.querySelectorAll('.tour-card');
    const clearBtn = document.getElementById('clear-filters');
    
    let activeFilters = {
        duration: null,
        price: null,
        difficulty: null
    };
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filterType = this.dataset.filter;
            const filterValue = this.dataset.value;
            
            // Toggle active state
            if (this.classList.contains('active')) {
                this.classList.remove('active');
                activeFilters[filterType] = null;
            } else {
                // Remove active from other buttons of same type
                document.querySelectorAll(`[data-filter="${filterType}"]`).forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeFilters[filterType] = filterValue;
            }
            
            applyFilters();
        });
    });
    
    clearBtn?.addEventListener('click', function() {
        filterBtns.forEach(btn => btn.classList.remove('active'));
        activeFilters = { duration: null, price: null, difficulty: null };
        applyFilters();
    });
    
    function applyFilters() {
        // This would typically connect to a server-side filtering system
        // For now, it's a placeholder for the filtering logic
        console.log('Active filters:', activeFilters);
    }
    
    // FAQ functionality
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const answer = document.getElementById(targetId);
            const icon = this.querySelector('.faq-icon');
            
            if (answer.style.display === 'none' || !answer.style.display) {
                answer.style.display = 'block';
                icon.textContent = '−';
            } else {
                answer.style.display = 'none';
                icon.textContent = '+';
            }
        });
    });
});
</script>

<?php get_footer(); ?>