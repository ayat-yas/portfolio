/* ============================================================
   PORTFOLIO – AYAT CHENINE | BTS SIO SLAM
   main.js
   ============================================================ */

/* ════════════════════════════════════════════
   DONNÉES PROJETS
   ════════════════════════════════════════════ */
const projectData = {
    shopify: {
        title: 'Boutique Shopify – Favaa',
        tags: ['Shopify', 'E-commerce', 'CSS', 'Liquid'],
        situations: ['E4', 'E5'],
        image: 'assets/img/competences/logoboutiquefavaa.png',
        duree: '6 semaines',
        contexteProjet: 'Projet réalisé en formation',
        contexte: "Dans le cadre de ma formation BTS SIO SLAM, j'ai réalisé la conception et le développement d'une boutique en ligne pour la marque Favaa. Ce projet s'inscrit dans le contexte de la digitalisation du commerce et répond aux compétences de développement d'applications métiers.",
        mission: "Concevoir une boutique e-commerce complète, fonctionnelle et esthétique, permettant la gestion des produits, du panier et des commandes clients.",
        realisations: [
            "Configuration et personnalisation du thème Shopify",
            "Intégration du système de panier et de paiement sécurisé",
            "Création des pages produits et de la navigation",
            "Optimisation pour mobile (design responsive)",
            "Tests fonctionnels et mise en ligne"
        ],
        technologies: ['Shopify', 'Liquid (template engine)', 'CSS / HTML', 'JavaScript', 'Trello'],
        competences: ['Développer la présence en ligne', 'Répondre aux incidents', 'Travailler en mode projet']
    },
    neige: {
        title: 'Application Neige & Soleil',
        tags: ['PHP', 'MySQL', 'HTML/CSS', 'JavaScript'],
        situations: ['E4', 'E5'],
        image: 'assets/img/competences/neige et soleil.png',
        duree: '8 semaines',
        contexteProjet: 'Projet réalisé en formation',
        contexte: "Projet de développement d'une application web de gestion pour une agence de location saisonnière (Neige & Soleil). L'application permet de gérer les contrats de mandat locatif et les réservations d'appartements.",
        mission: "Développer une application dynamique en PHP/MySQL permettant la gestion complète des mandats locatifs, des appartements et des réservations.",
        realisations: [
            "Conception du modèle de données (MCD/MLD)",
            "Développement de l'interface d'administration en PHP",
            "Création des formulaires de saisie avec validation",
            "Mise en place de la base de données MySQL",
            "Gestion des sessions et authentification",
            "Tests et déploiement local"
        ],
        technologies: ['PHP 8', 'MySQL', 'HTML5 / CSS3', 'JavaScript', 'PhpMyAdmin', 'Trello'],
        competences: ['Développer la présence en ligne', 'Travailler en mode projet', 'Gérer le patrimoine informatique']
    },
    snake: {
        title: 'Jeu Snake en Langage C',
        tags: ['Langage C', 'Algorithmique', 'Terminal'],
        situations: ['E5'],
        image: 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&q=80',
        duree: '4 semaines',
        contexteProjet: 'Projet académique',
        contexte: "Développement d'un jeu Snake en langage C dans le cadre d'un projet algorithmique. Ce projet avait pour objectif de consolider les bases de la programmation structurée, de la gestion de la mémoire et des entrées/sorties.",
        mission: "Implémenter un jeu Snake fonctionnel en C avec des fonctionnalités avancées : pommes multiples, niveaux de difficulté et système de sauvegarde du score.",
        realisations: [
            "Modélisation de la structure de données du serpent (liste chaînée)",
            "Gestion des entrées clavier en temps réel",
            "Implémentation de plusieurs niveaux de vitesse",
            "Système de génération aléatoire des pommes",
            "Sauvegarde et affichage du meilleur score",
            "Gestion des collisions (murs et corps)"
        ],
        technologies: ['Langage C', 'Bibliothèque ncurses', 'GCC / Linux', 'Structures de données'],
        competences: ['Mettre à disposition un service', 'Répondre aux incidents', 'Travailler en mode projet']
    }
};

/* ════════════════════════════════════════════
   MODALE PROJET
   ════════════════════════════════════════════ */
