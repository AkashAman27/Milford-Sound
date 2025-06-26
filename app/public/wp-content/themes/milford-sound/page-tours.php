<?php
/**
 * Template Name: Tours Page
 * Description: Displays all tour categories in a professional grid/list layout
 */

get_header(); 

// Helper function for safe array access
if (!function_exists('safe_get')) {
    function safe_get($array, $key, $default = '') {
        return (is_array($array) && isset($array[$key])) ? $array[$key] : $default;
    }
}

// Query all tour categories
$categories_query = new WP_Query(array(
    'post_type' => 'categories',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC'
));
?>

<main class="main-content page-tours">
    
    <!-- Tours Page Header -->
    <header class="tours-header" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%); color: white; text-align: center;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            
            <h1 style="font-size: clamp(3rem, 8vw, 5rem); font-weight: 900; margin-bottom: 2rem; line-height: 1.1; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                Explore All Tours
            </h1>
            
            <p style="font-size: 1.5rem; margin-bottom: 3rem; opacity: 0.95; line-height: 1.6; max-width: 800px; margin-left: auto; margin-right: auto; text-shadow: 0 1px 3px rgba(0,0,0,0.4);">
                Discover amazing experiences across all our tour categories. From adventure activities to cultural experiences, find the perfect tour for your next adventure.
            </p>
            
            <!-- Quick Stats -->
            <div style="display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap;">
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.25rem; color: #2dd4bf; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        <?php echo $categories_query->found_posts; ?>
                    </div>
                    <div style="font-size: 0.9rem; opacity: 0.8;">Categories</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.25rem; color: #2dd4bf; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        <?php echo wp_count_posts('tours')->publish; ?>+
                    </div>
                    <div style="font-size: 0.9rem; opacity: 0.8;">Tours Available</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.25rem; color: #2dd4bf; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">5.0</div>
                    <div style="font-size: 0.9rem; opacity: 0.8;">Average Rating</div>
                </div>
            </div>
            
        </div>
    </header>

    <!-- Categories Content -->
    <div class="categories-content" style="padding: 4rem 0; background: #f8fafc;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            
            <?php if ($categories_query->have_posts()) : ?>
                
                <!-- Filter and Sort Options -->
                <div style="background: white; padding: 2rem; border-radius: 20px; margin-bottom: 3rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h2 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 0;">
                                Showing <?php echo $categories_query->found_posts; ?> Categories
                            </h2>
                        </div>
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <select id="category-sort" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 0.5rem 1rem; border-radius: 8px; color: #64748b;">
                                <option value="default">Sort by Default</option>
                                <option value="name">Sort by Name</option>
                                <option value="newest">Sort by Newest</option>
                                <option value="popular">Sort by Popularity</option>
                            </select>
                            <div style="display: flex; gap: 0.5rem;">
                                <button id="grid-view" class="view-toggle active" data-view="grid" style="background: #2dd4bf; color: white; border: none; padding: 0.5rem; border-radius: 6px; cursor: pointer; transition: all 0.3s ease;">
                                    ⊞
                                </button>
                                <button id="list-view" class="view-toggle" data-view="list" style="background: #f1f5f9; color: #64748b; border: none; padding: 0.5rem; border-radius: 6px; cursor: pointer; transition: all 0.3s ease;">
                                    ☰
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Categories Grid/List -->
                <div id="categories-container" class="categories-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                    
                    <?php while ($categories_query->have_posts()) : $categories_query->the_post(); ?>
                        <?php
                        // Get ACF fields for each category
                        $category_hero = get_field('category_hero') ?: array();
                        $featured_tours = get_field('featured_tours') ?: array();
                        $pro_tips = get_field('pro_tips') ?: array();
                        $similar_things = get_field('similar_things') ?: array();
                        
                        // Get category stats
                        $hero_stats = safe_get($category_hero, 'hero_stats', array());
                        $hero_bg_image = safe_get($category_hero, 'hero_background_image');
                        $rank_badge = safe_get($category_hero, 'rank_badge');
                        $category_subtitle = safe_get($category_hero, 'subtitle');
                        
                        // Count related tours
                        $related_tours_count = !empty($featured_tours) ? count($featured_tours) : 0;
                        
                        // Get first few pro tips for preview
                        $tips_list = safe_get($pro_tips, 'tips_list', array());
                        ?>
                        
                        <article class="category-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; position: relative; cursor: pointer;">
                            
                            <!-- Category Image -->
                            <div style="height: 200px; overflow: hidden; position: relative;">
                                <?php if ($hero_bg_image) : ?>
                                    <img src="<?php echo esc_url($hero_bg_image['url']); ?>" alt="<?php echo esc_attr($hero_bg_image['alt']); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                <?php elseif (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                <?php else : ?>
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #2dd4bf, #3b82f6); display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                                        🌟
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Overlay -->
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.3) 100%);"></div>
                                
                                <!-- Rank Badge -->
                                <?php if ($rank_badge) : ?>
                                    <div style="position: absolute; top: 1rem; left: 1rem; background: linear-gradient(135deg, #f59e0b, #f97316); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; backdrop-filter: blur(10px);">
                                        📍 <?php echo esc_html($rank_badge); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Tours Count -->
                                <div style="position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.7); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; backdrop-filter: blur(10px);">
                                    <?php echo $related_tours_count; ?>+ Tours
                                </div>
                            </div>
                            
                            <!-- Category Content -->
                            <div style="padding: 2rem;">
                                
                                <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.3;">
                                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: #1e293b; transition: color 0.3s ease;">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                                <?php if ($category_subtitle) : ?>
                                    <p style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">
                                        <?php echo esc_html(wp_trim_words($category_subtitle, 20)); ?>
                                    </p>
                                <?php else : ?>
                                    <p style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">
                                        <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 20); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <!-- Category Stats -->
                                <?php if (!empty($hero_stats)) : ?>
                                    <div style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                                        <?php foreach (array_slice($hero_stats, 0, 3) as $stat) : ?>
                                            <div style="text-align: center; flex: 1; min-width: 60px;">
                                                <div style="font-size: 0.8rem; color: #64748b; margin-bottom: 0.25rem;"><?php echo esc_html(safe_get($stat, 'icon')); ?></div>
                                                <div style="font-size: 1.1rem; font-weight: 700; color: #2dd4bf; margin-bottom: 0.25rem;"><?php echo esc_html(safe_get($stat, 'number')); ?></div>
                                                <div style="font-size: 0.7rem; color: #94a3b8;"><?php echo esc_html(wp_trim_words(safe_get($stat, 'text'), 2)); ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Tips Preview -->
                                <?php if (!empty($tips_list)) : ?>
                                    <div style="margin-bottom: 1.5rem;">
                                        <div style="font-size: 0.9rem; color: #64748b; margin-bottom: 0.5rem;">Pro Tips:</div>
                                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                            <?php foreach (array_slice($tips_list, 0, 2) as $tip) : ?>
                                                <span style="background: #f0fdf4; color: #16a34a; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; display: flex; align-items: center; gap: 0.25rem;">
                                                    <span>💡</span>
                                                    <span><?php echo esc_html(wp_trim_words(safe_get($tip, 'content'), 3)); ?></span>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Action Buttons -->
                                <div style="display: flex; gap: 1rem; align-items: center;">
                                    <a href="<?php the_permalink(); ?>" style="background: #2dd4bf; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; flex: 1; text-align: center; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(45, 212, 191, 0.2);">
                                        Explore Category
                                    </a>
                                    <button class="favorite-btn" data-category="<?php echo get_the_ID(); ?>" style="background: #f1f5f9; border: 1px solid #e2e8f0; color: #64748b; padding: 0.75rem; border-radius: 50%; cursor: pointer; transition: all 0.3s ease;">
                                        ♡
                                    </button>
                                </div>
                                
                            </div>
                            
                        </article>
                        
                    <?php endwhile; ?>
                    
                </div>
                
                <!-- Pagination (if needed for large numbers of categories) -->
                <?php if ($categories_query->max_num_pages > 1) : ?>
                    <div style="margin-top: 4rem; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 0.5rem; flex-wrap: wrap;">
                            <button style="background: white; color: #64748b; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer;">← Previous</button>
                            <button style="background: #2dd4bf; color: white; padding: 0.75rem 1rem; border-radius: 8px; border: none; cursor: pointer;">1</button>
                            <button style="background: white; color: #64748b; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer;">2</button>
                            <button style="background: white; color: #64748b; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer;">Next →</button>
                        </div>
                    </div>
                <?php endif; ?>
                
            <?php else : ?>
                
                <!-- No Categories Found -->
                <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 4rem; margin-bottom: 2rem;">🔍</div>
                    <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: #1e293b;">No Categories Found</h2>
                    <p style="color: #64748b; font-size: 1.1rem; margin-bottom: 2rem;">We're working on adding new tour categories. Check back soon!</p>
                    <a href="<?php echo home_url(); ?>" style="background: #2dd4bf; color: white; padding: 1rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 600;">
                        Back to Homepage
                    </a>
                </div>
                
            <?php endif; ?>
            
        </div>
    </div>
    
    <!-- Call to Action Section -->
    <section style="background: linear-gradient(135deg, #2dd4bf, #3b82f6); color: white; padding: 4rem 2rem; text-align: center;">
        <div class="container" style="max-width: 800px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Can't Find What You're Looking For?</h2>
            <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 2rem; line-height: 1.6; text-shadow: 0 1px 3px rgba(0,0,0,0.4);">Our expert team can help you find the perfect tour or create a custom experience just for you.</p>
            
            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a href="mailto:info@milfordsound.co" style="background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; backdrop-filter: blur(10px); transition: all 0.3s ease;">
                    ✉️ Email Us
                </a>
                <a href="tel:+64312345678" style="background: white; color: #2dd4bf; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                    📞 Call Now
                </a>
            </div>
        </div>
    </section>
    
