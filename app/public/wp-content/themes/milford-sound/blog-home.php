<?php get_header(); ?>

<main class="main-content">
    <!-- Blog Home Header -->
    <header class="blog-home-header" style="padding: 8rem 0 4rem; background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%); color: white; text-align: center;">
        <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 2rem;">
            <div class="blog-badge" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); padding: 0.5rem 1.5rem; border-radius: 50px; margin-bottom: 2rem; display: inline-block; font-size: 0.9rem; font-weight: 500;">
                Daily Updates
            </div>
            <h1 class="blog-title" style="font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.2;">
                Latest <span style="color: #2dd4bf;">Blog Posts</span>
            </h1>
            <p class="blog-description" style="font-size: 1.25rem; opacity: 0.9; margin-bottom: 2rem;">
                Stay updated with the latest news, travel tips, and incredible stories from Milford Sound and beyond.
            </p>
        </div>
    </header>

    <!-- Latest Posts Section -->
    <section class="latest-posts" style="padding: 4rem 0; background: #f8fafc;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            
            <?php if (have_posts()) : ?>
                
                <!-- Featured Post (Most Recent) -->
                <?php if (have_posts()) : the_post(); ?>
                    <div class="featured-post-section" style="margin-bottom: 4rem;">
                        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; color: #1e293b; text-align: center;">
                            🌟 Featured Post
                        </h2>
                        
                        <article class="featured-post" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.1);">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0; min-height: 400px;">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="featured-image" style="overflow: hidden; position: relative;">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                        </a>
                                        <div class="featured-badge" style="position: absolute; top: 1.5rem; left: 1.5rem; background: #2dd4bf; color: white; padding: 0.5rem 1rem; border-radius: 25px; font-size: 0.8rem; font-weight: 600;">
                                            Latest
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="featured-content" style="padding: 3rem; display: flex; flex-direction: column; justify-content: center;">
                                    <div class="post-meta" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #64748b;">
                                        <span>📅 <?php echo get_the_date(); ?></span>
                                        <span>👤 <?php the_author(); ?></span>
                                        <span>🏷️ <?php the_category(', '); ?></span>
                                    </div>
                                    
                                    <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: #1e293b; line-height: 1.3;">
                                        <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    
                                    <div class="post-excerpt" style="color: #64748b; font-size: 1.1rem; line-height: 1.7; margin-bottom: 2rem;">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="read-more-btn" style="background: linear-gradient(135deg, #2dd4bf, #3b82f6); color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; align-self: flex-start;">
                                        Read Full Article →
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endif; ?>

                <!-- Recent Posts Grid -->
                <div class="recent-posts-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                        <h2 style="font-size: 2rem; font-weight: 800; color: #1e293b;">Recent Posts</h2>
                        <a href="<?php echo get_permalink(get_page_by_path('blog')); ?>" style="color: #2dd4bf; text-decoration: none; font-weight: 600;">
                            View All Posts →
                        </a>
                    </div>
                    
                    <div class="posts-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="post-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-image" style="height: 200px; overflow: hidden; position: relative;">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                        </a>
                                        
                                        <!-- Category Badge -->
                                        <div class="category-badge" style="position: absolute; top: 1rem; right: 1rem; background: rgba(45, 212, 191, 0.9); color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                            <?php $category = get_the_category(); if ($category) echo $category[0]->name; ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div style="height: 200px; background: linear-gradient(135deg, #e2e8f0, #cbd5e1); display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 3rem;">
                                        📝
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-content" style="padding: 2rem;">
                                    <div class="post-meta" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; font-size: 0.8rem; color: #64748b;">
                                        <span>📅 <?php echo get_the_date('M j, Y'); ?></span>
                                        <span>👤 <?php the_author(); ?></span>
                                        <span>⏱️ <?php echo reading_time(); ?> min read</span>
                                    </div>
                                    
                                    <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.4;">
                                        <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    
                                    <div class="post-excerpt" style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" style="color: #2dd4bf; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                                        Continue Reading →
                                    </a>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="blog-pagination" style="margin-top: 4rem; text-align: center;">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '← Previous Posts',
                        'next_text' => 'Next Posts →',
                    ));
                    ?>
                </div>

            <?php else : ?>
                <!-- No Posts Found -->
                <div class="no-posts" style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 4rem; margin-bottom: 2rem;">📝</div>
                    <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #1e293b;">No Blog Posts Yet</h2>
                    <p style="color: #64748b; font-size: 1.25rem; margin-bottom: 2rem;">We're working on some amazing content for you. Check back soon!</p>
                    <?php if (current_user_can('publish_posts')) : ?>
                        <a href="<?php echo admin_url('post-new.php'); ?>" class="btn btn-primary" style="background: #2dd4bf; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; margin-right: 1rem;">
                            ✏️ Write Your First Post
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo home_url(); ?>" class="btn btn-secondary" style="background: #64748b; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                        🏠 Back to Home
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Blog Categories Section -->
    <section class="blog-categories-section" style="padding: 4rem 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; text-align: center;">
            <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">Explore by Category</h2>
            <div class="categories-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
                <?php
                $categories = get_categories(array('hide_empty' => true));
                $category_icons = ['🏔️', '🚢', '📷', '🎒', '🌿', '☀️', '🗺️', '💡'];
                foreach ($categories as $index => $category) :
                    $icon = isset($category_icons[$index]) ? $category_icons[$index] : '📝';
                ?>
                    <a href="<?php echo get_category_link($category->term_id); ?>" class="category-card" style="background: #f8fafc; padding: 2rem 1rem; border-radius: 15px; text-decoration: none; color: inherit; transition: all 0.3s ease; border: 2px solid transparent;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;"><?php echo $icon; ?></div>
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;"><?php echo $category->name; ?></h3>
                        <p style="color: #64748b; font-size: 0.9rem;"><?php echo $category->count; ?> posts</p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="newsletter-section" style="padding: 4rem 0; background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%); color: white;">
        <div class="container" style="max-width: 600px; margin: 0 auto; padding: 0 2rem; text-align: center;">
            <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem;">Never Miss a Post</h2>
            <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 2rem;">Get the latest blog posts and exclusive travel tips delivered straight to your inbox.</p>
            
            <form class="newsletter-form" style="display: flex; gap: 1rem; max-width: 400px; margin: 0 auto;">
                <input type="email" placeholder="Enter your email" style="flex: 1; padding: 1rem; border: none; border-radius: 10px; font-size: 1rem;">
                <button type="submit" style="background: rgba(255,255,255,0.2); color: white; border: none; padding: 1rem 1.5rem; border-radius: 10px; font-weight: 600; cursor: pointer; white-space: nowrap;">
                    Subscribe →
                </button>
            </form>
            
            <p style="font-size: 0.9rem; opacity: 0.8; margin-top: 1rem;">Join 5,000+ travelers getting our weekly newsletter</p>
        </div>
    </section>
</main>

<style>
.post-card:hover {
    transform: translateY(-8px);
}

.post-card:hover img {
    transform: scale(1.05);
}

.category-card:hover {
    background: white !important;
    border-color: #2dd4bf !important;
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.featured-post {
    transition: transform 0.3s ease;
}

.featured-post:hover {
    transform: translateY(-5px);
}

.blog-pagination .page-numbers {
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

.blog-pagination .page-numbers:hover,
.blog-pagination .page-numbers.current {
    background: #2dd4bf;
    color: white;
    border-color: #2dd4bf;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .featured-post > div {
        grid-template-columns: 1fr !important;
    }
    
    .featured-content {
        padding: 2rem !important;
    }
    
    .posts-grid {
        grid-template-columns: 1fr !important;
    }
    
    .newsletter-form {
        flex-direction: column !important;
    }
    
    .categories-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}
</style>

<?php get_footer(); ?>