function openProject(id) {
    const p = projectData[id];
    if (!p) return;

    const tagsHtml        = p.tags.map(t => `<span class="tag">${t}</span>`).join('');
    const situHtml        = p.situations.map(s => `<span class="situ-badge">${s}</span>`).join('');
    const realisHtml      = p.realisations.map(r =>
        `<li style="display:flex;align-items:flex-start;gap:8px;margin-bottom:6px">
            <i class="fas fa-check" style="color:#FF2D6B;margin-top:4px;flex-shrink:0;font-size:.75rem"></i>
            <span>${r}</span>
         </li>`
    ).join('');
    const techHtml        = p.technologies.map(t => `<span class="tag">${t}</span>`).join('');
    const competHtml      = p.competences.map(c =>
        `<span class="glass" style="font-size:.75rem;padding:.3rem .75rem;border-radius:999px;color:#b8b0c8">${c}</span>`
    ).join('');

    document.getElementById('modal-content').innerHTML = `
        <div style="position:relative">
            <img src="${p.image}" alt="${p.title}"
                 style="width:100%;height:192px;object-fit:cover;display:block">
            <div style="position:absolute;inset:0;background:linear-gradient(to top,#120818,transparent)"></div>
            <button onclick="closeProject()"
                    style="position:absolute;top:12px;right:12px;width:38px;height:38px;border-radius:50%;
                           background:rgba(0,0,0,.55);color:#fff;border:none;cursor:pointer;font-size:1rem"
                    aria-label="Fermer">✕</button>
        </div>
        <div style="padding:1.75rem">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:.75rem;margin-bottom:1rem">
                <h2 id="modal-title" style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:900">${p.title}</h2>
                <div style="display:flex;gap:.5rem">${situHtml}</div>
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1.25rem">${tagsHtml}</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1.25rem">
                <div class="glass" style="border-radius:12px;padding:.75rem">
                    <p style="color:#7a6e8a;font-size:.72rem;margin-bottom:4px">Durée</p>
                    <p style="font-weight:500;font-size:.9rem">${p.duree}</p>
                </div>
                <div class="glass" style="border-radius:12px;padding:.75rem">
                    <p style="color:#7a6e8a;font-size:.72rem;margin-bottom:4px">Contexte</p>
                    <p style="font-weight:500;font-size:.9rem">${p.contexteProjet}</p>
                </div>
            </div>
            <div style="margin-bottom:1rem">
                <h3 style="color:#FF2D6B;font-size:.85rem;font-weight:600;margin-bottom:.5rem">Contexte</h3>
                <p style="color:#b8b0c8;font-size:.85rem;line-height:1.6">${p.contexte}</p>
            </div>
            <div style="margin-bottom:1rem">
                <h3 style="color:#FF2D6B;font-size:.85rem;font-weight:600;margin-bottom:.5rem">Mission</h3>
                <p style="color:#b8b0c8;font-size:.85rem;line-height:1.6">${p.mission}</p>
            </div>
            <div style="margin-bottom:1rem">
                <h3 style="color:#FF2D6B;font-size:.85rem;font-weight:600;margin-bottom:.5rem">Réalisations</h3>
                <ul style="color:#b8b0c8;font-size:.85rem;list-style:none;padding:0;margin:0">${realisHtml}</ul>
            </div>
            <div style="margin-bottom:1rem">
                <h3 style="color:#FF2D6B;font-size:.85rem;font-weight:600;margin-bottom:.5rem">Technologies</h3>
                <div style="display:flex;flex-wrap:wrap;gap:.5rem">${techHtml}</div>
            </div>
            <div>
                <h3 style="color:#FF2D6B;font-size:.85rem;font-weight:600;margin-bottom:.5rem">Compétences BTS SIO</h3>
                <div style="display:flex;flex-wrap:wrap;gap:.5rem">${competHtml}</div>
            </div>
        </div>`;

    document.getElementById('project-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeProject() {
    document.getElementById('project-modal').classList.remove('open');
    document.body.style.overflow = '';
}

document.getElementById('project-modal').addEventListener('click', function(e) {
    if (e.target === this) closeProject();
});

/* ════════════════════════════════════════════
   TYPEWRITER (multi-phrases)
   ════════════════════════════════════════════ */
const phrases = [
    "Étudiante en BTS SIO SLAM",
    "Développeuse Web",
    "Passionnée de design",
    "En alternance – Itsuwa France"
];
let phraseIdx = 0, charIdx = 0, isDeleting = false;
const typedEl = document.getElementById('typed-text');

function typeLoop() {
    const current = phrases[phraseIdx];
    typedEl.textContent = current.substring(0, charIdx);

    if (!isDeleting && charIdx < current.length) {
        charIdx++;
        setTimeout(typeLoop, 80);
    } else if (!isDeleting) {
        setTimeout(() => { isDeleting = true; typeLoop(); }, 1800);
    } else if (isDeleting && charIdx > 0) {
        charIdx--;
        setTimeout(typeLoop, 40);
    } else {
        isDeleting = false;
        phraseIdx = (phraseIdx + 1) % phrases.length;
        setTimeout(typeLoop, 300);
    }
}
window.addEventListener('load', typeLoop);

/* ════════════════════════════════════════════
   MENU MOBILE
   ════════════════════════════════════════════ */
const mobileBtn  = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

function toggleMenu(forceState) {
    const open = forceState !== undefined ? forceState : mobileMenu.classList.contains('hidden');
    mobileMenu.classList.toggle('hidden', !open);
    mobileBtn.setAttribute('aria-expanded', String(open));
}

mobileBtn.addEventListener('click', () => toggleMenu());
mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => toggleMenu(false)));
document.addEventListener('click', e => {
    if (!mobileMenu.contains(e.target) && !mobileBtn.contains(e.target)) toggleMenu(false);
});

