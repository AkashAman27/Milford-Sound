<?php
/**
 * Milford Sound Theme Functions
 */

// Theme setup
function milford_sound_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'milford-sound'),
        'footer' => __('Footer Menu', 'milford-sound'),
    ));
}
add_action('after_setup_theme', 'milford_sound_setup');

// Enqueue styles and scripts
function milford_sound_scripts() {
    wp_enqueue_style('milford-sound-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Add smooth scrolling for anchor links
    wp_enqueue_script('milford-sound-smooth-scroll', get_template_directory_uri() . '/js/smooth-scroll.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'milford_sound_scripts');

// Customize excerpt length
function milford_sound_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'milford_sound_excerpt_length');

// Custom excerpt more text
function milford_sound_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'milford_sound_excerpt_more');

// Register widget areas
function milford_sound_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'milford-sound'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'milford-sound'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'milford_sound_widgets_init');

// Custom post types for tours
function milford_sound_custom_post_types() {
    // Tours post type
    register_post_type('tours', array(
        'labels' => array(
            'name' => 'Tours',
            'singular_name' => 'Tour',
            'add_new' => 'Add New Tour',
            'add_new_item' => 'Add New Tour',
            'edit_item' => 'Edit Tour',
            'new_item' => 'New Tour',
            'view_item' => 'View Tour',
            'search_items' => 'Search Tours',
            'not_found' => 'No tours found',
            'not_found_in_trash' => 'No tours found in Trash'
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'tours'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon' => 'dashicons-location-alt',
        'show_in_rest' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 20,
        'description' => 'Manage tour offerings with detailed information, pricing, and booking details'
    ));
    
    // Guides post type
    register_post_type('guides', array(
        'labels' => array(
            'name' => 'Travel Guides',
            'singular_name' => 'Travel Guide',
            'add_new' => 'Add New Guide',
            'add_new_item' => 'Add New Travel Guide',
            'edit_item' => 'Edit Travel Guide',
            'new_item' => 'New Travel Guide',
            'view_item' => 'View Travel Guide',
            'search_items' => 'Search Travel Guides',
            'not_found' => 'No guides found',
            'not_found_in_trash' => 'No guides found in Trash'
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'guides'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'author'),
        'menu_icon' => 'dashicons-book-alt',
        'show_in_rest' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 21,
        'description' => 'Comprehensive travel guides with tips, checklists, and detailed information'
    ));

    // Categories post type (Tour Categories like Headout)
    register_post_type('categories', array(
        'labels' => array(
            'name' => 'Tour Categories',
            'singular_name' => 'Tour Category',
            'add_new' => 'Add New Category',
            'add_new_item' => 'Add New Tour Category',
            'edit_item' => 'Edit Tour Category',
            'new_item' => 'New Tour Category',
            'view_item' => 'View Tour Category',
            'search_items' => 'Search Tour Categories',
            'not_found' => 'No categories found',
            'not_found_in_trash' => 'No categories found in Trash'
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'tour-categories'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
        'menu_icon' => 'dashicons-category',
        'show_in_rest' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_position' => 22,
        'description' => 'Tour category pages similar to Headout with filtering, featured tours, and booking options'
    ));

    // Tour Categories taxonomy
    register_taxonomy('tour_category', 'tours', array(
        'labels' => array(
            'name' => 'Tour Categories',
            'singular_name' => 'Tour Category',
            'search_items' => 'Search Categories',
            'all_items' => 'All Categories',
            'parent_item' => 'Parent Category',
            'parent_item_colon' => 'Parent Category:',
            'edit_item' => 'Edit Category',
            'update_item' => 'Update Category',
            'add_new_item' => 'Add New Category',
            'new_item_name' => 'New Category Name',
            'menu_name' => 'Categories'
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'tour-category'),
        'show_in_rest' => true
    ));

    // Tour Tags taxonomy
    register_taxonomy('tour_tags', 'tours', array(
        'labels' => array(
            'name' => 'Tour Tags',
            'singular_name' => 'Tour Tag',
            'search_items' => 'Search Tags',
            'popular_items' => 'Popular Tags',
            'all_items' => 'All Tags',
            'edit_item' => 'Edit Tag',
            'update_item' => 'Update Tag',
            'add_new_item' => 'Add New Tag',
            'new_item_name' => 'New Tag Name',
            'menu_name' => 'Tags'
        ),
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'tour-tag'),
        'show_in_rest' => true
    ));

    // Guide Categories taxonomy
    register_taxonomy('guide_category', 'guides', array(
        'labels' => array(
            'name' => 'Guide Categories',
            'singular_name' => 'Guide Category',
            'search_items' => 'Search Categories',
            'all_items' => 'All Categories',
            'parent_item' => 'Parent Category',
            'parent_item_colon' => 'Parent Category:',
            'edit_item' => 'Edit Category',
            'update_item' => 'Update Category',
            'add_new_item' => 'Add New Category',
            'new_item_name' => 'New Category Name',
            'menu_name' => 'Categories'
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'guide-category'),
        'show_in_rest' => true
    ));
}
add_action('init', 'milford_sound_custom_post_types');

// Flush rewrite rules after registering custom post types
function milford_sound_flush_rewrites() {
    if (get_option('milford_sound_flush_rewrites_flag') !== 'done') {
        flush_rewrite_rules();
        update_option('milford_sound_flush_rewrites_flag', 'done');
    }
}
add_action('init', 'milford_sound_flush_rewrites', 20);

// Force sync new ACF field groups
function milford_sound_sync_blog_fields() {
    if (get_option('milford_sound_blog_fields_synced_v3') !== 'done' && function_exists('acf_import_field_group')) {
        $json_file = get_template_directory() . '/acf-json/group_blog_page_fields.json';
        if (file_exists($json_file)) {
            $json_data = file_get_contents($json_file);
            $field_group = json_decode($json_data, true);
            if ($field_group && isset($field_group['key'])) {
                acf_import_field_group($field_group);
                update_option('milford_sound_blog_fields_synced_v3', 'done');
                
                // Force refresh ACF cache
                if (function_exists('acf_get_field_groups')) {
                    wp_cache_delete('acf_get_field_groups', 'acf');
                }
            }
        }
    }
}
add_action('acf/init', 'milford_sound_sync_blog_fields');

// Add default tour and guide categories
function milford_sound_add_default_taxonomies() {
    // Default tour categories
    $tour_categories = array(
        'Cruises' => 'Scenic boat cruises and yacht tours',
        'Adventure' => 'Thrilling outdoor activities and extreme sports',
        'Helicopter Tours' => 'Aerial tours and helicopter experiences',
        'Kayaking' => 'Paddling adventures and water sports',
        'Walking Tours' => 'Guided walks and hiking experiences',
        'Photography Tours' => 'Specialized tours for photographers',
        'Wildlife Tours' => 'Tours focused on local flora and fauna',
        'Cultural Tours' => 'Māori culture and heritage experiences'
    );
    
    foreach ($tour_categories as $name => $description) {
        if (!term_exists($name, 'tour_category')) {
            wp_insert_term($name, 'tour_category', array('description' => $description));
        }
    }

    // Default guide categories
    $guide_categories = array(
        'Planning' => 'Trip planning and preparation guides',
        'Accommodation' => 'Where to stay and lodging options',
        'Transportation' => 'Getting around and travel options',
        'Activities' => 'Things to do and attractions',
        'Photography' => 'Photography tips and best spots',
        'Weather & Seasons' => 'Weather information and seasonal guides',
        'Budget Travel' => 'Budget tips and money-saving advice',
        'Family Travel' => 'Family-friendly guides and tips'
    );
    
    foreach ($guide_categories as $name => $description) {
        if (!term_exists($name, 'guide_category')) {
            wp_insert_term($name, 'guide_category', array('description' => $description));
        }
    }

    // Default tour tags
    $tour_tags = array('Scenic', 'Adventure', 'Family Friendly', 'Small Group', 'Half Day', 'Full Day', 'All Weather', 'Photography', 'Wildlife', 'Cultural');
    
    foreach ($tour_tags as $tag) {
        if (!term_exists($tag, 'tour_tags')) {
            wp_insert_term($tag, 'tour_tags');
        }
    }
}
add_action('after_setup_theme', 'milford_sound_add_default_taxonomies');

// Add custom fields for tours
function milford_sound_tour_meta_boxes() {
    add_meta_box(
        'tour-details',
        'Tour Details',
        'milford_sound_tour_details_callback',
        'tours'
    );
}
add_action('add_meta_boxes', 'milford_sound_tour_meta_boxes');

function milford_sound_tour_details_callback($post) {
    wp_nonce_field('milford_sound_save_tour_details', 'milford_sound_tour_details_nonce');
    
    $price = get_post_meta($post->ID, '_tour_price', true);
    $duration = get_post_meta($post->ID, '_tour_duration', true);
    $group_size = get_post_meta($post->ID, '_tour_group_size', true);
    $difficulty = get_post_meta($post->ID, '_tour_difficulty', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="tour_price">Price</label></th>';
    echo '<td><input type="text" id="tour_price" name="tour_price" value="' . esc_attr($price) . '" /></td></tr>';
    echo '<tr><th><label for="tour_duration">Duration</label></th>';
    echo '<td><input type="text" id="tour_duration" name="tour_duration" value="' . esc_attr($duration) . '" /></td></tr>';
    echo '<tr><th><label for="tour_group_size">Group Size</label></th>';
    echo '<td><input type="text" id="tour_group_size" name="tour_group_size" value="' . esc_attr($group_size) . '" /></td></tr>';
    echo '<tr><th><label for="tour_difficulty">Difficulty</label></th>';
    echo '<td><select id="tour_difficulty" name="tour_difficulty">';
    echo '<option value="easy"' . selected($difficulty, 'easy', false) . '>Easy</option>';
    echo '<option value="moderate"' . selected($difficulty, 'moderate', false) . '>Moderate</option>';
    echo '<option value="challenging"' . selected($difficulty, 'challenging', false) . '>Challenging</option>';
    echo '</select></td></tr>';
    echo '</table>';
}

function milford_sound_save_tour_details($post_id) {
    if (!isset($_POST['milford_sound_tour_details_nonce']) || 
        !wp_verify_nonce($_POST['milford_sound_tour_details_nonce'], 'milford_sound_save_tour_details')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['tour_price'])) {
        update_post_meta($post_id, '_tour_price', sanitize_text_field($_POST['tour_price']));
    }
    
    if (isset($_POST['tour_duration'])) {
        update_post_meta($post_id, '_tour_duration', sanitize_text_field($_POST['tour_duration']));
    }
    
    if (isset($_POST['tour_group_size'])) {
        update_post_meta($post_id, '_tour_group_size', sanitize_text_field($_POST['tour_group_size']));
    }
    
    if (isset($_POST['tour_difficulty'])) {
        update_post_meta($post_id, '_tour_difficulty', sanitize_text_field($_POST['tour_difficulty']));
    }
}
add_action('save_post', 'milford_sound_save_tour_details');

// Customizer options
function milford_sound_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'milford-sound'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('hero_title', array(
        'default' => 'Experience the Eighth Wonder of the World',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'milford-sound'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_description', array(
        'default' => 'Discover Milford Sound\'s breathtaking fjords, cascading waterfalls, and pristine wilderness.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('hero_description', array(
        'label' => __('Hero Description', 'milford-sound'),
        'section' => 'hero_section',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'milford_sound_customize_register');

// Helper function to get tour details
function get_tour_details($post_id) {
    return array(
        'price' => get_post_meta($post_id, '_tour_price', true),
        'duration' => get_post_meta($post_id, '_tour_duration', true),
        'group_size' => get_post_meta($post_id, '_tour_group_size', true),
        'difficulty' => get_post_meta($post_id, '_tour_difficulty', true),
    );
}

// Add body classes for styling
function milford_sound_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    
    if (is_post_type_archive('tours')) {
        $classes[] = 'tours-archive';
    }
    
    if (is_home() || is_category() || is_tag() || is_single()) {
        $classes[] = 'blog-page';
    }
    
    return $classes;
}
add_filter('body_class', 'milford_sound_body_classes');

// Reading time function for blog posts
function reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed
    return $reading_time;
}

