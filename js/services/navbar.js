/* ══════════════════════════════════════════════════════
    NAV ATTIVA — evidenzia il link della sezione corrente
    Aggiorna il colore del link mentre si scrolla la pagina
══════════════════════════════════════════════════════ */

const tutteLeSections = document.querySelectorAll('section[id]');
const tuttiILinks = document.querySelectorAll('.nav-links a');

window.addEventListener('scroll', () => {
    let sezioneCorrente = '';

    /* trova la sezione attualmente in viewport */
    tutteLeSections.forEach(sezione => {
        if (window.scrollY >= sezione.offsetTop - 120) {
            sezioneCorrente = sezione.id;
        }
    });

    /* aggiorna il colore di ogni link di navigazione */
    tuttiILinks.forEach(link => {
        const èAttivo = link.getAttribute('href') === '#' + sezioneCorrente;
        link.style.color = èAttivo ? 'var(--white)' : '';
    });
});

const navToggle = document.querySelector('.nav-toggle');
const navLinks = document.querySelector('.nav-links');

navToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

/* chiude il menu quando si clicca una voce */
document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('active');
    });
});