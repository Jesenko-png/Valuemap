import './bootstrap';

const siteHeader = document.querySelector('.site-header');
const syncHeader = () => siteHeader?.classList.toggle('is-compact', window.scrollY > 36);
syncHeader();
window.addEventListener('scroll', syncHeader, { passive: true });

const toggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');
let menuScrollPosition = 0;
const setMenuState = (open) => {
    if (!menu || !toggle) return;

    const wasOpen = document.body.classList.contains('menu-open');

    menu.classList.toggle('open', open);
    document.body.classList.toggle('menu-open', open);
    toggle.classList.toggle('is-open', open);
    toggle.setAttribute('aria-expanded', String(open));
    toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');

    if (open) {
        menuScrollPosition = window.scrollY;
        document.body.style.top = `-${menuScrollPosition}px`;
        document.body.style.position = 'fixed';
        document.body.style.width = '100%';
    } else if (wasOpen) {
        document.body.style.removeProperty('top');
        document.body.style.removeProperty('position');
        document.body.style.removeProperty('width');
        window.scrollTo(0, menuScrollPosition);
    }
};

toggle?.addEventListener('click', () => setMenuState(!menu?.classList.contains('open')));
menu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setMenuState(false)));
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && menu?.classList.contains('open')) {
        setMenuState(false);
        toggle?.focus();
    }
});
window.addEventListener('resize', () => {
    if (window.innerWidth > 1050) setMenuState(false);
});

// Content stays visible without JavaScript; animate only when it enters the viewport.
const motionPreference = window.matchMedia('(prefers-reduced-motion: reduce)');
const runningReveals = new Map();
const counterFrames = new Map();
const publicMain = document.querySelector('main#main');
const revealItems = publicMain ? [...publicMain.querySelectorAll(
    '.reveal, .section-heading, .intro-grid > div, .page-hero > *, .cta-section > *, '
    + '.wp-preview article, .partner-strip > a, .stakeholder-wheel > a, .content-card, '
    + '.empty-card, .news-list > a, .map-intro, .europe-map-panel'
)].filter((item) => !item.closest('.process-flow')
    && !item.parentElement.closest('.reveal, .section-heading')) : [];

const finishMotion = () => {
    runningReveals.forEach((animation) => animation.cancel());
    runningReveals.clear();
    counterFrames.forEach(({ frame, original }, item) => {
        cancelAnimationFrame(frame);
        item.textContent = original;
    });
    counterFrames.clear();
};
motionPreference.addEventListener('change', () => {
    if (motionPreference.matches) finishMotion();
});
document.addEventListener('focusin', (event) => {
    runningReveals.forEach((animation, item) => {
        if (item.contains(event.target)) {
            animation.cancel();
            runningReveals.delete(item);
        }
    });
});