// Custom excerpt length for blog posts
function milford_sound_blog_excerpt_length($length) {
    if (is_home() || is_category() || is_tag()) {
        return 25;
    }
    return $length;
}
add_filter('excerpt_length', 'milford_sound_blog_excerpt_length');

// Add featured image support for all post types
add_theme_support('post-thumbnails', array('post', 'tours', 'guides'));

// Set custom image sizes for blog
function milford_sound_image_sizes() {
    add_image_size('blog-featured', 800, 400, true);
    add_image_size('blog-thumbnail', 350, 200, true);
}
add_action('after_setup_theme', 'milford_sound_image_sizes');

// Auto-create blog page if it doesn't exist and ensure template is set
function milford_sound_create_blog_page() {
    $blog_page = get_page_by_path('blog');
    
    if (null == $blog_page) {
        $blog_page_data = array(
            'post_title'    => 'Blog',
            'post_content'  => 'This is the blog page where all our latest posts are displayed.',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => 'blog',
            'page_template' => 'page-blog.php'
        );
        $blog_page_id = wp_insert_post($blog_page_data);
        
        // Ensure template is set
        if ($blog_page_id) {
            update_post_meta($blog_page_id, '_wp_page_template', 'page-blog.php');
        }
    } else {
        // Ensure existing blog page has the correct template
        $current_template = get_post_meta($blog_page->ID, '_wp_page_template', true);
        if ($current_template !== 'page-blog.php') {
            update_post_meta($blog_page->ID, '_wp_page_template', 'page-blog.php');
        }
    }
}
add_action('after_setup_theme', 'milford_sound_create_blog_page');