/* ════════════════════════════════════════════
   SMOOTH SCROLL
   ════════════════════════════════════════════ */
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(a.getAttribute('href'));
        if (target) window.scrollTo({ top: target.offsetTop - 80, behavior: 'smooth' });
    });
});

/* ════════════════════════════════════════════
   BARRE DE PROGRESSION SCROLL
   ════════════════════════════════════════════ */
const progressBar = document.getElementById('scroll-progress');
window.addEventListener('scroll', () => {
    const pct = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
    progressBar.style.width = Math.min(pct, 100) + '%';
}, { passive: true });

/* ════════════════════════════════════════════
   BOUTON RETOUR EN HAUT
   ════════════════════════════════════════════ */
const backBtn = document.getElementById('back-to-top');
window.addEventListener('scroll', () => {
    backBtn.classList.toggle('visible', window.scrollY > 500);
}, { passive: true });

/* ════════════════════════════════════════════
   NAV LIEN ACTIF AU SCROLL
   ════════════════════════════════════════════ */
const sections = document.querySelectorAll('section[id]');
const navLinks  = document.querySelectorAll('.nav-link[data-section]');

window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(s => {
        if (window.scrollY >= s.offsetTop - 160) current = s.id;
    });
    navLinks.forEach(l => l.classList.toggle('active', l.dataset.section === current));
}, { passive: true });

/* ════════════════════════════════════════════
   SCROLL REVEAL + BARRES COMPÉTENCES
   ════════════════════════════════════════════ */
const revealObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('visible');
        entry.target.querySelectorAll('.skill-item').forEach(item => {
            const fill = item.querySelector('.skill-bar-fill');
            if (fill) fill.style.width = item.dataset.pct + '%';
        });
        revealObserver.unobserve(entry.target);
    });
}, { threshold: 0.15 });

document.querySelectorAll('.reveal, .stagger').forEach(el => revealObserver.observe(el));

['#skills-dev', '#skills-mgmt'].forEach(selector => {
    const el = document.querySelector(selector);
    if (!el) return;
    const obs = new IntersectionObserver(([entry]) => {
        if (!entry.isIntersecting) return;
        el.querySelectorAll('.skill-item').forEach(item => {
            const fill = item.querySelector('.skill-bar-fill');
            if (fill) fill.style.width = item.dataset.pct + '%';
        });
        obs.unobserve(el);
    }, { threshold: 0.2 });
    obs.observe(el);
});

/* ════════════════════════════════════════════
   LIGHTBOX
   ════════════════════════════════════════════ */
