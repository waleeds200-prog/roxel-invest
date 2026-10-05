// ==========================================================================
// 1. الوظائف العامة والدوال المساعدة
// ==========================================================================
function switchBrandIdentity(newSrc, scaleHeight, xOffset) {
    const logoImg = document.getElementById('main-logo');
    if (logoImg) {
        logoImg.style.opacity = "0";
        setTimeout(() => {
            logoImg.src = newSrc;
            logoImg.style.transform = `scale(${scaleHeight}) translateX(${xOffset})`;
            logoImg.style.opacity = "1";
            console.log(`Switched to: ${newSrc} | Scale: ${scaleHeight} | X: ${xOffset}`);
        }, 300);
    }
}

// ==========================================================================
// 2. تشغيل كافة السكربتات بعد تحميل الصفحة (DOMContentLoaded واحد فقط)
// ==========================================================================
document.addEventListener('DOMContentLoaded', () => {

    // --- 1. GSAP ScrollTrigger Animations ---
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        gsap.to("#hero-text", {
            opacity: 0,
            y: -150,
            filter: "blur(10px)",
            ease: "none",
            scrollTrigger: {
                trigger: "header",
                start: "top top",
                end: "bottom 30%",
                scrub: true
            }
        });

        gsap.utils.toArray('.reveal').forEach((el) => {
            gsap.fromTo(el,
                { opacity: 0, filter: "blur(5px)", y: 30 },
                {
                    opacity: 1,
                    filter: "blur(0px)",
                    y: 0,
                    duration: 1,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: el,
                        start: "top 85%",
                    }
                }
            );
        });

        gsap.utils.toArray('.group img').forEach((img) => {
            gsap.to(img, {
                scale: 1.15,
                ease: "none",
                scrollTrigger: {
                    trigger: img.parentElement,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: 1.5
                }
            });
        });

        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            gsap.to(counter, {
                scrollTrigger: { trigger: counter, start: "top 90%" },
                innerText: target,
                duration: 2.5,
                snap: { innerText: 1 },
                ease: "power2.out"
            });
        });
    }

    // --- 2. Staggered Reveal ---
    const revealItems = document.querySelectorAll('.reveal-item');
    revealItems.forEach((item, index) => {
        setTimeout(() => {
            item.classList.add('active');
        }, 150 * index);
    });

    // --- 3. Parallax Image ---
    const parallaxImage = document.querySelector('.parallax-image');
    if (parallaxImage && window.innerWidth > 768) {
        window.addEventListener('scroll', () => {
            let scrollPosition = window.pageYOffset;
            if (scrollPosition < window.innerHeight) {
                parallaxImage.style.transform = `translateY(${scrollPosition * 0.3}px)`;
            }
        });
    }

    // --- 4. Hero Video Toggle ---
   // ==========================================