// Ensure front page displays correctly
function milford_sound_setup_front_page() {
    // Set up front page to display the static homepage
    if (get_option('show_on_front') !== 'page') {
        update_option('show_on_front', 'page');
    }
}
add_action('after_setup_theme', 'milford_sound_setup_front_page');

// Enqueue additional scripts for blog functionality
function milford_sound_blog_scripts() {
    if (is_page_template('page-blog.php') || is_home()) {
        wp_enqueue_script('milford-sound-blog', get_template_directory_uri() . '/js/blog.js', array('jquery'), '1.0.0', true);
        wp_localize_script('milford-sound-blog', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}
add_action('wp_enqueue_scripts', 'milford_sound_blog_scripts');

// Add custom categories for better organization
function milford_sound_add_default_categories() {
    $categories = array(
        'Travel Tips' => 'Essential advice for visiting Milford Sound',
        'Photography' => 'Tips and showcases for capturing the perfect shot',
        'Wildlife' => 'Information about local flora and fauna',
        'Weather Updates' => 'Current conditions and seasonal information',
        'Tour Reviews' => 'Guest experiences and recommendations',
        'Local Culture' => 'Māori heritage and New Zealand culture',
        'Adventure Stories' => 'Personal accounts and exciting experiences'
    );
    
    foreach ($categories as $name => $description) {
        if (!term_exists($name, 'category')) {
            wp_insert_term($name, 'category', array('description' => $description));
        }
    }
}
add_action('after_setup_theme', 'milford_sound_add_default_categories');

// ACF Pro Support
function milford_sound_acf_settings() {
    // Enable ACF JSON save/load for field groups
    add_filter('acf/settings/save_json', function($path) {
        return get_stylesheet_directory() . '/acf-json';
    });
    
    add_filter('acf/settings/load_json', function($paths) {
        $paths[] = get_stylesheet_directory() . '/acf-json';
        return $paths;
    });
    
    // Hide field groups from admin since they're managed via JSON
    add_filter('acf/settings/show_admin', '__return_false');
}
add_action('acf/init', 'milford_sound_acf_settings');

// ACF Debug function
function milford_sound_acf_debug() {
    if (current_user_can('manage_options') && isset($_GET['acf_debug']) && !wp_doing_ajax()) {
        echo '<div style="background: #fff; border: 1px solid #ccc; padding: 20px; margin: 20px; position: fixed; top: 0; right: 0; z-index: 9999; max-width: 400px;">';
        echo '<h3>ACF Debug Info</h3>';
        echo '<p><strong>ACF Active:</strong> ' . (function_exists('get_field') ? 'Yes' : 'No') . '</p>';
        echo '<p><strong>ACF Pro:</strong> ' . (function_exists('acf_add_options_page') ? 'Yes' : 'No') . '</p>';
        
        if (function_exists('acf_get_field_groups')) {
            $field_groups = acf_get_field_groups();
            echo '<p><strong>Field Groups:</strong> ' . count($field_groups) . '</p>';
            foreach ($field_groups as $group) {
                echo '<p>- ' . $group['title'] . '</p>';
            }
        }
        echo '</div>';
    }
}
add_action('wp_footer', 'milford_sound_acf_debug');
add_action('admin_footer', 'milford_sound_acf_debug');

// Force ACF field group sync (run once)
function milford_sound_force_acf_sync() {
    if (current_user_can('manage_options') && isset($_GET['force_acf_sync']) && function_exists('acf_import_field_group') && !wp_doing_ajax()) {
        $acf_json_dir = get_stylesheet_directory() . '/acf-json/';
        if (is_dir($acf_json_dir)) {
            $files = glob($acf_json_dir . '*.json');
            $synced = 0;
            foreach ($files as $file) {
                $json = file_get_contents($file);
                $field_group = json_decode($json, true);
                if ($field_group && isset($field_group['key'])) {
                    acf_import_field_group($field_group);
                    $synced++;
                }
            }
            wp_safe_redirect(admin_url('edit.php?post_type=acf-field-group&synced=' . $synced));
            exit;
        }
    }
}
add_action('admin_init', 'milford_sound_force_acf_sync');

// Helper function to safely get array values
if (!function_exists('safe_get')) {
    function safe_get($array, $key, $default = '') {
        return (is_array($array) && isset($array[$key])) ? $array[$key] : $default;
    }
}

// Add admin notice for empty ACF fields
function milford_sound_acf_notice() {
    if (current_user_can('edit_posts')) {
        $screen = get_current_screen();
        if ($screen && in_array($screen->id, array('tours', 'guides', 'post'))) {
            echo '<div class="notice notice-info"><p><strong>Tip:</strong> Don\'t forget to fill in the ACF fields below to make your content look amazing on the frontend!</p></div>';
        }
    }
}
add_action('admin_notices', 'milford_sound_acf_notice');

// Quick ACF field check function
function milford_sound_check_acf_fields() {
    if (isset($_GET['check_acf']) && current_user_can('manage_options') && !wp_doing_ajax()) {
        $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : (isset($_GET['post']) ? intval($_GET['post']) : 0);
        
        if ($post_id && get_post_type($post_id) === 'tours') {
            echo '<div class="notice notice-success" style="padding: 15px; margin: 15px 0;">';
            echo '<h3>🔍 ACF Fields Check for Tour ID: ' . $post_id . '</h3>';
            
            // Check if ACF is active
            echo '<p><strong>ACF Pro Active:</strong> ' . (function_exists('get_field') ? '✅ Yes' : '❌ No') . '</p>';
            
            // Check field groups
            if (function_exists('acf_get_field_groups')) {
                $field_groups = acf_get_field_groups(array('post_id' => $post_id));
                echo '<p><strong>Field Groups for Tours:</strong> ' . count($field_groups) . '</p>';
                foreach ($field_groups as $group) {
                    echo '<p>📋 ' . $group['title'] . ' (Key: ' . $group['key'] . ')</p>';
                }
            }
            
            // Check specific fields
            $test_fields = array('tour_overview', 'tour_gallery', 'tour_highlights', 'tour_booking');
            foreach ($test_fields as $field) {
                $value = get_field($field, $post_id);
                $status = $value ? '✅ Has Data' : '⚠️ Empty';
                echo '<p><strong>' . $field . ':</strong> ' . $status . '</p>';
            }
            
            echo '<p><strong>Next Steps:</strong></p>';
            echo '<ul>';
            echo '<li>If fields show as empty, fill them in below and save the post</li>';
            echo '<li>If field groups are missing, go to Custom Fields → Field Groups and sync any available updates</li>';
            echo '<li>Test the frontend display by visiting the tour page after saving</li>';
            echo '</ul>';
            echo '</div>';
        }
    }
}
add_action('admin_init', 'milford_sound_check_acf_fields');

// Create ACF Options Page
function milford_sound_acf_options_pages() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'Theme Settings',
            'menu_title' => 'Theme Options',
            'menu_slug' => 'theme-options',
            'capability' => 'edit_theme_options',
            'icon_url' => 'dashicons-admin-customizer',
        ));
        
        acf_add_options_sub_page(array(
            'page_title' => 'Header Settings',
            'menu_title' => 'Header',
            'parent_slug' => 'theme-options',
        ));
        
        acf_add_options_sub_page(array(
            'page_title' => 'Footer Settings', 
            'menu_title' => 'Footer',
            'parent_slug' => 'theme-options',
        ));
    }
}
add_action('acf/init', 'milford_sound_acf_options_pages');

