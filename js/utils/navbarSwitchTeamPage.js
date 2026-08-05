const home = document.getElementById('homes')
const setup = document.getElementById('setups')
const news = document.getElementById('newss')
const driver = document.getElementById('drivers')

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
setup.onclick = () => {
    setActive(setup);
}
news.onclick = () => {
    setActive(news);
}
driver.onclick = () => {
    setActive(driver);
}