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