if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        observer.unobserve(entry.target);
        if (motionPreference.matches || !entry.target.animate) return;
        const item = entry.target;
        const index = revealItems.indexOf(item);
        const distance = window.innerWidth < 600 ? 20 : 48;
        const animation = item.animate([
            { opacity: 0, transform: `translateX(${index % 2 ? distance : -distance}px)` },
            { opacity: 1, transform: 'translateX(0)' },
        ], { duration: 750, easing: 'cubic-bezier(.2,.7,.2,1)' });
        runningReveals.set(item, animation);
        animation.onfinish = () => runningReveals.delete(item);
    }), { threshold: 0, rootMargin: '0px 0px -32px 0px' });
    revealItems.forEach((item) => observer.observe(item));

    // Start the whole sequence together so the five steps form one falling wave.
    const processObserver = new IntersectionObserver((entries) => entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        processObserver.unobserve(entry.target);
        if (motionPreference.matches) return;
        entry.target.querySelectorAll('li').forEach((item, index) => {
            if (!item.animate) return;
            const animation = item.animate([
                { opacity: 0, transform: 'translateY(-55px)', offset: 0 },
                { opacity: 1, transform: 'translateY(5px)', offset: 0.78 },
                { opacity: 1, transform: 'translateY(0)', offset: 1 },
            ], {
                duration: 1500,
                delay: index * 360,
                easing: 'cubic-bezier(.22,.61,.36,1)',
                fill: 'backwards',
            });
            runningReveals.set(item, animation);
            animation.onfinish = () => runningReveals.delete(item);
        });
    }), { threshold: 0, rootMargin: '0px 0px -100px 0px' });
    publicMain?.querySelectorAll('.process-flow').forEach((flow) => processObserver.observe(flow));

    const countObserver = new IntersectionObserver((entries) => entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        countObserver.unobserve(entry.target);
        const item = entry.target;
        const original = item.textContent;
        const match = original.match(/^(\d+)(.*)$/);
        if (!match || motionPreference.matches) return;
        const target = Number(match[1]);
        const started = performance.now();
        const state = { original, frame: 0 };
        // Keep the final value available to assistive technology throughout.
        item.setAttribute('aria-label', original);
        const tick = (now) => {
            const progress = Math.min((now - started) / 1100, 1);
            const value = Math.round(target * (1 - (1 - progress) ** 3));
            item.textContent = String(value).padStart(match[1].length, '0') + match[2];
            if (progress < 1) state.frame = requestAnimationFrame(tick);
            else {
                item.textContent = original;
                counterFrames.delete(item);
            }
        };
        counterFrames.set(item, state);
        state.frame = requestAnimationFrame(tick);
    }), { threshold: 0.5 });
    publicMain?.querySelectorAll('.project-facts strong, .hero-insight-grid strong')
        .forEach((item) => countObserver.observe(item));
}

const map = document.querySelector('[data-consortium-map]');
const status = map?.querySelector('[data-map-status]');
const statusTitle = status?.querySelector('[data-map-status-title]');
const statusMeta = status?.querySelector('[data-map-status-meta]');
map?.querySelectorAll('[data-partner]').forEach((node) => {
    const selectNode = () => {
        map.querySelectorAll('[data-partner]').forEach((item) => item.classList.remove('active'));
        map.querySelectorAll('.europe-country').forEach((country) => country.classList.toggle('is-active-country', country.dataset.countryCode === node.dataset.countryCode));
        node.classList.add('active');
        if (statusTitle) statusTitle.textContent = node.dataset.partner;
        if (statusMeta) statusMeta.textContent = node.dataset.location;
    };
    node.addEventListener('click', selectNode);
    node.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            selectNode();
        }
    });
});

const consentBanner = document.querySelector('[data-consent-banner]');
const analyticsId = window.valueMapAnalyticsId;