// Auto-create homepage with ACF template
function milford_sound_create_acf_homepage() {
    // Check if a homepage already exists
    $front_page_id = get_option('page_on_front');
    
    if (!$front_page_id) {
        // Create the homepage
        $homepage = array(
            'post_title' => 'Homepage',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'home',
            'page_template' => 'page-home.php'
        );
        
        $homepage_id = wp_insert_post($homepage);
        
        if ($homepage_id) {
            // Set as front page
            update_option('show_on_front', 'page');
            update_option('page_on_front', $homepage_id);
            
            // Add default ACF content
            if (function_exists('update_field')) {
                $default_content = array(
                    array(
                        'acf_fc_layout' => 'hero_section',
                        'badge_text' => 'UNESCO World Heritage Site',
                        'title' => "Experience the\nEighth Wonder\nof the World",
                        'highlight_word' => 'Eighth Wonder',
                        'description' => 'Discover Milford Sound\'s breathtaking fjords, cascading waterfalls, and pristine wilderness. Where towering peaks meet crystal-clear waters in New Zealand\'s most spectacular natural wonder.',
                        'buttons' => array(
                            array(
                                'text' => 'Book Your Adventure',
                                'icon' => '📅',
                                'link' => array(
                                    'url' => '#tours',
                                    'title' => 'Book Your Adventure',
                                    'target' => ''
                                ),
                                'style' => 'primary'
                            ),
                            array(
                                'text' => 'Watch Video Tour',
                                'icon' => '▶️',
                                'link' => array(
                                    'url' => '#video',
                                    'title' => 'Watch Video Tour',
                                    'target' => ''
                                ),
                                'style' => 'secondary'
                            )
                        )
                    ),
                    array(
                        'acf_fc_layout' => 'stats_section',
                        'title' => 'Today\'s Conditions',
                        'subtitle' => 'Perfect for cruising',
                        'weather_items' => array(
                            array('icon' => '🌡️', 'text' => '18°C'),
                            array('icon' => '💨', 'text' => 'Light winds'),
                            array('icon' => '🌊', 'text' => 'Calm seas')
                        ),
                        'statistics' => array(
                            array('number' => '1692m', 'label' => 'Mitre Peak Height'),
                            array('number' => '15km', 'label' => 'Fjord Length'),
                            array('number' => '161m', 'label' => 'Stirling Falls'),
                            array('number' => '5M+', 'label' => 'Annual Visitors')
                        )
                    ),
                    array(
                        'acf_fc_layout' => 'features_section',
                        'badge' => 'World Heritage Wonder',
                        'title' => 'Why Milford Sound is Unmissable',
                        'description' => 'Carved by glaciers over millions of years, Milford Sound offers an otherworldly experience where dramatic landscapes meet pristine wilderness in perfect harmony.',
                        'features' => array(
                            array(
                                'icon' => '🏔️',
                                'title' => 'Towering Peaks',
                                'description' => 'Marvel at Mitre Peak rising 1,692 meters straight from the water, creating one of the most photographed landscapes on Earth.'
                            ),
                            array(
                                'icon' => '🌊', 
                                'title' => 'Pristine Waters',
                                'description' => 'Cruise through mirror-like fjord waters that reflect towering cliffs, creating a sense of infinite depth and tranquility.'
                            ),
                            array(
                                'icon' => '💧',
                                'title' => 'Spectacular Falls',
                                'description' => 'Witness the thunderous Stirling Falls and Lady Bowen Falls cascading 161 meters into the fjord with incredible force.'
                            )
                        )
                    )
                );
                
                update_field('flexible_content', $default_content, $homepage_id);
            }
        }
    }
}
add_action('after_setup_theme', 'milford_sound_create_acf_homepage');

// Register ACF Blocks (if needed)
function milford_sound_register_acf_blocks() {
    if (function_exists('acf_register_block_type')) {
        // Tour Card Block
        acf_register_block_type(array(
            'name' => 'tour-card',
            'title' => 'Tour Card',
            'description' => 'A custom tour card block',
            'category' => 'milford-sound',
            'icon' => 'location-alt',
            'keywords' => array('tour', 'card', 'milford'),
            'supports' => array(
                'align' => false,
                'mode' => false,
                'jsx' => true
            )
        ));
    }
}
add_action('acf/init', 'milford_sound_register_acf_blocks');

// Add custom block category
function milford_sound_block_categories($categories) {
    return array_merge(
        array(
            array(
                'slug' => 'milford-sound',
                'title' => 'Milford Sound',
                'icon' => 'location-alt',
            ),
        ),
        $categories
    );
}
add_filter('block_categories_all', 'milford_sound_block_categories', 10, 2);
?>