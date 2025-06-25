/**
 * Blog Functionality
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Category filter functionality
    const categoryFilters = document.querySelectorAll('.category-filter');
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function(e) {
            // Remove active class from all filters
            categoryFilters.forEach(f => f.classList.remove('active'));
            // Add active class to clicked filter
            this.classList.add('active');
        });
    });

    // Search functionality
    const searchForm = document.querySelector('form[role="search"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="s"]');
            if (searchInput.value.trim() === '') {
                e.preventDefault();
                alert('Please enter a search term');
            }
        });
    }

    // Newsletter signup
    const newsletterForms = document.querySelectorAll('.newsletter-form');
    newsletterForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            if (email && isValidEmail(email)) {
                // Simulate newsletter signup
                alert('Thank you for subscribing! You\'ll receive our latest blog posts and travel tips.');
                this.querySelector('input[type="email"]').value = '';
            } else {
                alert('Please enter a valid email address');
            }
        });
    });

    // Infinite scroll for blog posts (optional enhancement)
    let loading = false;
    const loadMoreBtn = document.querySelector('.load-more-posts');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (loading) return;
            loading = true;
            
            this.textContent = 'Loading...';
            
            // Simulate loading more posts
            setTimeout(() => {
                this.textContent = 'Load More Posts';
                loading = false;
            }, 1000);
        });
    }

    // Add reading progress bar for single posts
    if (document.body.classList.contains('single-post')) {
        createReadingProgressBar();
    }

    // Social sharing functionality
    const shareButtons = document.querySelectorAll('.share-btn');
    shareButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const platform = this.dataset.platform;
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            
            let shareUrl = '';
            switch(platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
                case 'pinterest':
                    shareUrl = `https://pinterest.com/pin/create/button/?url=${url}&description=${title}`;
                    break;
            }
            
            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        });
    });

    // Image lazy loading for blog posts
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));

    // Comment form enhancement
    const commentForm = document.querySelector('#commentform');
    if (commentForm) {
        const commentFields = commentForm.querySelectorAll('input, textarea');
        commentFields.forEach(field => {
            field.addEventListener('focus', function() {
                this.style.borderColor = '#2dd4bf';
            });
            
            field.addEventListener('blur', function() {
                this.style.borderColor = '#e2e8f0';
            });
        });
    }

    // Auto-save draft functionality for comment form
    const commentTextarea = document.querySelector('#comment');
    if (commentTextarea) {
        let saveTimeout;
        commentTextarea.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                localStorage.setItem('blog_comment_draft', this.value);
            }, 1000);
        });

        // Restore draft on page load
        const savedDraft = localStorage.getItem('blog_comment_draft');
        if (savedDraft) {
            commentTextarea.value = savedDraft;
        }

        // Clear draft on successful submit
        commentForm.addEventListener('submit', function() {
            localStorage.removeItem('blog_comment_draft');
        });
    }
});

// Helper functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function createReadingProgressBar() {
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(90deg, #2dd4bf, #3b82f6);
        z-index: 9999;
        transition: width 0.3s ease;
    `;
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + '%';
    });
}

// Add smooth hover effects
function addHoverEffects() {
    const cards = document.querySelectorAll('.post-card, .category-card, .tour-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// Initialize hover effects after DOM is loaded
document.addEventListener('DOMContentLoaded', addHoverEffects);

// Add keyboard navigation for accessibility
document.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' || e.key === ' ') {
        if (e.target.classList.contains('category-filter')) {
            e.preventDefault();
            e.target.click();
        }
    }
});

// Print functionality for blog posts
function printPost() {
    window.print();
}

// Copy link functionality
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('Link copied to clipboard!');
    });
}