// كود التحكم بفيديو وصوت الهيرو (معزول تماماً لمنع تكرار التعريف)
// ==========================================
{
    const heroVideo = document.getElementById('hero-video');
    const heroToggle = document.getElementById('hero-video-toggle');
    const heroPlayToggle = document.getElementById('hero-play-toggle');

    if (heroVideo) {
        heroVideo.volume = 0.20;
        heroVideo.muted = true;
        heroVideo.play().catch(() => {});

        // زر كتم / تشغيل الصوت
        if (heroToggle) {
            heroToggle.addEventListener('click', () => {
                if (heroVideo.muted) {
                    heroVideo.muted = false;
                    heroVideo.volume = 0.20;
                    heroToggle.innerHTML = '<i class="fa-solid fa-volume-low text-roxel-gold"></i><span class="hidden md:inline">Audio On</span>';
                    heroToggle.setAttribute('aria-label', 'Mute audio');
                } else {
                    heroVideo.muted = true;
                    heroToggle.innerHTML = '<i class="fa-solid fa-volume-xmark text-roxel-gold"></i><span class="hidden md:inline">Audio Off</span>';
                    heroToggle.setAttribute('aria-label', 'Unmute audio');
                }
            });
        }

        // زر إيقاف / تشغيل الفيديو
        if (heroPlayToggle) {
            heroPlayToggle.addEventListener('click', () => {
                if (heroVideo.paused) {
                    heroVideo.play();
                    heroPlayToggle.innerHTML = '<i class="fa-solid fa-pause text-xs"></i>';
                    heroPlayToggle.setAttribute('aria-label', 'Pause video');
                } else {
                    heroVideo.pause();
                    heroPlayToggle.innerHTML = '<i class="fa-solid fa-play text-xs"></i>';
                    heroPlayToggle.setAttribute('aria-label', 'Play video');
                }
            });
        }
    }
}

    // --- 5. Mobile Menu ---
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const iconPath = document.getElementById('icon-path');
    const mobileLinks = document.querySelectorAll('.mobile-link');
    const closeBtn = document.getElementById('mobile-menu-close');

    if (btn && menu) {
        const closeMenu = () => {
            menu.classList.remove('translate-x-0');
            menu.classList.add('translate-x-full');
            if (iconPath) iconPath.setAttribute('d', 'M4 6h16M4 12h16m-7 6h7');
        };

        const openMenu = () => {
            menu.classList.remove('translate-x-full');
            menu.classList.add('translate-x-0');
            if (iconPath) iconPath.setAttribute('d', 'M6 18L18 6M6 6l12 12');
        };

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = menu.classList.contains('translate-x-0');
            isOpen ? closeMenu() : openMenu();
        });

        if (closeBtn) {
            closeBtn.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                closeMenu();
            };
        }

        mobileLinks.forEach(link => {
            link.onclick = closeMenu;
        });
    }

    // --- 6. Brand Switch ---
    document.querySelectorAll('.brand-switch-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            switchBrandIdentity(this.dataset.src, this.dataset.scale, this.dataset.x);
        });
    });

    // ==========================================================================
    // 7. Olea Mare التفاعلي (معزول في نطاق خاص لمنع أي تعارض)
    // ==========================================================================
    const oleaGalleryDataEl = document.getElementById('olea-room-style-data');
    if (oleaGalleryDataEl) {
        const explorer = document.getElementById('olea-design-explorer');
        if (explorer) {
            let oleaData = {};
            try {
                oleaData = JSON.parse(oleaGalleryDataEl.textContent);
            } catch (error) {
                console.error('Unable to parse Olea gallery data', error);
            }

            const stylesContainer = explorer.querySelector('#olea-styles-container');
            const mainImage = explorer.querySelector('#olea-main-image');
            const roomLabel = explorer.querySelector('#olea-room-label');
            const styleLabel = explorer.querySelector('#olea-style-label');
            const expandBtn = explorer.querySelector('#olea-expand-btn');
            const prevBtn = explorer.querySelector('#olea-prev-btn');
            const nextBtn = explorer.querySelector('#olea-next-btn');

            // عناصر وضع الشاشة الكاملة (Lightbox) - معرفة داخل هذا النطاق فقط
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxFooter = document.getElementById('lightbox-footer');
            const lightboxStylesContainer = document.getElementById('lightbox-styles-container');
            
            // تسميات الكمبيوتر العلوية
            const lightboxRoomLabel = document.getElementById('lightbox-room-label');
            const lightboxStyleLabel = document.getElementById('lightbox-style-label');
            
            // تسميات الموبايل المدمجة في الكبسولة السفلية
            const lightboxMobileRoomLabel = document.getElementById('lightbox-mobile-room-label');
            const lightboxMobileStyleLabel = document.getElementById('lightbox-mobile-style-label');
            
            const lightboxPrevBtn = document.getElementById('lightbox-prev');
            const lightboxNextBtn = document.getElementById('lightbox-next');

            let masterPlaylist = []; // قائمة التشغيل الكلية لكل الغرف والستايلات
            let currentIndex = 0;
            let isLightboxOpen = false;

            // --- أ. بناء القائمة الكلية لجميع الغرف والأنماط المتاحة فعلياً ---
            const buildMasterPlaylist = () => {
                const playlist = [];
                Object.keys(oleaData).forEach((roomKey) => {
                    const roomObj = oleaData[roomKey];
                    const stylesObj = roomObj?.styles || {};
                    Object.keys(stylesObj).forEach((styleKey) => {
                        const styleObj = stylesObj[styleKey];
                        if (styleObj && styleObj.gallery?.length > 0) {
                            styleObj.gallery.forEach((imgUrl) => {
                                playlist.push({
                                    src: imgUrl,
                                    roomKey: roomKey,
                                    styleKey: styleKey,
                                    roomLabel: roomObj.label || 'Room',
                                    styleLabel: styleObj.label || styleKey
                                });
                            });
                        }
                    });
                });
                return playlist;
            };

            // --- ب. فلترة ورسم أزرار الأنماط للغرفة المعروضة حالياً فقط ---
            const renderStyleButtonsForCurrentRoom = (targetRoomKey, activeStyleKey) => {
                const roomStyles = oleaData[targetRoomKey]?.styles || {};
                const styleKeys = Object.keys(roomStyles);

                // 1. تحديث الأزرار في الصفحة العادية
                if (stylesContainer) {
                    stylesContainer.innerHTML = '';
                    styleKeys.forEach((styleKey) => {
                        const styleObj = roomStyles[styleKey];
                        if (styleObj && styleObj.gallery?.length > 0) {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = `overlay-style-btn ${styleKey === activeStyleKey ? 'active' : ''}`;
                            btn.textContent = styleObj.label || styleKey;
                            
                            btn.addEventListener('click', (e) => {
                                e.stopPropagation();
                                jumpToRoomAndStyle(targetRoomKey, styleKey);
                            });
                            stylesContainer.appendChild(btn);
                        }
                    });
                }

                // 2. تحديث الأزرار في وضع الشاشة الكاملة (Lightbox)
                if (lightboxStylesContainer) {
                    lightboxStylesContainer.innerHTML = '';
                    styleKeys.forEach((styleKey) => {
                        const styleObj = roomStyles[styleKey];
                        if (styleObj && styleObj.gallery?.length > 0) {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = `overlay-style-btn ${styleKey === activeStyleKey ? 'active' : ''}`;
                            btn.textContent = styleObj.label || styleKey;
                            
                            btn.addEventListener('click', (e) => {
                                e.stopPropagation();
                                jumpToRoomAndStyle(targetRoomKey, styleKey);
                            });
                            lightboxStylesContainer.appendChild(btn);
                        }
                    });
                }
            };

            // --- ج. القفز المباشر لأول صورة في الغرفة والستايل المحدد عند نقر الزر ---
            const jumpToRoomAndStyle = (roomKey, styleKey) => {
                const targetIndex = masterPlaylist.findIndex(
                    item => item.roomKey === roomKey && item.styleKey === styleKey
                );
                if (targetIndex !== -1) {
                    currentIndex = targetIndex;
                    transitionToImage(currentIndex);
                }
            };

            // --- د. الانتقال السينمائي وتحديث الصورة والمسميات والأزرار ---
            const transitionToImage = (index) => {
                const item = masterPlaylist[index];
                if (!item || !mainImage) return;

                const preloader = new Image();
                preloader.src = item.src;
                mainImage.classList.add('is-transitioning');

                if (lightboxImg && isLightboxOpen) {
                    lightboxImg.style.opacity = 0;
                }

                preloader.onload = () => {
                    setTimeout(() => {
                        // 1. تحديث صورة ومسميات الصفحة العادية
                        mainImage.src = item.src;
                        if (roomLabel) roomLabel.textContent = item.roomLabel;
                        if (styleLabel) styleLabel.textContent = item.styleLabel;

                        // 2. تحديث صورة ومسميات الـ Lightbox إن كان مفتوحاً
                        if (lightboxImg && isLightboxOpen) {
                            lightboxImg.src = item.src;
                            lightboxImg.style.opacity = 1;
                        }
                        // التسميات العلوية للكمبيوتر
                        if (lightboxRoomLabel) lightboxRoomLabel.textContent = item.roomLabel;
                        if (lightboxStyleLabel) lightboxStyleLabel.textContent = item.styleLabel;

                        // التسميات السفلية للموبايل
                        if (lightboxMobileRoomLabel) lightboxMobileRoomLabel.textContent = item.roomLabel;
                        if (lightboxMobileStyleLabel) lightboxMobileStyleLabel.textContent = item.styleLabel;

                        // 3. الفلترة الفورية لأزرار الستايلات لتطابق الغرفة الجديدة
                        renderStyleButtonsForCurrentRoom(item.roomKey, item.styleKey);

                        mainImage.classList.remove('is-transitioning');
                    }, 150);
                };

                preloader.onerror = () => {
                    mainImage.classList.remove('is-transitioning');
                    if (lightboxImg && isLightboxOpen) lightboxImg.style.opacity = 1;
                };
            };

            // --- هـ. التنقل بالأسهم عبر كل المشروع ---
            const navigateManual = (step) => {
                if (masterPlaylist.length <= 1) return;
                currentIndex = (currentIndex + step + masterPlaylist.length) % masterPlaylist.length;
                transitionToImage(currentIndex);
            };

            // ربط أزرار الأسهم في الشاشة العادية
            if (prevBtn) {
                prevBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    navigateManual(-1);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    navigateManual(1);
                });
            }

            // ربط أزرار الأسهم في الشاشة الكاملة (Lightbox) لـ Olea Mare فقط
            if (lightboxPrevBtn) {
                lightboxPrevBtn.addEventListener('click', (e) => {
                    if (lightbox && lightbox.dataset.activeGallery === 'olea') {
                        e.stopPropagation();
                        navigateManual(-1);
                    }
                });
            }

            if (lightboxNextBtn) {
                lightboxNextBtn.addEventListener('click', (e) => {
                    if (lightbox && lightbox.dataset.activeGallery === 'olea') {
                        e.stopPropagation();
                        navigateManual(1);
                    }
                });
            }

            // دعم السحب باللمس (Swipe) للشاشة العادية وللشاشة الكاملة للموبايل
            let touchStartX = 0;
            let touchEndX = 0;

            const handleSwipe = (start, end) => {
                const diff = end - start;
                if (diff < -40) navigateManual(1);  // سحب لليسار -> التالي
                if (diff > 40) navigateManual(-1);  // سحب لليمين -> السابق
            };

            if (mainImage) {
                mainImage.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });

                mainImage.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe(touchStartX, touchEndX);
                    if (Math.abs(touchEndX - touchStartX) < 10) openOleaLightbox();
                }, { passive: true });
            }

            if (lightbox) {
                lightbox.addEventListener('touchstart', (e) => {
                    if (lightbox.dataset.activeGallery === 'olea') {
                        touchStartX = e.changedTouches[0].screenX;
                    }
                }, { passive: true });

                lightbox.addEventListener('touchend', (e) => {
                    if (lightbox.dataset.activeGallery === 'olea') {
                        touchEndX = e.changedTouches[0].screenX;
                        handleSwipe(touchStartX, touchEndX);
                    }
                }, { passive: true });
            }

            // --- و. فتح وضع الشاشة الكاملة (Lightbox) ---
            const openOleaLightbox = () => {
                if (masterPlaylist.length === 0) return;

                isLightboxOpen = true;
                const item = masterPlaylist[currentIndex];

                if (lightbox) lightbox.dataset.activeGallery = 'olea';

                if (lightboxImg) {
                    lightboxImg.src = item.src;
                    lightboxImg.style.opacity = 1;
                }
                if (lightboxRoomLabel) lightboxRoomLabel.textContent = item.roomLabel;
                if (lightboxStyleLabel) lightboxStyleLabel.textContent = item.styleLabel;

                if (lightboxMobileRoomLabel) lightboxMobileRoomLabel.textContent = item.roomLabel;
                if (lightboxMobileStyleLabel) lightboxMobileStyleLabel.textContent = item.styleLabel;

                if (lightbox) {
                    lightbox.classList.remove('hidden');
                    lightbox.classList.add('flex');
                    setTimeout(() => lightbox.classList.remove('opacity-0'), 10);
                }

                if (lightboxFooter) {
                    lightboxFooter.classList.remove('hidden');
                    lightboxFooter.classList.add('flex');
                }

                document.body.style.overflow = 'hidden';
            };

            if (expandBtn) expandBtn.addEventListener('click', openOleaLightbox);

            // إغلاق وضع الشاشة الكاملة وتحديث الحالة
            const closeBtn = document.getElementById('lightbox-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    isLightboxOpen = false;
                    if (lightbox) lightbox.dataset.activeGallery = '';
                });
            }

            // --- التشغيل الأولي ---
            masterPlaylist = buildMasterPlaylist();
            if (masterPlaylist.length > 0) {
                transitionToImage(0);
            }
        }
    }

    // ==========================================================================
    // 8. Lightbox Gallery العام (معزول في نطاق خاص لمنع التعارض)
    // ==========================================================================
    {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxClose = document.getElementById('lightbox-close');
        const lightboxNext = document.getElementById('lightbox-next');
        const lightboxPrev = document.getElementById('lightbox-prev');
        const lightboxFooter = document.getElementById('lightbox-footer');

        let currentGallery = [];
        let currentIndex = 0;

        if (lightbox) {
            document.addEventListener('click', (e) => {
                if (e.target.closest('#olea-design-explorer')) return;

                if (e.target.classList.contains('gallery-img')) {
                    openGeneralGallery(e.target);
                } else {
                    const groupWrapper = e.target.closest('.group');
                    if (groupWrapper) {
                        const imgInside = groupWrapper.querySelector('.gallery-img');
                        if (imgInside) openGeneralGallery(imgInside);
                    }
                }
            });

            function openGeneralGallery(imgElement) {
                const container = imgElement.closest('section') || document;
                currentGallery = Array.from(container.querySelectorAll('.gallery-img'));
                currentIndex = currentGallery.indexOf(imgElement);
                if (currentIndex === -1) currentIndex = 0;

                lightbox.dataset.activeGallery = 'general';

                if (lightboxFooter) {
                    lightboxFooter.classList.add('hidden');
                    lightboxFooter.classList.remove('flex');
                }

                showLightbox(imgElement.src);
            }

            function showLightbox(src) {
                if (!lightboxImg) return;
                lightboxImg.src = src;
                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');
                setTimeout(() => lightbox.classList.remove('opacity-0'), 10);
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                lightbox.classList.add('opacity-0');
                setTimeout(() => {
                    lightbox.classList.remove('flex');
                    lightbox.classList.add('hidden');
                    if (lightboxFooter) {
                        lightboxFooter.classList.add('hidden');
                        lightboxFooter.classList.remove('flex');
                    }
                    document.body.style.overflow = '';
                    lightbox.dataset.activeGallery = '';
                }, 300);
            }

            function navigateLightbox(step) {
                if (currentGallery.length > 0 && lightboxImg) {
                    currentIndex = (currentIndex + step + currentGallery.length) % currentGallery.length;
                    lightboxImg.style.opacity = 0;
                    setTimeout(() => {
                        const nextImg = currentGallery[currentIndex];
                        lightboxImg.src = nextImg.src || nextImg;
                        lightboxImg.style.opacity = 1;
                    }, 150);
                }
            }

            if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
            
            if (lightboxNext) {
                lightboxNext.addEventListener('click', () => {
                    if (lightbox.dataset.activeGallery === 'general') navigateLightbox(1);
                });
            }
            
            if (lightboxPrev) {
                lightboxPrev.addEventListener('click', () => {
                    if (lightbox.dataset.activeGallery === 'general') navigateLightbox(-1);
                });
            }

            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) closeLightbox();
            });

            document.addEventListener('keydown', (e) => {
                if (!lightbox.classList.contains('hidden')) {
                    if (e.key === 'Escape') closeLightbox();
                    if (e.key === 'ArrowRight') {
                        if (lightbox.dataset.activeGallery === 'general') navigateLightbox(1);
                    }
                    if (e.key === 'ArrowLeft') {
                        if (lightbox.dataset.activeGallery === 'general') navigateLightbox(-1);
                    }
                }
            });

            let touchstartX = 0;
            let touchendX = 0;

            lightbox.addEventListener('touchstart', e => {
                if (lightbox.dataset.activeGallery === 'general') {
                    touchstartX = e.changedTouches[0].screenX;
                }
            }, { passive: true });

            lightbox.addEventListener('touchend', e => {
                if (lightbox.dataset.activeGallery === 'general') {
                    touchendX = e.changedTouches[0].screenX;
                    if (touchendX < touchstartX - 50) navigateLightbox(1);
                    if (touchendX > touchstartX + 50) navigateLightbox(-1);
                }
            }, { passive: true });
        }
    }

    
});