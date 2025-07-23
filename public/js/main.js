/**
 * Scripts JavaScript pour L'Étudiant
 * Fonctionnalités interactives et animations
 */

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

/**
 * Initialisation de l'application
 */
function initializeApp() {
    // Animation des cards au scroll
    observeCardAnimations();
    
    // Smooth scrolling pour les liens internes
    initializeSmoothScrolling();
    
    // Gestion des tooltips Bootstrap
    initializeTooltips();
    
    // Gestion du formulaire de recherche
    initializeSearchForm();
    
    console.log('L\'Étudiant - Application initialisée');
}

// Fonctions simplifiées pour la compatibilité
function observeCardAnimations() {
    // Animation simple au chargement
    const cards = document.querySelectorAll('.article-card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

function initializeSmoothScrolling() {
    // Smooth scrolling basique
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

function initializeTooltips() {
    // Initialisation des tooltips Bootstrap si disponible
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
}

function initializeSearchForm() {
    const searchForm = document.querySelector('form.d-flex');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Fonctionnalité de recherche à venir !');
        });
    }
}