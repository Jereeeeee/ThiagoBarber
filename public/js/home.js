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

const initMobileCarousels = () => {
    if (window.matchMedia('(min-width: 681px)').matches) {
        return;
    }

    const carousel = document.querySelector('.tiktok-grid');

    if (!carousel || carousel.dataset.carouselReady === '1') {
        return;
    }

    const cards = Array.from(carousel.querySelectorAll('.tiktok-card'));

    if (cards.length <= 1) {
        return;
    }

    const dots = document.createElement('div');
    dots.className = 'carousel-dots tiktok-carousel-dots';
    dots.setAttribute('aria-hidden', 'true');

    const controls = document.createElement('div');
    controls.className = 'carousel-controls tiktok-carousel-controls';

    const prevButton = document.createElement('button');
    prevButton.type = 'button';
    prevButton.className = 'carousel-nav-btn';
    prevButton.setAttribute('aria-label', 'Video anterior');
    prevButton.textContent = '<';

    const counter = document.createElement('span');
    counter.className = 'carousel-index';

    const nextButton = document.createElement('button');
    nextButton.type = 'button';
    nextButton.className = 'carousel-nav-btn';
    nextButton.setAttribute('aria-label', 'Siguiente video');
    nextButton.textContent = '>';

    let activeIndex = 0;

    const getOffsets = () => cards.map((card) => card.offsetLeft);

    const setActiveState = (index) => {
        activeIndex = Math.min(cards.length - 1, Math.max(0, index));

        dots.querySelectorAll('.carousel-dot').forEach((dot, dotIndex) => {
            dot.classList.toggle('is-active', dotIndex === activeIndex);
        });

        counter.textContent = `${activeIndex + 1}/${cards.length}`;
        prevButton.disabled = activeIndex === 0;
        nextButton.disabled = activeIndex === cards.length - 1;
    };

    const scrollToIndex = (index) => {
        const offsets = getOffsets();
        const targetIndex = Math.min(cards.length - 1, Math.max(0, index));
        carousel.scrollTo({ left: offsets[targetIndex] ?? 0, behavior: 'smooth' });
        setActiveState(targetIndex);
    };

    const getClosestIndex = () => {
        const offsets = getOffsets();
        const currentLeft = carousel.scrollLeft;
        let closestIndex = 0;
        let closestDistance = Number.POSITIVE_INFINITY;

        offsets.forEach((offset, index) => {
            const distance = Math.abs(offset - currentLeft);

            if (distance < closestDistance) {
                closestDistance = distance;
                closestIndex = index;
            }
        });

        return closestIndex;
    };

    cards.forEach((_, index) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'carousel-dot';
        dot.setAttribute('aria-label', `Ver video ${index + 1}`);
        dot.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            scrollToIndex(index);
        });
        dots.appendChild(dot);
    });

    prevButton.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        scrollToIndex(activeIndex - 1);
    });

    nextButton.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        scrollToIndex(activeIndex + 1);
    });

    carousel.addEventListener(
        'scroll',
        () => {
            setActiveState(getClosestIndex());
        },
        { passive: true },
    );

    window.addEventListener('resize', () => {
        scrollToIndex(activeIndex);
    });

    controls.append(prevButton, counter, nextButton);
    carousel.insertAdjacentElement('afterend', controls);
    controls.insertAdjacentElement('afterend', dots);

    setActiveState(0);
    carousel.dataset.carouselReady = '1';
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
    initMobileCarousels();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWelcomePage);
} else {
    initWelcomePage();
}


