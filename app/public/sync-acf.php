<?php
/**
 * Temporary script to sync ACF field groups
 * Access via: http://milford-sound.local/sync-acf.php
 */

// Load WordPress
require_once('wp-config.php');
require_once('wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    wp_die('Access denied. Admin permissions required.');
}

echo '<h2>ACF Field Group Sync</h2>';

// Check if ACF is active
if (!function_exists('acf_import_field_group')) {
    echo '<p style="color: red;">ACF Pro is not active!</p>';
    exit;
}

// Import the updated field group
$json_file = get_template_directory() . '/acf-json/group_homepage_flexible.json';

if (file_exists($json_file)) {
    $json_data = file_get_contents($json_file);
    $field_group = json_decode($json_data, true);
    
    if ($field_group && isset($field_group['key'])) {
        // Import/update the field group
        acf_import_field_group($field_group);
        echo '<p style="color: green;">✅ Homepage Flexible Content field group has been synced successfully!</p>';
        echo '<p><strong>Next steps:</strong></p>';
        echo '<ol>';
        echo '<li>Go to your WordPress admin: <a href="/wp-admin/post.php?post=9&action=edit" target="_blank">Edit Homepage</a></li>';
        echo '<li>You should now see the "Page Content" ACF fields</li>';
        echo '<li>Click "Add Content Section" to add sections</li>';
        echo '<li>Save the page and check the frontend</li>';
        echo '</ol>';
        echo '<p><a href="/wp-admin/edit.php?post_type=acf-field-group">View Field Groups</a></p>';
    } else {
        echo '<p style="color: red;">❌ Invalid field group JSON data</p>';
    }
} else {
    echo '<p style="color: red;">❌ Field group JSON file not found: ' . $json_file . '</p>';
}

// Clean up - delete this file for security
echo '<hr>';
echo '<p><em>This sync script will be automatically deleted for security.</em></p>';
unlink(__FILE__);
?>