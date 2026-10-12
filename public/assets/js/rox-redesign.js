(() => {
    const verification = document.getElementById('roxel-turnstile');
    if (verification) {
        document.addEventListener('DOMContentLoaded', () => {
            if (!window.turnstile) return;
            let widgetId;
            let widgetSize;
            const renderVerification = () => {
                const size = verification.clientWidth >= 300 ? 'normal' : 'compact';
                if (widgetId !== undefined && widgetSize === size) return;
                if (widgetId !== undefined) window.turnstile.remove(widgetId);
                widgetSize = size;
                widgetId = window.turnstile.render(verification, {
                    sitekey: verification.dataset.sitekey,
                    action: verification.dataset.action,
                    language: verification.dataset.language,
                    theme: verification.dataset.theme,
                    size,
                    appearance: 'interaction-only',
                });
            };
            renderVerification();
            new ResizeObserver(renderVerification).observe(verification);
        });
    }

    const mobileArtwork = window.matchMedia('(max-width: 560px)');
    const responsivePlaceholders = [...document.querySelectorAll('[data-mobile-placeholder]')].map((field) => ({
        field,
        original: field instanceof HTMLSelectElement ? field.options[0].textContent : field.getAttribute('placeholder'),
    }));
    const syncMobilePlaceholders = () => {
        responsivePlaceholders.forEach(({ field, original }) => {
            const value = mobileArtwork.matches ? field.dataset.mobilePlaceholder : original;
            if (field instanceof HTMLSelectElement) field.options[0].textContent = value;
            else field.setAttribute('placeholder', value);
        });
    };
    syncMobilePlaceholders();
    mobileArtwork.addEventListener('change', syncMobilePlaceholders);

    const spotlightVideo = document.querySelector('.collection-video video');
    const spotlightPlay = document.querySelector('.collection-video__play');
    if (spotlightVideo && spotlightPlay) {
        const originalPoster = spotlightVideo.poster;
        let spotlightStarted = false;
        const syncPoster = () => {
            spotlightVideo.poster = mobileArtwork.matches ? spotlightVideo.dataset.mobilePoster : originalPoster;
        };
        syncPoster();
        mobileArtwork.addEventListener('change', syncPoster);
        const updatePlayButton = () => {
            spotlightVideo.controls = !mobileArtwork.matches || spotlightStarted;
            spotlightPlay.hidden = mobileArtwork.matches
                ? spotlightStarted
                : !spotlightVideo.paused && !spotlightVideo.ended;
            spotlightVideo.closest('.collection-video').classList.toggle('is-playing', !spotlightVideo.paused);
        };
        const playSpotlight = () => {
            spotlightVideo.focus({ preventScroll: true });
            spotlightVideo.play().catch(updatePlayButton);
        };
        spotlightPlay.addEventListener('click', playSpotlight);
        document.querySelector('.collection-video__caption')?.addEventListener('click', playSpotlight);
        ['play', 'pause', 'ended', 'error'].forEach((event) => {
            spotlightVideo.addEventListener(event, () => {
                if (event === 'play') spotlightStarted = true;
                updatePlayButton();
            });
        });
        mobileArtwork.addEventListener('change', updatePlayButton);
        updatePlayButton();
    }

    const header = document.getElementById('site-header');
    const toggle = document.getElementById('menu-toggle');
    const close = document.getElementById('menu-close');
    const menu = document.getElementById('mobile-menu');
    const backdrop = document.getElementById('menu-backdrop');
    const pageRegions = [header, document.getElementById('main-content'), document.querySelector('.site-footer')];
    let menuReturnFocus = null;

    const setMenu = (open) => {
        if (!menu || !toggle) return;
        if (open) menuReturnFocus = document.activeElement;
        document.body.classList.toggle('menu-open', open);
        if (open) header?.classList.remove('is-hidden');
        menu.classList.toggle('is-open', open);
        menu.setAttribute('aria-hidden', String(!open));
        menu.inert = !open;
        pageRegions.forEach((region) => { if (region) region.inert = open; });
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Close navigation' : 'Open navigation');

        if (open) {
            window.requestAnimationFrame(() => close?.focus());
        } else if (menuReturnFocus instanceof HTMLElement) {
            menuReturnFocus.focus();
        }
    };

    toggle?.addEventListener('click', () => setMenu(!menu.classList.contains('is-open')));
    close?.addEventListener('click', () => setMenu(false));
    backdrop?.addEventListener('click', () => setMenu(false));
    menu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setMenu(false)));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && menu?.classList.contains('is-open')) {
            setMenu(false);
            return;
        }

        if (event.key === 'Tab' && menu?.classList.contains('is-open')) {
            const focusable = [...menu.querySelectorAll('button:not([disabled]), a[href], [tabindex]:not([tabindex="-1"])')]
                .filter((element) => !element.hasAttribute('inert') && element.getClientRects().length);
            if (!focusable.length) return;
            const first = focusable[0];
            const last = focusable[focusable.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    });

    const scrollHeader = window.matchMedia('(max-width: 560px) and (min-height: 421px), (min-width: 1101px) and (min-height: 421px)');
    const desktopScrollHeader = window.matchMedia('(min-width: 1101px) and (min-height: 421px)');
    let lastHeaderScroll = Math.max(0, window.scrollY);
    let headerScrollDistance = 0;
    let headerScrollDirection = 0;
    let headerFramePending = false;

    const updateHeader = () => {
        if (!header) return;
        const maxScroll = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
        const scrollPosition = Math.min(maxScroll, Math.max(0, window.scrollY));
        header.classList.toggle('is-scrolled', scrollPosition > 24);
        const keyboardFocus = header.contains(document.activeElement)
            && document.activeElement.matches(':focus-visible');
        if (!scrollHeader.matches || scrollPosition <= (desktopScrollHeader.matches ? 0 : 86)
            || document.body.classList.contains('menu-open') || keyboardFocus) {
            header.classList.remove('is-hidden');
            headerScrollDistance = 0;
            headerScrollDirection = 0;
        } else {
            const difference = scrollPosition - lastHeaderScroll;
            const direction = Math.sign(difference);
            if (direction && direction !== headerScrollDirection) headerScrollDistance = 0;
            if (direction) headerScrollDirection = direction;
            headerScrollDistance += Math.abs(difference);
            // Desktop hides on the first downward movement, including slow scrolling.
            // Keep the existing mobile threshold and accumulate upward movement to avoid flicker.
            if (desktopScrollHeader.matches && direction > 0) {
                header.classList.add('is-hidden');
                headerScrollDistance = 0;
            } else if (headerScrollDistance >= 24) {
                header.classList.toggle('is-hidden', direction > 0 && scrollPosition > 120);
                headerScrollDistance = 0;
            }
        }
        lastHeaderScroll = scrollPosition;
    };
    const scheduleHeaderUpdate = () => {
        if (headerFramePending) return;
        headerFramePending = true;
        window.requestAnimationFrame(() => {
            headerFramePending = false;
            updateHeader();
        });
    };
    updateHeader();
    window.addEventListener('scroll', scheduleHeaderUpdate, { passive: true });
    scrollHeader.addEventListener('change', updateHeader);
    desktopScrollHeader.addEventListener('change', updateHeader);
    header?.addEventListener('focusin', () => header.classList.remove('is-hidden'));


    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -30px 0px' });

    document.querySelectorAll('[data-reveal]').forEach((el) => observer.observe(el));

    document.querySelectorAll('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const id = link.getAttribute('href');
            if (!id || id === '#') return;
            const target = document.querySelector(id);
            if (!target) return;
            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    const galleryDataNode = document.getElementById('collection-gallery-data');
    const lightbox = document.getElementById('collection-lightbox');

    if (galleryDataNode && lightbox) {
        const galleries = JSON.parse(galleryDataNode.textContent || '{}');
        const image = document.getElementById('collection-lightbox-image');
        const projectLabel = document.getElementById('collection-lightbox-project');
        const typeLabel = document.getElementById('collection-lightbox-type');
        const counter = document.getElementById('collection-lightbox-counter');
        const caption = document.getElementById('collection-lightbox-caption');
        const progress = document.getElementById('collection-lightbox-progress');
        const dialog = lightbox.querySelector('.collection-lightbox__dialog');
        const designPanel = document.getElementById('collection-lightbox-designs');
        const roomSelect = document.getElementById('collection-lightbox-room');
        const designOptions = document.getElementById('collection-lightbox-design-options');
        let activeGallery = null;
        let activeIndex = 0;
        let activeDesign = null;
        let imageTimer = null;
        let lastFocus = null;
        let touchStartX = 0;

        const renderProgress = () => {
            if (!progress || !activeGallery) return;
            progress.innerHTML = activeGallery.images
                .map((_, index) => `<span class="${index === activeIndex ? 'is-active' : ''}"></span>`)
                .join('');
        };

        const renderImage = () => {
            if (!activeGallery || !image) return;
            const item = activeGallery.images[activeIndex];
            const designs = item.designs || [];
            const design = designs.find((option) => option.label === activeDesign)
                || designs.find((option) => option.src === item.src) || designs[0];
            activeDesign = design?.label || null;
            const source = design?.src || item.src;
            const description = `${item.type}${design ? ` — ${design.label}` : ''}`;
            if (designPanel && roomSelect && designOptions) {
                designPanel.hidden = !designs.length;
                roomSelect.value = String(activeIndex);
                const restoreDesignFocus = designOptions.contains(document.activeElement);
                designOptions.replaceChildren(...designs.map((option) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.textContent = option.label;
                    button.dataset.design = option.label;
                    button.setAttribute('aria-pressed', String(option.label === activeDesign));
                    return button;
                }));
                if (restoreDesignFocus) {
                    designOptions.querySelector('[aria-pressed="true"]')?.focus();
                }
            }
            window.clearTimeout(imageTimer);
            image.style.opacity = '0';

            imageTimer = window.setTimeout(() => {
                image.src = source;
                image.alt = `${activeGallery.title} — ${description}`;
                image.style.opacity = '1';
            }, 120);

            if (projectLabel) projectLabel.textContent = activeGallery.title;
            if (typeLabel) typeLabel.textContent = description;
            if (counter) counter.textContent = `${activeIndex + 1} / ${activeGallery.images.length}`;
            if (caption) caption.textContent = `${activeGallery.title} — ${description}`;
            renderProgress();

            [-1, 1].forEach((offset) => {
                const adjacent = activeGallery.images[(activeIndex + offset + activeGallery.images.length) % activeGallery.images.length];
                const preload = new Image();
                preload.src = adjacent.src;
            });
        };

        const moveGallery = (direction) => {
            if (!activeGallery) return;
            activeIndex = (activeIndex + direction + activeGallery.images.length) % activeGallery.images.length;
            renderImage();
        };

        const openGallery = (key) => {
            if (!galleries[key]) return;
            activeGallery = galleries[key];
            activeIndex = 0;
            activeDesign = null;
            roomSelect?.replaceChildren(...activeGallery.images.map((item, index) => {
                const option = document.createElement('option');
                option.value = String(index);
                option.textContent = item.type;
                return option;
            }));
            lastFocus = document.activeElement;
            lightbox.hidden = false;
            document.body.classList.add('collection-lightbox-open');
            renderImage();
            lightbox.querySelector('.collection-lightbox__close')?.focus();
        };

        const closeGallery = () => {
            if (lightbox.hidden) return;
            lightbox.hidden = true;
            document.body.classList.remove('collection-lightbox-open');
            window.clearTimeout(imageTimer);
            if (image) image.src = '';
            activeGallery = null;
            lastFocus?.focus?.();
        };

        roomSelect?.addEventListener('change', () => {
            activeIndex = Number(roomSelect.value);
            renderImage();
        });
        designOptions?.addEventListener('click', (event) => {
            const button = event.target.closest('button[data-design]');
            if (!button) return;
            activeDesign = button.dataset.design;
            renderImage();
        });

        document.querySelectorAll('.project-card[data-gallery]').forEach((card) => {
            const key = card.dataset.gallery;
            const trigger = card.querySelector('.project-card__gallery-trigger');
            const heart = card.querySelector('.project-card__heart');

            trigger?.addEventListener('click', () => openGallery(key));
            card.querySelector('.project-card__body')?.addEventListener('click', () => openGallery(key));

            heart?.addEventListener('click', (event) => {
                event.stopPropagation();
                const saved = heart.getAttribute('aria-pressed') !== 'true';
                heart.setAttribute('aria-pressed', String(saved));
                heart.textContent = saved ? '♥' : '♡';
            });
        });

        lightbox.querySelectorAll('[data-lightbox-close]').forEach((button) => button.addEventListener('click', closeGallery));
        lightbox.querySelector('[data-lightbox-prev]')?.addEventListener('click', () => moveGallery(-1));
        lightbox.querySelector('[data-lightbox-next]')?.addEventListener('click', () => moveGallery(1));

        document.addEventListener('keydown', (event) => {
            if (lightbox.hidden) return;
            if (event.key === 'Escape') closeGallery();
            if (!(event.target instanceof HTMLSelectElement)) {
                if (event.key === 'ArrowLeft') moveGallery(-1);
                if (event.key === 'ArrowRight') moveGallery(1);
            }

            if (event.key === 'Tab' && dialog) {
                const focusable = [...dialog.querySelectorAll('button:not([disabled]), select, [href], [tabindex]:not([tabindex="-1"])')]
                    .filter((element) => element.getClientRects().length);
                if (!focusable.length) return;
                const first = focusable[0];
                const last = focusable[focusable.length - 1];
                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }
        });

        lightbox.addEventListener('touchstart', (event) => {
            touchStartX = event.changedTouches[0]?.screenX || 0;
        }, { passive: true });
        lightbox.addEventListener('touchend', (event) => {
            const distance = (event.changedTouches[0]?.screenX || 0) - touchStartX;
            if (Math.abs(distance) > 55) moveGallery(distance > 0 ? -1 : 1);
        }, { passive: true });
    }
})();
