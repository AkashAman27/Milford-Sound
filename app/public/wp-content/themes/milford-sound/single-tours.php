<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <?php
    // Get ACF fields
    $tour_overview = get_field('tour_overview') ?: array();
    $tour_gallery = get_field('tour_gallery') ?: array();
    $tour_highlights = get_field('tour_highlights') ?: array();
    $tour_itinerary = get_field('tour_itinerary') ?: array();
    $tour_inclusions = get_field('tour_inclusions') ?: array();
    $tour_exclusions = get_field('tour_exclusions') ?: array();
    $tour_requirements = get_field('tour_requirements') ?: array();
    $tour_booking = get_field('tour_booking') ?: array();
    $tour_location = get_field('tour_location') ?: array();
    $tour_reviews = get_field('tour_reviews') ?: array();
    $tour_operator = get_field('tour_operator') ?: array();
    
    // Tour categories and tags
    $tour_categories = get_the_terms(get_the_ID(), 'tour_category');
    $tour_tags = get_the_terms(get_the_ID(), 'tour_tags');
    ?>

    <main class="main-content single-tour">
        
        <!-- Tour Header -->
        <header class="tour-header" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%); color: white; overflow: hidden;">
            
            <?php if (has_post_thumbnail()) : ?>
                <div class="tour-bg-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.3; z-index: -1;">
                    <?php the_post_thumbnail('full', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                </div>
            <?php endif; ?>
            
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 2;">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 4rem; align-items: center;">
                    
                    <!-- Tour Info -->
                    <div class="tour-info">
                        
                        <!-- Tour Categories -->
                        <?php if ($tour_categories) : ?>
                            <div class="tour-categories" style="margin-bottom: 1rem;">
                                <?php foreach ($tour_categories as $category) : ?>
                                    <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; margin-right: 0.5rem;">
                                        <?php echo esc_html($category->name); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <h1 class="tour-title" style="font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.2;">
                            <?php the_title(); ?>
                        </h1>
                        
                        <?php 
                        $duration = safe_get($tour_overview, 'tour_duration');
                        $group_size = safe_get($tour_overview, 'tour_group_size'); 
                        $difficulty = safe_get($tour_overview, 'tour_difficulty');
                        $avg_rating = safe_get($tour_reviews, 'average_rating');
                        $total_reviews = safe_get($tour_reviews, 'total_reviews', 0);
                        
                        if ($duration || $group_size || $difficulty || $avg_rating) : ?>
                            <div class="tour-meta" style="display: flex; gap: 2rem; flex-wrap: wrap; opacity: 0.9; margin-bottom: 2rem;">
                                <?php if ($duration) : ?>
                                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span>⏰</span>
                                        <span><?php echo esc_html($duration); ?></span>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($group_size) : ?>
                                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span>👥</span>
                                        <span><?php echo esc_html($group_size); ?></span>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($difficulty) : ?>
                                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span>📊</span>
                                        <span><?php echo esc_html(ucfirst(str_replace('_', ' ', $difficulty))); ?></span>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($avg_rating) : ?>
                                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span>⭐</span>
                                        <span><?php echo esc_html($avg_rating); ?> (<?php echo esc_html($total_reviews); ?> reviews)</span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="tour-excerpt" style="font-size: 1.25rem; opacity: 0.9; line-height: 1.6;">
                            <?php the_excerpt(); ?>
                        </div>
                        
                    </div>
                    
                    <!-- Booking Card -->
                    <div class="booking-card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 2rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.2);">
                        
                        <?php 
                        $tour_price = safe_get($tour_overview, 'tour_price');
                        if ($tour_price) : ?>
                            <div class="tour-price" style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: #2dd4bf;">
                                <?php echo esc_html($tour_price); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($tour_booking && $tour_booking['booking_link']) : ?>
                            <a href="<?php echo esc_url($tour_booking['booking_link']['url']); ?>" 
                               class="book-now-btn"
                               style="background: #2dd4bf; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: block; text-align: center; margin-bottom: 1.5rem; transition: all 0.3s ease;"
                               <?php if ($tour_booking['booking_link']['target']) echo 'target="' . esc_attr($tour_booking['booking_link']['target']) . '"'; ?>>
                                📅 <?php echo esc_html($tour_booking['booking_link']['title'] ?: 'Book Now'); ?>
                            </a>
                        <?php endif; ?>
                        
                        <div class="booking-features" style="font-size: 0.9rem; opacity: 0.9;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <span>✓</span>
                                <span>Instant confirmation</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <span>✓</span>
                                <span>Free cancellation</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span>✓</span>
                                <span>Best price guarantee</span>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </header>

        <!-- Tour Content -->
        <div class="tour-content" style="padding: 4rem 0; background: #f8fafc;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 4rem; align-items: start;">
                    
                    <!-- Main Content -->
                    <div class="tour-main">
                        
                        <!-- Tour Gallery Carousel -->
                        <?php if ($tour_gallery && !empty($tour_gallery)) : ?>
                            <section class="tour-gallery-section" style="margin-bottom: 4rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                                    <h2 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0;">Tour Gallery</h2>
                                    <div class="gallery-controls" style="display: flex; gap: 0.5rem;">
                                        <button class="gallery-btn gallery-prev" style="background: white; border: 1px solid #e2e8f0; color: #64748b; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">‹</button>
                                        <button class="gallery-btn gallery-next" style="background: white; border: 1px solid #e2e8f0; color: #64748b; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">›</button>
                                    </div>
                                </div>
                                
                                <div class="gallery-container" style="position: relative; overflow: hidden; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                    <div class="gallery-track" style="display: flex; transition: transform 0.5s ease;">
                                        <?php foreach ($tour_gallery as $index => $image) : ?>
                                            <div class="gallery-slide" style="min-width: 100%; position: relative;">
                                                <div style="aspect-ratio: 16/9; overflow: hidden; position: relative;">
                                                    <img src="<?php echo esc_url($image['sizes']['large']); ?>" 
                                                         alt="<?php echo esc_attr($image['alt']); ?>"
                                                         style="width: 100%; height: 100%; object-fit: cover;">
                                                    
                                                    <!-- Image Counter -->
                                                    <div style="position: absolute; top: 1.5rem; right: 1.5rem; background: rgba(0,0,0,0.7); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">
                                                        <?php echo ($index + 1); ?> / <?php echo count($tour_gallery); ?>
                                                    </div>
                                                    
                                                    <!-- Image Caption -->
                                                    <?php if ($image['caption']) : ?>
                                                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 2rem 2rem 1.5rem; font-size: 1rem;">
                                                            <?php echo esc_html($image['caption']); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <!-- Gallery Dots -->
                                    <div class="gallery-dots" style="position: absolute; bottom: 1.5rem; left: 50%; transform: translateX(-50%); display: flex; gap: 0.5rem;">
                                        <?php foreach ($tour_gallery as $index => $image) : ?>
                                            <button class="gallery-dot" data-slide="<?php echo $index; ?>" style="width: 10px; height: 10px; border-radius: 50%; border: none; background: <?php echo $index === 0 ? '#2dd4bf' : 'rgba(255,255,255,0.5)'; ?>; cursor: pointer; transition: all 0.3s ease;"></button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                
                                <!-- Thumbnail Navigation -->
                                <div class="gallery-thumbnails" style="display: flex; gap: 0.5rem; margin-top: 1rem; overflow-x: auto; padding: 0.5rem 0;">
                                    <?php foreach ($tour_gallery as $index => $image) : ?>
                                        <button class="gallery-thumb" data-slide="<?php echo $index; ?>" style="min-width: 80px; height: 60px; border-radius: 8px; overflow: hidden; border: 2px solid <?php echo $index === 0 ? '#2dd4bf' : 'transparent'; ?>; cursor: pointer; transition: all 0.3s ease; background: none; padding: 0;">
                                            <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" 
                                                 alt="<?php echo esc_attr($image['alt']); ?>"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        <?php endif; ?>

                        <!-- Tour Description -->
                        <section class="tour-description" style="margin-bottom: 4rem;">
                            <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">About This Tour</h2>
                            <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); line-height: 1.8; font-size: 1.1rem;">
                                <?php the_content(); ?>
                            </div>
                        </section>

                        <!-- Tour Highlights -->
                        <?php if ($tour_highlights && !empty($tour_highlights)) : ?>
                            <section class="tour-highlights-section" style="margin-bottom: 4rem;">
                                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">Tour Highlights</h2>
                                <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                                        <?php foreach ($tour_highlights as $highlight) : ?>
                                            <div class="highlight-item" style="display: flex; gap: 1rem;">
                                                <div style="font-size: 2rem; flex-shrink: 0;"><?php echo esc_html($highlight['highlight_icon']); ?></div>
                                                <div>
                                                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">
                                                        <?php echo esc_html($highlight['highlight_title']); ?>
                                                    </h3>
                                                    <?php if ($highlight['highlight_description']) : ?>
                                                        <p style="color: #64748b; line-height: 1.6;">
                                                            <?php echo esc_html($highlight['highlight_description']); ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </section>
                        <?php endif; ?>

                        <!-- Tour Itinerary -->
                        <?php if ($tour_itinerary && !empty($tour_itinerary)) : ?>
                            <section class="tour-itinerary-section" style="margin-bottom: 4rem;">
                                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">Tour Itinerary</h2>
                                <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                    <?php foreach ($tour_itinerary as $index => $item) : ?>
                                        <div class="itinerary-item" style="display: flex; gap: 2rem; padding: 2rem 0; <?php echo $index < count($tour_itinerary) - 1 ? 'border-bottom: 1px solid #f1f5f9;' : ''; ?>">
                                            <div class="itinerary-time" style="flex-shrink: 0; font-weight: 600; color: #2dd4bf; min-width: 100px;">
                                                <?php echo esc_html($item['itinerary_time']); ?>
                                            </div>
                                            <div class="itinerary-content" style="flex: 1;">
                                                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">
                                                    <?php echo esc_html($item['itinerary_activity']); ?>
                                                </h3>
                                                <?php if ($item['itinerary_location']) : ?>
                                                    <div style="color: #64748b; font-size: 0.9rem; margin-bottom: 0.5rem;">
                                                        📍 <?php echo esc_html($item['itinerary_location']); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ($item['itinerary_description']) : ?>
                                                    <p style="color: #64748b; line-height: 1.6;">
                                                        <?php echo esc_html($item['itinerary_description']); ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        <?php endif; ?>

                        <!-- Inclusions & Exclusions -->
                        <?php if (($tour_inclusions && !empty($tour_inclusions)) || ($tour_exclusions && !empty($tour_exclusions))) : ?>
                            <section class="inclusions-section" style="margin-bottom: 4rem;">
                                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">What's Included</h2>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
                                    
                                    <?php if ($tour_inclusions && !empty($tour_inclusions)) : ?>
                                        <div class="inclusions" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #22c55e;">✓ Included</h3>
                                            <ul style="list-style: none; padding: 0;">
                                                <?php foreach ($tour_inclusions as $inclusion) : ?>
                                                    <li style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; color: #1e293b;">
                                                        <span style="color: #22c55e; font-weight: 600;"><?php echo esc_html($inclusion['inclusion_icon']); ?></span>
                                                        <span><?php echo esc_html($inclusion['inclusion_item']); ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($tour_exclusions && !empty($tour_exclusions)) : ?>
                                        <div class="exclusions" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #ef4444;">✗ Not Included</h3>
                                            <ul style="list-style: none; padding: 0;">
                                                <?php foreach ($tour_exclusions as $exclusion) : ?>
                                                    <li style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; color: #64748b;">
                                                        <span style="color: #ef4444; font-weight: 600;"><?php echo esc_html($exclusion['exclusion_icon']); ?></span>
                                                        <span><?php echo esc_html($exclusion['exclusion_item']); ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </section>
                        <?php endif; ?>

                        <!-- Customer Reviews -->
                        <?php if ($tour_reviews && $tour_reviews['featured_reviews'] && !empty($tour_reviews['featured_reviews'])) : ?>
                            <section class="reviews-section" style="margin-bottom: 4rem;">
                                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">Customer Reviews</h2>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                                    <?php foreach ($tour_reviews['featured_reviews'] as $review) : ?>
                                        <div class="review-card" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                                            
                                            <div class="review-rating" style="margin-bottom: 1rem;">
                                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                    <span style="color: <?php echo $i <= $review['review_rating'] ? '#fbbf24' : '#e5e7eb'; ?>;">⭐</span>
                                                <?php endfor; ?>
                                            </div>
                                            
                                            <blockquote style="font-style: italic; color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">
                                                "<?php echo esc_html($review['review_text']); ?>"
                                            </blockquote>
                                            
                                            <div class="review-author">
                                                <div style="font-weight: 600; color: #1e293b;">
                                                    <?php echo esc_html($review['reviewer_name']); ?>
                                                </div>
                                                <?php if ($review['reviewer_location']) : ?>
                                                    <div style="font-size: 0.9rem; color: #64748b;">
                                                        <?php echo esc_html($review['reviewer_location']); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ($review['review_date']) : ?>
                                                    <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                                                        <?php echo date('F Y', strtotime($review['review_date'])); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        <?php endif; ?>
                        
                    </div>

                    <!-- Sidebar -->
                    <aside class="tour-sidebar">
                        
                        <!-- Quick Info -->
                        <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Quick Info</h3>
                            
                            <?php if ($tour_overview) : ?>
                                <div class="quick-info-grid" style="display: grid; gap: 1rem;">
                                    
                                    <?php if (safe_get($tour_overview, 'tour_duration')) : ?>
                                        <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9;">
                                            <span style="color: #64748b;">Duration</span>
                                            <span style="font-weight: 600;"><?php echo esc_html(safe_get($tour_overview, 'tour_duration')); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (safe_get($tour_overview, 'tour_group_size')) : ?>
                                        <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9;">
                                            <span style="color: #64748b;">Group Size</span>
                                            <span style="font-weight: 600;"><?php echo esc_html(safe_get($tour_overview, 'tour_group_size')); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (safe_get($tour_overview, 'tour_difficulty')) : ?>
                                        <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9;">
                                            <span style="color: #64748b;">Difficulty</span>
                                            <span style="font-weight: 600;"><?php echo esc_html(ucfirst(str_replace('_', ' ', safe_get($tour_overview, 'tour_difficulty')))); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (safe_get($tour_overview, 'tour_availability')) : ?>
                                        <div style="display: flex; justify-content: space-between; padding: 0.75rem 0;">
                                            <span style="color: #64748b;">Availability</span>
                                            <span style="font-weight: 600;"><?php echo esc_html(ucfirst(str_replace('_', ' ', safe_get($tour_overview, 'tour_availability')))); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Tour Tags -->
                        <?php if ($tour_tags) : ?>
                            <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Tour Features</h3>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                    <?php foreach ($tour_tags as $tag) : ?>
                                        <span style="background: #f1f5f9; color: #64748b; padding: 0.5rem 1rem; border-radius: 25px; font-size: 0.8rem; font-weight: 600;">
                                            <?php echo esc_html($tag->name); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Contact Information -->
                        <div class="sidebar-widget" style="background: linear-gradient(135deg, #2dd4bf, #3b82f6); color: white; padding: 2rem; border-radius: 15px; margin-bottom: 2rem; text-align: center;">
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Need Help?</h3>
                            <p style="opacity: 0.9; margin-bottom: 1.5rem; font-size: 0.9rem;">Have questions about this tour? Our experts are here to help!</p>
                            <div style="margin-bottom: 1rem;">
                                <div style="font-weight: 600; margin-bottom: 0.5rem;">📞 +64 3 123 4567</div>
                                <div style="font-size: 0.9rem; opacity: 0.8;">Available 8am - 6pm NZST</div>
                            </div>
                            <a href="mailto:info@milfordsound.co" style="background: rgba(255,255,255,0.2); color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                                ✉️ Email Us
                            </a>
                        </div>

                        <!-- Related Tours -->
                        <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Other Tours</h3>
                            
                            <?php
                            // Get related tours
                            $related_tours = new WP_Query(array(
                                'post_type' => 'tours',
                                'posts_per_page' => 3,
                                'post__not_in' => array(get_the_ID())
                            ));
                            
                            if ($related_tours->have_posts()) :
                                while ($related_tours->have_posts()) : $related_tours->the_post();
                                    $related_tour_overview = get_field('tour_overview');
                            ?>
                                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                    <div style="flex-shrink: 0;">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('thumbnail', array('style' => 'width: 60px; height: 60px; object-fit: cover; border-radius: 8px;')); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div style="flex: 1;">
                                        <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: #1e293b; font-weight: 600; font-size: 0.9rem; line-height: 1.4;">
                                            <?php echo wp_trim_words(get_the_title(), 6); ?>
                                        </a>
                                        <?php if ($related_tour_overview && $related_tour_overview['tour_price']) : ?>
                                            <div style="color: #2dd4bf; font-size: 0.8rem; margin-top: 0.25rem;">
                                                <?php echo esc_html($related_tour_overview['tour_price']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php 
                                endwhile;
                                wp_reset_postdata();
                            endif; 
                            ?>
                        </div>
                        
                    </aside>
                    
                </div>
            </div>
        </div>
        
    </main>

<?php endwhile; ?>

<style>
/* Tour Page Specific Styles */
.book-now-btn:hover {
    background: #22c55e !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(45, 212, 191, 0.4);
}

.review-card:hover {
    transform: translateY(-3px);
}

/* Gallery Carousel Styles */
.gallery-btn:hover {
    background: #2dd4bf !important;
    color: white !important;
    border-color: #2dd4bf !important;
    transform: scale(1.1);
}

.gallery-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.gallery-btn:disabled:hover {
    background: white !important;
    color: #64748b !important;
    border-color: #e2e8f0 !important;
    transform: none !important;
}

.gallery-dot.active {
    background: #2dd4bf !important;
    transform: scale(1.2);
}

.gallery-thumb.active {
    border-color: #2dd4bf !important;
}

.gallery-thumb:hover {
    border-color: #22d3ee !important;
    transform: scale(1.05);
}

.gallery-thumbnails {
    scrollbar-width: thin;
    scrollbar-color: #2dd4bf #f1f5f9;
}

.gallery-thumbnails::-webkit-scrollbar {
    height: 4px;
}

.gallery-thumbnails::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 2px;
}