</main>

<style>
/* Tours Page Specific Styles */
.page-tours .category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.page-tours .category-card:hover img {
    transform: scale(1.05);
}

.page-tours .category-card:hover h2 a {
    color: #2dd4bf;
}

.page-tours .category-card:hover .favorite-btn {
    background: #fef3f2;
    border-color: #fecaca;
    color: #dc2626;
}

.page-tours .view-toggle.active {
    background: #2dd4bf !important;
    color: white !important;
}

.page-tours .view-toggle:hover {
    background: #22d3ee !important;
    color: white !important;
}

/* List View Styles */
.page-tours .categories-list .category-card {
    display: flex !important;
    flex-direction: row !important;
    align-items: stretch !important;
}

.page-tours .categories-list .category-card > div:first-child {
    width: 200px !important;
    height: auto !important;
    flex-shrink: 0 !important;
}

.page-tours .categories-list .category-card > div:last-child {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: space-between !important;
}

/* Enhanced Button Hover Effects */
.page-tours .category-card a[href]:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(45, 212, 191, 0.3) !important;
    background: #26d0ce !important;
}

.page-tours .category-card .favorite-btn:hover {
    transform: scale(1.1);
}

/* Call to Action Button Enhancements */
.page-tours section a:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255,255,255,0.2) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .page-tours .categories-grid {
        grid-template-columns: 1fr !important;
    }
    
    .page-tours .categories-list .category-card {
        flex-direction: column !important;
    }
    
    .page-tours .categories-list .category-card > div:first-child {
        width: 100% !important;
        height: 200px !important;
    }
    
    .page-tours .tours-header > div > div:last-child {
        flex-direction: column !important;
        gap: 2rem !important;
    }
}

