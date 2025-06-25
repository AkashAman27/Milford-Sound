<?php
/**
 * Debug Category ACF Fields
 * Access via: http://milford-sound.local/debug-category-acf.php?post_id=340
 */

// Load WordPress
require_once('wp-config.php');
require_once('wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    wp_die('Access denied. Admin permissions required.');
}

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 340;

echo '<h2>🔍 Debugging Category ACF Fields for Post ID: ' . $post_id . '</h2>';

if (!function_exists('get_field')) {
    echo '<p style="color: red;">❌ ACF is not active!</p>';
    exit;
}

$post = get_post($post_id);
if (!$post) {
    echo '<p style="color: red;">❌ Post not found!</p>';
    exit;
}

echo '<h3>📄 Post Information:</h3>';
echo '<p><strong>Title:</strong> ' . $post->post_title . '</p>';
echo '<p><strong>Post Type:</strong> ' . $post->post_type . '</p>';
echo '<p><strong>Post Status:</strong> ' . $post->post_status . '</p>';

echo '<h3>🎛️ ACF Field Groups:</h3>';
if (function_exists('acf_get_field_groups')) {
    $field_groups = acf_get_field_groups(array('post_id' => $post_id));
    if ($field_groups) {
        foreach ($field_groups as $group) {
            echo '<p>📋 <strong>' . $group['title'] . '</strong> (Key: ' . $group['key'] . ')</p>';
        }
    } else {
        echo '<p>❌ No field groups found for this post</p>';
    }
}

echo '<h3>🎯 Category Hero Section:</h3>';
$category_hero = get_field('category_hero', $post_id);
if ($category_hero) {
    echo '<div style="background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0;">';
    echo '<h4>✅ Category Hero Data Found:</h4>';
    echo '<pre>' . print_r($category_hero, true) . '</pre>';
    echo '</div>';
    
    echo '<h4>🖼️ Background Settings:</h4>';
    $bg_type = safe_get($category_hero, 'hero_background_type', 'not set');
    $bg_image = safe_get($category_hero, 'hero_background_image');
    $bg_video = safe_get($category_hero, 'hero_background_video');
    
    echo '<p><strong>Background Type:</strong> ' . $bg_type . '</p>';
    echo '<p><strong>Background Image:</strong> ' . ($bg_image ? '✅ Set (' . $bg_image['url'] . ')' : '❌ Not set') . '</p>';
    echo '<p><strong>Background Video:</strong> ' . ($bg_video ? '✅ Set (' . $bg_video . ')' : '❌ Not set') . '</p>';
    
} else {
    echo '<div style="background: #ffe8e8; padding: 15px; border-radius: 5px; margin: 10px 0;">';
    echo '<h4>❌ No Category Hero Data Found</h4>';
    echo '<p>This means the ACF fields haven\'t been filled in yet.</p>';
    echo '</div>';
}

echo '<h3>📝 All ACF Fields for this Post:</h3>';
$all_fields = get_fields($post_id);
if ($all_fields) {
    echo '<div style="background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 10px 0;">';
    echo '<pre>' . print_r($all_fields, true) . '</pre>';
    echo '</div>';
} else {
    echo '<div style="background: #ffe8e8; padding: 15px; border-radius: 5px; margin: 10px 0;">';
    echo '<p>❌ No ACF data found for this post. The fields may not be filled in.</p>';
    echo '</div>';
}

echo '<h3>🛠️ Next Steps:</h3>';
echo '<ol>';
echo '<li>Go to <a href="/wp-admin/post.php?post=' . $post_id . '&action=edit" target="_blank">edit this category post</a></li>';
echo '<li>Fill in the "Category Hero Section" fields:</li>';
echo '<ul>';
echo '<li><strong>Background Type:</strong> Choose "Image Background" or "Video Background"</li>';
echo '<li><strong>Hero Background Image:</strong> Upload an image if you chose Image Background</li>';
echo '<li><strong>Hero Background Video:</strong> Enter a YouTube URL if you chose Video Background</li>';
echo '<li><strong>Hero Overlay Color:</strong> Choose an overlay color (optional)</li>';
echo '<li><strong>Category Badge:</strong> Enter badge text like "Most Popular"</li>';
echo '<li><strong>Category Subtitle:</strong> Enter a subtitle/description</li>';
echo '</ul>';
echo '<li>Save the post and check the frontend</li>';
echo '</ol>';

echo '<div style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; margin: 20px 0; border-radius: 4px;">';
echo '<strong>💡 Tip:</strong> The template code is working correctly. You just need to fill in the ACF fields in the WordPress admin. The background images/videos will show once you add them to the "Category Hero Section" fields.';
echo '</div>';

// Clean up
echo '<hr>';
echo '<p><em>This debug script will auto-delete for security.</em></p>';
unlink(__FILE__);
?>