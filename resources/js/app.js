import './bootstrap';

const toggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');
toggle?.addEventListener('click', () => {
    const open = menu.classList.toggle('open');
    toggle.setAttribute('aria-expanded', String(open));
});
menu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
    menu.classList.remove('open');
    toggle?.setAttribute('aria-expanded', 'false');
}));

const revealItems = document.querySelectorAll('.reveal');
if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
            observer.unobserve(entry.target);
        }
    }), { threshold: 0.12 });
    revealItems.forEach((item) => observer.observe(item));
} else {
    revealItems.forEach((item) => item.classList.add('revealed'));
}

const map = document.querySelector('[data-consortium-map]');
const status = map?.querySelector('[data-map-status]');
map?.querySelectorAll('[data-partner]').forEach((node) => {
    const selectNode = () => {
        map.querySelectorAll('[data-partner]').forEach((item) => item.classList.remove('active'));
        node.classList.add('active');
        status.innerHTML = `<span>●</span> ${node.dataset.partner}`;
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
