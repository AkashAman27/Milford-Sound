<?php
/**
 * Fix Homepage ACF Field Conflicts
 * This will resync the ACF field groups with updated location rules
 * Access via: http://milford-sound.local/fix-homepage-fields.php
 */

// Load WordPress
require_once('wp-config.php');
require_once('wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    wp_die('Access denied. Admin permissions required.');
}

echo '<h2>🔧 Fixing Homepage ACF Field Conflicts</h2>';

if (!function_exists('acf_import_field_group')) {
    echo '<p style="color: red;">❌ ACF Pro is not active!</p>';
    exit;
}

// Force sync both field groups with updated location rules
$field_groups_to_sync = [
    'group_homepage_flexible' => 'Homepage Flexible Content',
    'group_blog_post_fields' => 'Blog Post Enhanced Fields'
];

$synced_count = 0;

foreach ($field_groups_to_sync as $group_key => $group_title) {
    $json_file = get_template_directory() . '/acf-json/' . $group_key . '.json';
    
    if (file_exists($json_file)) {
        $json_data = file_get_contents($json_file);
        $field_group = json_decode($json_data, true);
        
        if ($field_group && isset($field_group['key'])) {
            // Import/update the field group
            acf_import_field_group($field_group);
            echo '<p style="color: green;">✅ Synced: ' . $group_title . '</p>';
            $synced_count++;
        } else {
            echo '<p style="color: red;">❌ Invalid JSON for: ' . $group_title . '</p>';
        }
    } else {
        echo '<p style="color: red;">❌ File not found: ' . $json_file . '</p>';
    }
}

echo '<hr>';
echo '<h3>📋 Summary:</h3>';
echo '<p><strong>Total synced:</strong> ' . $synced_count . ' field groups</p>';

echo '<h3>🎯 What was fixed:</h3>';
echo '<ul>';
echo '<li><strong>Homepage Flexible Content:</strong> Set to highest priority (menu_order: -1)</li>';
echo '<li><strong>Blog Post Fields:</strong> Excluded from front page and set to lower priority (menu_order: 10)</li>';
echo '<li><strong>Location Rules:</strong> Updated to prevent conflicts</li>';
echo '</ul>';

echo '<h3>📝 Next Steps:</h3>';
echo '<ol>';
echo '<li>Refresh your <a href="/wp-admin/post.php?post=9&action=edit" target="_blank">homepage edit page</a></li>';
echo '<li>You should now see ONLY the "Page Content" ACF flexible content section</li>';
echo '<li>The blog post fields (Hero Background Image, CTA Title, etc.) should be gone</li>';
echo '<li>Click "Add Content Section" to add Hero Section, Stats Section, etc.</li>';
echo '</ol>';

echo '<div style="background: #e3f2fd; border: 1px solid #90caf9; color: #0d47a1; padding: 15px; margin: 20px 0; border-radius: 4px;">';
echo '<strong>🔍 If you still see blog post fields:</strong><br>';
echo '1. Clear any caching plugins<br>';
echo '2. Go to Custom Fields → Field Groups and manually sync any available updates<br>';
echo '3. Try editing the page in an incognito/private browser window';
echo '</div>';

// Clean up - delete this file for security
echo '<hr>';
echo '<p><em>This sync script will be automatically deleted for security.</em></p>';
unlink(__FILE__);
?>