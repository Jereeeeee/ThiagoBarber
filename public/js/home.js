const EFFECT_KEY = 'welcome-gradient-effect-played-v2';

const canUseStorage = () => {
    try {
        const testKey = '__welcome_storage_test__';
        localStorage.setItem(testKey, '1');
        localStorage.removeItem(testKey);
        return true;
    } catch {
        return false;
    }
};

const revealSections = () => {
    const sections = document.querySelectorAll('.section');

    if (sections.length === 0) {
        return;
    }

    if (!('IntersectionObserver' in window)) {
        sections.forEach((section) => section.classList.add('section-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('section-visible');
                observer.unobserve(entry.target);
            });
        },
        {
            threshold: 0.05,
            rootMargin: '0px 0px -5% 0px',
        },
    );

    sections.forEach((section) => observer.observe(section));
};

const enableOneTimeEffect = () => {
    const { body } = document;

    if (!body) {
        return;
    }

    if (!canUseStorage()) {
        body.classList.add('play-once-effect');
        revealSections();
        return;
    }

    const alreadyPlayed = localStorage.getItem(EFFECT_KEY) === '1';

    if (alreadyPlayed) {
        body.classList.add('skip-once-effect');
        return;
    }

    body.classList.add('play-once-effect');
    revealSections();
    localStorage.setItem(EFFECT_KEY, '1');
};

const initWelcomePage = () => {
    enableOneTimeEffect();
    initTikTokCarousel();
    initMobileImageCarousels();
};

const initMobileImageCarousels = () => {
    const roots = Array.from(document.querySelectorAll('[data-mobile-carousel]'));

    if (roots.length === 0) {
        return;
    }

    const mobileQuery = window.matchMedia('(max-width: 680px)');
    const states = new Map();

    const updateActiveSlide = (state) => {
        const { root, track, slides, dots } = state;

        if (!mobileQuery.matches || slides.length === 0) {
            return;
        }

        const trackCenter = track.scrollLeft + track.clientWidth / 2;
        let closestIndex = 0;
        let closestDistance = Number.POSITIVE_INFINITY;

        slides.forEach((slide, index) => {
            const slideCenter = slide.offsetLeft + slide.offsetWidth / 2;
            const distance = Math.abs(slideCenter - trackCenter);

            if (distance < closestDistance) {
                closestDistance = distance;
                closestIndex = index;
            }
        });

        state.currentIndex = closestIndex;

        dots.forEach((dot, index) => {
            dot.classList.toggle('is-active', index === closestIndex);
        });

        root.dataset.carouselCurrent = String(closestIndex);
    };

    const activateCarousel = (root) => {
        const track = root;
        const slides = Array.from(track.children).filter((child) => child instanceof HTMLElement);
        const carouselLabel = root.dataset.carouselLabel || 'Imagen';

        if (slides.length <= 1) {
            root.classList.remove('is-carousel-active');
            return null;
        }

        const dotsContainer = root.nextElementSibling;

        if (!dotsContainer || !dotsContainer.matches('[data-carousel-dots]')) {
            return null;
        }

        const state = {
            root,
            track,
            slides,
            dotsContainer,
            dots: [],
            currentIndex: 0,
            scrollRaf: 0,
            onScroll: null,
        };

        dotsContainer.innerHTML = '';
        state.dots = slides.map((slide, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'carousel-dot';
            dot.setAttribute('aria-label', `${carouselLabel} ${index + 1}`);
            dot.dataset.carouselDot = String(index);

            dot.addEventListener('click', () => {
                slide.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            });

            dotsContainer.appendChild(dot);
            return dot;
        });

        state.onScroll = () => {
            if (state.scrollRaf) {
                return;
            }

            state.scrollRaf = window.requestAnimationFrame(() => {
                state.scrollRaf = 0;
                updateActiveSlide(state);
            });
        };

        track.addEventListener('scroll', state.onScroll, { passive: true });
        root.classList.add('is-carousel-active');
        updateActiveSlide(state);

        return state;
    };

    const deactivateCarousel = (state) => {
        if (!state) {
            return;
        }

        state.track.removeEventListener('scroll', state.onScroll);
        state.root.classList.remove('is-carousel-active');
        delete state.root.dataset.carouselCurrent;
        state.dotsContainer.innerHTML = '';
        if (state.scrollRaf) {
            window.cancelAnimationFrame(state.scrollRaf);
        }
    };

    const syncCarousels = () => {
        roots.forEach((root) => {
            const existingState = states.get(root);

            if (!mobileQuery.matches) {
                deactivateCarousel(existingState);
                states.delete(root);
                return;
            }

            if (existingState) {
                updateActiveSlide(existingState);
                return;
            }

            const nextState = activateCarousel(root);
            if (nextState) {
                states.set(root, nextState);
            }
        });
    };

    syncCarousels();

    if (typeof mobileQuery.addEventListener === 'function') {
        mobileQuery.addEventListener('change', syncCarousels);
    } else if (typeof mobileQuery.addListener === 'function') {
        mobileQuery.addListener(syncCarousels);
    }
};