.gallery-thumbnails::-webkit-scrollbar-thumb {
    background: #2dd4bf;
    border-radius: 2px;
}

.gallery-thumbnails::-webkit-scrollbar-thumb:hover {
    background: #22d3ee;
}

/* Responsive */
@media (max-width: 768px) {
    .tour-header > div > div {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    
    .tour-content > div > div {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    
    .inclusions-section > div {
        grid-template-columns: 1fr !important;
    }
    
    .gallery-thumbnails {
        display: none;
    }
}

@media (max-width: 480px) {
    .itinerary-item {
        flex-direction: column !important;
        gap: 1rem !important;
    }
    
    .gallery-controls {
        display: none !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery Carousel Functionality
    const galleryTrack = document.querySelector('.gallery-track');
    const gallerySlides = document.querySelectorAll('.gallery-slide');
    const galleryPrev = document.querySelector('.gallery-prev');
    const galleryNext = document.querySelector('.gallery-next');
    const galleryDots = document.querySelectorAll('.gallery-dot');
    const galleryThumbs = document.querySelectorAll('.gallery-thumb');
    
    if (!galleryTrack || gallerySlides.length === 0) return;
    
    let currentSlide = 0;
    const totalSlides = gallerySlides.length;
    
    // Update gallery display
    function updateGallery() {
        const translateX = -currentSlide * 100;
        galleryTrack.style.transform = `translateX(${translateX}%)`;
        
        // Update dots
        galleryDots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
            dot.style.background = index === currentSlide ? '#2dd4bf' : 'rgba(255,255,255,0.5)';
        });
        
        // Update thumbnails
        galleryThumbs.forEach((thumb, index) => {
            thumb.classList.toggle('active', index === currentSlide);
            thumb.style.borderColor = index === currentSlide ? '#2dd4bf' : 'transparent';
        });
        
        // Update navigation buttons
        if (galleryPrev) galleryPrev.disabled = currentSlide === 0;
        if (galleryNext) galleryNext.disabled = currentSlide === totalSlides - 1;
    }
    
    // Next slide
    function nextSlide() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateGallery();
        }
    }
    
    // Previous slide
    function prevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateGallery();
        }
    }
    
    // Go to specific slide
    function goToSlide(slideIndex) {
        if (slideIndex >= 0 && slideIndex < totalSlides) {
            currentSlide = slideIndex;
            updateGallery();
        }
    }
    
    // Event listeners
    galleryNext?.addEventListener('click', nextSlide);
    galleryPrev?.addEventListener('click', prevSlide);
    
    galleryDots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToSlide(index));
    });
    
    galleryThumbs.forEach((thumb, index) => {
        thumb.addEventListener('click', () => goToSlide(index));
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') prevSlide();
        if (e.key === 'ArrowRight') nextSlide();
    });
    
    // Touch/swipe support
    let touchStartX = 0;
    let touchEndX = 0;
    
    galleryTrack.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    galleryTrack.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                nextSlide(); // Swipe left - next slide
            } else {
                prevSlide(); // Swipe right - previous slide
            }
        }
    }
    
    // Auto-play (optional)
    let autoplayInterval;
    const autoplayDelay = 5000; // 5 seconds
    
    function startAutoplay() {
        autoplayInterval = setInterval(() => {
            if (currentSlide === totalSlides - 1) {
                goToSlide(0); // Loop back to first slide
            } else {
                nextSlide();
            }
        }, autoplayDelay);
    }
    
    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
        }
    }
    
    // Start autoplay and pause on hover
    if (totalSlides > 1) {
        startAutoplay();
        
        const galleryContainer = document.querySelector('.gallery-container');
        galleryContainer?.addEventListener('mouseenter', stopAutoplay);
        galleryContainer?.addEventListener('mouseleave', startAutoplay);
    }
    
    // Initialize gallery
    updateGallery();
});
</script>

<?php get_footer(); ?>