(function () {
    const overlay  = document.getElementById('lightbox');
    const imgEl    = document.getElementById('lightbox-img');
    const closeBtn = overlay.querySelector('.lightbox__close');
    const prevBtn  = overlay.querySelector('.lightbox__prev');
    const nextBtn  = overlay.querySelector('.lightbox__next');
    let list = [], idx = 0;

    function open(imgs, n) {
        list = imgs; idx = n;
        imgEl.src = list[idx];
        overlay.style.display = 'flex';
        overlay.setAttribute('aria-hidden', 'false');
    }
    function close() {
        overlay.style.display = 'none';
        imgEl.src = '';
        overlay.setAttribute('aria-hidden', 'true');
    }
    function nav(d) {
        idx = (idx + d + list.length) % list.length;
        imgEl.src = list[idx];
    }

    document.querySelectorAll('.thumb[data-images]').forEach(btn => {
        btn.addEventListener('click', () => {
            try {
                const imgs = JSON.parse(btn.dataset.images || '[]');
                if (imgs.length) open(imgs, 0);
            } catch (e) {}
        });
    });

    closeBtn.addEventListener('click', close);
    overlay.addEventListener('click', e => { if (e.target === overlay) close(); });
    prevBtn.addEventListener('click', () => nav(-1));
    nextBtn.addEventListener('click', () => nav(+1));
    window.addEventListener('keydown', e => {
        if (overlay.style.display !== 'flex') return;
        if (e.key === 'Escape')     close();
        if (e.key === 'ArrowLeft')  nav(-1);
        if (e.key === 'ArrowRight') nav(+1);
    });
})();

/* ════════════════════════════════════════════
   TOAST
   ════════════════════════════════════════════ */
function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toast-msg').textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3500);
}

/* ════════════════════════════════════════════
   FORMULAIRE CONTACT
   ════════════════════════════════════════════ */
document.getElementById('contact-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const name    = this.querySelector('[name="name"]').value.trim();
    const email   = this.querySelector('[name="email"]').value.trim();
    const subject = this.querySelector('[name="subject"]').value.trim();
    const message = this.querySelector('[name="message"]').value.trim();
    const errEl   = document.getElementById('form-error');

    if (!name || !email || !message) {
        errEl.classList.remove('hidden');
        return;
    }
    errEl.classList.add('hidden');

    const btn   = document.getElementById('submit-btn');
    const label = document.getElementById('submit-label');
    btn.disabled = true;
    label.textContent = 'Envoi…';

    window.location.href = `mailto:Ayat.chenine@gmail.com`
        + `?subject=${encodeURIComponent(subject || 'Contact Portfolio')}`
        + `&body=${encodeURIComponent('Nom : ' + name + '\nEmail : ' + email + '\n\n' + message)}`;

    setTimeout(() => {
        btn.disabled = false;
        label.textContent = 'Envoyer un message';
        this.reset();
        showToast('Message prêt dans votre client mail !');
    }, 800);
});

/* ════════════════════════════════════════════
   PARTICULES (canvas hero)
   ════════════════════════════════════════════ */
(function () {
    const canvas = document.getElementById('particles-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let W, H, dots = [];

    function resize() {
        W = canvas.width  = canvas.offsetWidth;
        H = canvas.height = canvas.offsetHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    for (let i = 0; i < 60; i++) {
        dots.push({
            x: Math.random() * W, y: Math.random() * H,
            r: Math.random() * 1.5 + .5,
            dx: (Math.random() - .5) * .4,
            dy: (Math.random() - .5) * .4,
            o: Math.random() * .5 + .1
        });
    }

    function draw() {
        ctx.clearRect(0, 0, W, H);
        dots.forEach(d => {
            d.x += d.dx; d.y += d.dy;
            if (d.x < 0 || d.x > W) d.dx *= -1;
            if (d.y < 0 || d.y > H) d.dy *= -1;
            ctx.beginPath();
            ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(255,45,107,${d.o})`;
            ctx.fill();
        });
        requestAnimationFrame(draw);
    }
    draw();
})();

/* ════════════════════════════════════════════
   ANNÉE DYNAMIQUE
   ════════════════════════════════════════════ */
document.getElementById('footer-year').textContent = new Date().getFullYear();

/* ════════════════════════════════════════════
   TOUCHE ÉCHAP — fermer modales
   ════════════════════════════════════════════ */
window.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeProject();
});
