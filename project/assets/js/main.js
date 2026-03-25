document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Navbar Scroll Effect & Hero Text Parallax
    const navbar = document.getElementById('navbar');
    const heroText = document.getElementById('hero-text');

    window.addEventListener('scroll', () => {
        let scrollPosition = window.scrollY;
        
        // Parallax for text (if exists on page)
        if(heroText) {
            heroText.style.opacity = 1 - (scrollPosition / 600);
            heroText.style.transform = `translateY(${scrollPosition * 0.3}px)`;
        }

        // Navbar background change based on scroll
        if (scrollPosition > 50) {
            navbar.classList.add('bg-[#0a1128]', 'shadow-lg', 'py-4');
            navbar.classList.remove('py-6');
        } else {
            // Keep transparent only if it's the home page (which has an ID of hero-text)
            if(document.getElementById('hero-text')) {
                navbar.classList.remove('bg-[#0a1128]', 'shadow-lg', 'py-4');
                navbar.classList.add('py-6');
            }
        }
    });

    // 2. Intersection Observer for Smooth Scrolling Reveals
    const revealElements = document.querySelectorAll('.reveal');
    
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target); // Animate only once
            }
        });
    }, {
        root: null,
        threshold: 0.15, // Trigger when 15% is visible
        rootMargin: "0px 0px -50px 0px"
    });

    revealElements.forEach(el => {
        revealObserver.observe(el);
    });

    // 3. Mobile Menu Toggle Logic (Unified for all pages)
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    
    if (btn && menu) {
        const icon = btn.querySelector('svg');
        
        btn.addEventListener('click', () => {
            menu.classList.toggle('open');
            
            // Toggle between Hamburger and Close icon
            if(menu.classList.contains('open')) {
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>`;
            } else {
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>`;
            }
        });
    }
});