const initTikTokCarousel = () => {
    const root = document.querySelector('[data-tiktok-carousel]');

    if (!root) {
        return;
    }

    const slides = Array.from(root.querySelectorAll('[data-tiktok-slide]'));
    const videos = Array.from(root.querySelectorAll('.tiktok-video'));
    const dots = Array.from(root.querySelectorAll('[data-tiktok-dot]'));
    const prevBtn = root.querySelector('.tiktok-nav-prev');
    const nextBtn = root.querySelector('.tiktok-nav-next');

    if (slides.length !== 3 || videos.length !== 3) {
        return;
    }

    const mobileQuery = window.matchMedia('(max-width: 680px)');

    let currentIndex = 0;
    let autoplayTimer = null;
    const AUTOPLAY_DELAY = 5000;

    const pauseAllVideos = () => {
        videos.forEach((video) => {
            video.pause();
            video.currentTime = 0;
        });
    };

    const preloadNearVideos = (index) => {
        const current = videos[index];
        const next = videos[(index + 1) % videos.length];

        [current, next].forEach((video) => {
            if (video && video.preload === 'none') {
                video.preload = 'metadata';
            }
        });
    };

    const setActiveUI = (index) => {
        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle('is-active', slideIndex === index);
        });

        dots.forEach((dot, dotIndex) => {
            dot.classList.toggle('is-active', dotIndex === index);
        });
    };

    const clearAutoplay = () => {
        if (autoplayTimer) {
            window.clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    };

    const goTo = (index) => {
        currentIndex = (index + slides.length) % slides.length;
        setActiveUI(currentIndex);

        if (!mobileQuery.matches) {
            return;
        }

        preloadNearVideos(currentIndex);
        pauseAllVideos();

        const activeVideo = videos[currentIndex];
        if (activeVideo) {
            activeVideo.play().catch(() => {
                // Browsers can block autoplay until a gesture occurs.
            });
        }
    };

    const next = () => {
        goTo(currentIndex + 1);
    };

    const prev = () => {
        goTo(currentIndex - 1);
    };

    const configureByViewport = () => {
        clearAutoplay();

        if (mobileQuery.matches) {
            goTo(currentIndex);
            autoplayTimer = window.setInterval(next, AUTOPLAY_DELAY);
            return;
        }

        // Desktop: show all videos without carousel behavior.
        slides.forEach((slide) => slide.classList.add('is-active'));
        dots.forEach((dot) => dot.classList.remove('is-active'));
        dots[0]?.classList.add('is-active');

        videos.forEach((video) => {
            video.preload = 'metadata';
            video.play().catch(() => {
                // Some browsers can block autoplay; leave video paused in that case.
            });
        });
    };

    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            prev();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            next();
        });
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', (e) => {
            e.stopPropagation();
            goTo(index);
        });
    });

    mobileQuery.addEventListener('change', configureByViewport);
    configureByViewport();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWelcomePage);
} else {
    initWelcomePage();
}