const startAnalytics = () => {
    if (!analyticsId || window.dataLayer) return;
    window.dataLayer = [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    window.gtag('config', analyticsId, { anonymize_ip: true });
    const script = document.createElement('script');
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(analyticsId)}`;
    document.head.appendChild(script);
};

if (analyticsId) {
    const savedConsent = localStorage.getItem('valuemap_analytics_consent');
    if (savedConsent === 'granted') startAnalytics();
    if (!savedConsent && consentBanner) consentBanner.hidden = false;

    consentBanner?.querySelectorAll('[data-consent]').forEach((button) => button.addEventListener('click', () => {
        const choice = button.dataset.consent;
        localStorage.setItem('valuemap_analytics_consent', choice);
        consentBanner.hidden = true;
        if (choice === 'granted') startAnalytics();
    }));
}

const storySlider = document.querySelector('[data-story-slider]');
if (storySlider) {
    const slides = [...storySlider.querySelectorAll('[data-story-slide]')];
    const dots = [...storySlider.querySelectorAll('[data-story-dot]')];
    const stage = storySlider.querySelector('.story-stage');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let activeSlide = 0;
    let storyTimer;

    const showStorySlide = (index) => {
        activeSlide = (index + slides.length) % slides.length;
        slides.forEach((slide, slideIndex) => {
            const isActive = slideIndex === activeSlide;
            slide.classList.toggle('is-active', isActive);
            slide.setAttribute('aria-hidden', String(!isActive));
            if ('inert' in slide) slide.inert = !isActive;
        });
        dots.forEach((dot, dotIndex) => {
            const isActive = dotIndex === activeSlide;
            dot.classList.toggle('is-active', isActive);
            if (isActive) dot.setAttribute('aria-current', 'true');
            else dot.removeAttribute('aria-current');
        });
    };

    const stopStoryTimer = () => window.clearInterval(storyTimer);
    const startStoryTimer = () => {
        stopStoryTimer();
        if (!reducedMotion) storyTimer = window.setInterval(() => showStorySlide(activeSlide + 1), 6500);
    };

    dots.forEach((dot) => dot.addEventListener('click', () => {
        showStorySlide(Number(dot.dataset.storyDot));
        startStoryTimer();
    }));
    storySlider.querySelector('[data-story-prev]')?.addEventListener('click', () => {
        showStorySlide(activeSlide - 1);
        startStoryTimer();
    });
    storySlider.querySelector('[data-story-next]')?.addEventListener('click', () => {
        showStorySlide(activeSlide + 1);
        startStoryTimer();
    });
    stage?.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') showStorySlide(activeSlide - 1);
        if (event.key === 'ArrowRight') showStorySlide(activeSlide + 1);
    });
    storySlider.addEventListener('mouseenter', stopStoryTimer);
    storySlider.addEventListener('mouseleave', startStoryTimer);
    storySlider.addEventListener('focusin', stopStoryTimer);
    storySlider.addEventListener('focusout', startStoryTimer);

    showStorySlide(0);
    startStoryTimer();
}

const contactList = document.querySelector('[data-contact-list]');
const contactTemplate = document.querySelector('[data-contact-template]');
const addContactButton = document.querySelector('[data-add-contact]');
let nextContactIndex = contactList?.querySelectorAll('[data-contact-row]').length ?? 0;

addContactButton?.addEventListener('click', () => {
    if (!contactList || !contactTemplate) return;
    const wrapper = document.createElement('div');
    wrapper.innerHTML = contactTemplate.innerHTML.replaceAll('__INDEX__', String(nextContactIndex++));
    const row = wrapper.firstElementChild;
    if (!row) return;
    contactList.appendChild(row);
    row.querySelector('input')?.focus();
});

contactList?.addEventListener('click', (event) => {
    const button = event.target.closest('[data-remove-contact]');
    if (!button) return;
    button.closest('[data-contact-row]')?.remove();
});

const newsAssistant = document.querySelector('[data-news-assistant]');
const newsForm = newsAssistant?.closest('form');
const newsGenerateButton = newsAssistant?.querySelector('[data-ai-generate]');
const newsAssistantStatus = newsAssistant?.querySelector('[data-ai-status]');

newsGenerateButton?.addEventListener('click', async () => {
    const facts = newsAssistant.querySelector('[data-ai-facts]')?.value.trim();
    if (!facts || facts.length < 20) {
        newsAssistantStatus.textContent = 'Add at least 20 characters of verified source notes.';
        newsAssistant.querySelector('[data-ai-facts]')?.focus();
        return;
    }

    newsGenerateButton.disabled = true;
    newsGenerateButton.setAttribute('aria-busy', 'true');
    newsAssistantStatus.textContent = 'Preparing a draft…';

    try {
        const response = await fetch(newsAssistant.dataset.endpoint, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': newsForm?.querySelector('input[name="_token"]')?.value ?? '',
            },
            body: JSON.stringify({
                facts,
                tone: newsAssistant.querySelector('[data-ai-tone]')?.value ?? 'professional',
            }),
        });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message ?? 'The draft could not be generated.');

        Object.entries(result.draft).forEach(([name, value]) => {
            const field = newsForm?.querySelector(`[name="${name}"]`);
            if (field && typeof value === 'string') field.value = value;
        });
        const typeField = newsForm?.querySelector('[name="type"]');
        if (typeField) typeField.value = 'news';
        newsAssistantStatus.textContent = 'Draft inserted below. Review and edit it before saving.';
        newsForm?.querySelector('[name="title"]')?.focus();
    } catch (error) {
        newsAssistantStatus.textContent = error instanceof Error ? error.message : 'The draft could not be generated.';
    } finally {
        newsGenerateButton.disabled = false;
        newsGenerateButton.removeAttribute('aria-busy');
    }
});
