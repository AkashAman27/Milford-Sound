# Milford Sound Theme - Advanced Custom Fields Pro Integration

## 🎯 Overview

This theme has been enhanced with **Advanced Custom Fields Pro** integration, providing powerful flexible content management for creating dynamic, professional-grade pages with repeater fields, conditional logic, and modular content sections.

## 🏗️ Homepage Template Features

### **📋 Flexible Content Layouts**

The homepage uses ACF Pro's **Flexible Content** field with the following layout options:

#### 1. **Hero Section**
- **Badge Text**: Custom badge text (e.g., "UNESCO World Heritage Site")
- **Main Title**: Multi-line title with highlight word support
- **Highlighted Word**: Specific word/phrase to highlight in teal color
- **Description**: Hero description text
- **Buttons (Repeater)**: Multiple CTA buttons with:
  - Button text
  - Icon (emoji/symbol)
  - Link (ACF Link field)
  - Style (Primary/Secondary)
- **Background Options**:
  - Background image upload
  - Background video URL support
  - Gradient overlay

#### 2. **Statistics Section**
- **Section Title & Subtitle**: Customizable heading
- **Weather Items (Repeater)**: Live conditions display
  - Icon field
  - Text field
- **Statistics (Repeater)**: Key metrics with:
  - Number/value
  - Label/description
  - Optional icon

#### 3. **Features Section**
- **Badge Text**: Section identifier
- **Title & Description**: Section heading and content
- **Features (Repeater)**: Feature cards with:
  - Icon or uploaded image
  - Title and description
  - Custom icon background color
  - Image upload capability

#### 4. **Tours Section**
- **Badge & Title**: Section identification
- **Tours (Repeater)**: Dynamic tour cards with:
  - Tour badge with color coding
  - Tour image upload or fallback icon
  - Title, duration, and pricing
  - Description text
  - Tour details (sub-repeater):
    - Detail icons and text
  - Rating and review count
  - Book now link

#### 5. **Testimonials Section**
- **Section Title**: Customizable heading
- **Testimonials (Repeater)**: Customer reviews with:
  - Testimonial text
  - Customer name and location
  - Avatar image upload
  - Star rating (1-5)

#### 6. **Call to Action Section**
- **Badge Text**: Urgency indicator
- **Title & Description**: CTA messaging
- **Buttons (Repeater)**: Multiple action buttons
- **Features (Repeater)**: Trust indicators/benefits

## 🛠️ Setup Instructions

### **1. Install ACF Pro**
- Upload ACF Pro plugin to `/wp-content/plugins/`
- Activate the plugin in WordPress admin

### **2. Import Field Groups**
The theme automatically loads field groups from `/acf-json/` directory:
- `group_homepage_flexible.json` - Main homepage fields

### **3. Create Homepage**
1. Go to **Pages → Add New**
2. Title: "Homepage" 
3. **Page Template**: Select "Homepage Template"
4. **Publish** the page
5. Go to **Settings → Reading**
6. Set "Your homepage displays" to "A static page"
7. Choose your homepage

### **4. Add Content**
1. Edit your homepage
2. Use **Page Content → Add Content Section**
3. Choose from available layouts:
   - Hero Section
   - Statistics Section  
   - Features Section
   - Tours Section
   - Testimonials Section
   - Call to Action Section

## 📊 Field Structure Examples

### **Hero Section Example:**
```
Badge Text: "UNESCO World Heritage Site"
Title: "Experience the\nEighth Wonder\nof the World"
Highlighted Word: "Eighth Wonder"
Description: "Discover Milford Sound's breathtaking fjords..."

Buttons:
- Text: "Book Your Adventure"
  Icon: "📅"
  Link: "#tours"
  Style: "Primary"
```

### **Tours Section Example:**
```
Tours:
- Badge: "Most Popular"
  Badge Color: "Popular"
  Title: "Scenic Nature Cruise"
  Duration: "2 hours"
  Price: "From $89 per person"
  Description: "Experience Milford Sound's majesty..."
  Details:
    - Icon: "⏰" Text: "2 hours"
    - Icon: "👥" Text: "All ages"
  Rating: 4.8
  Reviews: 2341
```

## 🎨 Styling & Customization

### **Color Schemes:**
- **Primary**: `#2dd4bf` (Teal)
- **Secondary**: `#3b82f6` (Blue)
- **Accent**: `#1e40af` (Dark Blue)

### **Tour Badge Colors:**
- **Popular**: Green (`#22c55e`)
- **Premium**: Purple (`#8b5cf6`)
- **Adventure**: Orange (`#f59e0b`)
- **New**: Blue (`#3b82f6`)

### **Responsive Design:**
- Mobile-first approach
- Automatic grid adjustments
- Touch-friendly elements
- Optimized for all screen sizes

## 🚀 Advanced Features

### **ACF Options Pages:**
Access via **Theme Options** in WordPress admin:
- **Header Settings**: Logo, navigation, contact info
- **Footer Settings**: Footer content, social links, copyright

### **JSON Field Sync:**
- Field groups automatically save to `/acf-json/`
- Version control friendly
- Easy deployment across environments

### **Custom Blocks:**
- Tour Card block for Gutenberg
- Custom block category: "Milford Sound"
- Reusable components

### **Conditional Logic:**
- Fields show/hide based on selections
- Smart form interfaces
- Reduced complexity for content editors

## 📱 Content Management Tips

### **Best Practices:**
1. **Images**: Upload high-quality images (min 800px wide)
2. **Icons**: Use emoji or simple icon fonts
3. **Text**: Keep descriptions concise and engaging
4. **Links**: Use relative URLs for internal pages
5. **Mobile**: Preview on mobile devices regularly

### **Content Strategy:**
- **Hero**: Focus on primary value proposition
- **Stats**: Use real, compelling numbers
- **Features**: Highlight unique selling points
- **Tours**: Include social proof (ratings/reviews)
- **Testimonials**: Use authentic customer quotes
- **CTA**: Create urgency and clear action steps

## 🔧 Developer Notes

### **Template Hierarchy:**
- `page-home.php` - Homepage template
- `front-page.php` - Fallback homepage
- `page-blog.php` - Blog page template

### **ACF Functions Used:**
- `have_rows()` - Check for repeater/flexible content
- `the_row()` - Loop through repeater items
- `get_sub_field()` - Get field values within repeaters
- `get_row_layout()` - Check flexible content layout type

### **Hooks & Filters:**
- `acf/init` - Initialize ACF settings
- `acf/settings/save_json` - JSON save path
- `acf/settings/load_json` - JSON load path

## 🎯 Next Steps

1. **Content Creation**: Add your content using the flexible fields
2. **Image Upload**: Add high-quality images for tours and features  
3. **Customization**: Adjust colors and styling as needed
4. **Testing**: Test on various devices and browsers
5. **SEO**: Add meta descriptions and optimize content

---

**🏔️ Built for Milford Sound Tourism**
*Powered by Advanced Custom Fields Pro*