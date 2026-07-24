const home = document.getElementById('homes')
const about = document.getElementById('abouts')
const news = document.getElementById('newss')
const calendario = document.getElementById('calendarios')
const sponsor = document.getElementById('sponsors')
const contatti = document.getElementById('contattis')
const virtualTeam = document.getElementById('virtualTeams')

function getCurrentPageLink() {
    return document.querySelector('.nav-links a[aria-current="page"]');
}

function setActive(link) {
    const current = getCurrentPageLink();
    if (current) current.removeAttribute('aria-current');
    link.setAttribute('aria-current', 'page');
}

home.onclick = () => {
    setActive(home);
}
about.onclick = () => {
    setActive(about);
}
news.onclick = () => {
    setActive(news);
}
calendario.onclick = () => {
    setActive(calendario);
}
sponsor.onclick = () => {
    setActive(sponsor);
}
contatti.onclick = () => {
    setActive(contatti);
}
virtualTeam.onclick = () => {
    setActive(contatti);
}