@media (max-width: 480px) {
    .page-tours .tours-header {
        padding: 6rem 0 3rem !important;
    }
    
    .page-tours .category-card {
        margin-bottom: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View Toggle Functionality
    const gridViewBtn = document.getElementById('grid-view');
    const listViewBtn = document.getElementById('list-view');
    const categoriesContainer = document.getElementById('categories-container');
    
    gridViewBtn?.addEventListener('click', function() {
        categoriesContainer.className = 'categories-grid';
        categoriesContainer.style.display = 'grid';
        categoriesContainer.style.gridTemplateColumns = 'repeat(auto-fit, minmax(350px, 1fr))';
        
        this.classList.add('active');
        listViewBtn.classList.remove('active');
        
        // Save preference
        localStorage.setItem('tours-view-preference', 'grid');
    });
    
    listViewBtn?.addEventListener('click', function() {
        categoriesContainer.className = 'categories-list';
        categoriesContainer.style.display = 'flex';
        categoriesContainer.style.flexDirection = 'column';
        categoriesContainer.style.gridTemplateColumns = 'none';
        
        this.classList.add('active');
        gridViewBtn.classList.remove('active');
        
        // Save preference
        localStorage.setItem('tours-view-preference', 'list');
    });
    
    // Load saved view preference
    const savedView = localStorage.getItem('tours-view-preference');
    if (savedView === 'list') {
        listViewBtn?.click();
    }
    
    // Sort Functionality
    const sortSelect = document.getElementById('category-sort');
    sortSelect?.addEventListener('change', function() {
        const sortValue = this.value;
        console.log('Sorting by:', sortValue);
        
        // In a real implementation, this would trigger a page reload with sort parameters
        // For now, we'll just show a message
        if (sortValue !== 'default') {
            const toast = document.createElement('div');
            toast.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #2dd4bf; color: white; padding: 1rem; border-radius: 8px; z-index: 1000; animation: slideIn 0.3s ease;';
            toast.textContent = `Sorting by ${sortValue}...`;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 2000);
        }
    });
    
    // Favorite Button Functionality
    const favoriteButtons = document.querySelectorAll('.favorite-btn');
    favoriteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const categoryId = this.dataset.category;
            let favorites = JSON.parse(localStorage.getItem('favorite-categories') || '[]');
            
            if (this.textContent.trim() === '♡') {
                this.textContent = '♥';
                this.style.color = '#dc2626';
                this.style.background = '#fef3f2';
                this.style.borderColor = '#fecaca';
                
                // Add to favorites
                if (!favorites.includes(categoryId)) {
                    favorites.push(categoryId);
                }
                
                console.log('Added category to favorites:', categoryId);
            } else {
                this.textContent = '♡';
                this.style.color = '#64748b';
                this.style.background = '#f1f5f9';
                this.style.borderColor = '#e2e8f0';
                
                // Remove from favorites
                favorites = favorites.filter(id => id !== categoryId);
                
                console.log('Removed category from favorites:', categoryId);
            }
            
            // Save to localStorage
            localStorage.setItem('favorite-categories', JSON.stringify(favorites));
        });
    });
    
    // Load favorites from localStorage
    const favorites = JSON.parse(localStorage.getItem('favorite-categories') || '[]');
    favoriteButtons.forEach(btn => {
        const categoryId = btn.dataset.category;
        if (favorites.includes(categoryId)) {
            btn.textContent = '♥';
            btn.style.color = '#dc2626';
            btn.style.background = '#fef3f2';
            btn.style.borderColor = '#fecaca';
        }
    });
    
    // Add CSS animation for toast notifications
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
});
</script>

<?php 
// Reset post data
wp_reset_postdata();
get_footer(); 
?>