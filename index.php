<!DOCTYPE html>
<html lang="ita">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passione Motorsport</title>

    <link rel="icon" type="image/png" sizes="16x16" href="img/logo.jpg">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.jpg">
    <link rel="icon" type="image/x-icon" href="img/logo.jpg">


    <link rel="stylesheet" href="css/components/navbar.css">
    <link rel="stylesheet" href="css/components/footer.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/components/responsive.css">

</head>

<body>

    <!-- navBar -->

    <nav>
        <h2>Passione <span>Motorsport</span> Team</h2>
        <button class="nav-toggle" aria-label="Apri menu">
            ☰
        </button>
        <div class="nav-links">
            <a href="#home" id="homes" aria-current="page">home</a>
            <a href="#about" id="abouts">chi siamo</a>
            <a href="#news" id="newss">news</a>
            <a href="#calendario" id="calendarios">calendario</a>
            <a href="#sponsor" id="sponsors">sponsor</a>
            <a href="#virtualTeam" id="virtualTeams">Team Virtuale</a>
            <a href="#contatti" id="contattis">contatti</a>
            <a href="#contatti" class="headerCTA" id="headerCTAin">Entra nel Team</a>
        </div>
        <a href="#contatti" class="headerCTA">Entra nel Team</a>
    </nav>

    <!-- home -->

    <section class="home" id="home">
        <svg class="home-route" width="100%" height="420" viewBox="0 0 1120 420" preserveAspectRatio="none" role="img"
            aria-hidden="true">
            <path d="M -20 380 C 200 380, 260 120, 480 140 C 640 155, 660 300, 840 280 C 980 265, 1000 60, 1160 60"
                fill="none" stroke="rgb(202, 155, 68)" stroke-opacity="1.5" stroke-width="2" stroke-dasharray="10 8" />
        </svg>
        <svg class="home-route2" width="100%" height="420" viewBox="0 0 1120 420" preserveAspectRatio="none" role="img"
            aria-hidden="true">
            <path d="M -20 380 C 200 380, 260 120, 480 140 C 640 155, 660 300, 840 280 C 980 265, 1000 60, 1160 60"
                fill="none" stroke="rgb(202, 155, 68)" stroke-opacity="1" stroke-width="2" stroke-dasharray="10 8" />
        </svg>
        <div class="wrap">
            <h2 class="lineeta upper"> WRC ・ ERC ・ Gare Italiane - <span>Vivi la velocità ・ Condividi
                    l'adrenalina</span></h2>
            <h1 class="introText">Passione Motorsport</h1>

            <div class="underText">
                <h3>
                    Passione Motorsport è una community dedicata agli amanti delle competizioni automobilistiche.<br>
                    Organizziamo eventi online, seguiamo i principali campionati, raccontiamo il motorsport e <br>
                    offriamo a tutti la possibilità di entrare a far parte di un team unito dalla stessa passione.
                </h3>
            </div>

            <div class="hero-actions">
                <a href="#news" class="btn primary">ultime news</a>
                <a href="#contatti" class="btn ghost">contatti</a>
            </div>

        </div>
    </section>

    <!-- chiSiamo/About -->

    <section class="about" id="about">
        <h1>Chi siamo</h1>
        <h3>
            Passione Motorsport nasce dall'incontro di persone accomunate dall'amore per i motori, <br>
            la velocità e la competizione. Il nostro obiettivo è creare una realtà in cui piloti, appassionati,<br>
            fotografi, meccanici e sostenitori possano condividere esperienze, eventi e momenti indimenticabili. <br>
            <br>
            Crediamo che il motorsport non sia solo una disciplina sportiva, ma uno stile di vita fatto di sacrificio,
            <br>
            tecnica, emozioni e lavoro di squadra. <br>
        </h3>
        <div class="cards-grid">
            <div class="info-card">
                <p class="card-title">i nostri obiettivi</p>
                <ul class="info-list">
                    <li>Promuovere la cultura del motorsport</li>
                    <li class="accent">Organizzare e partecipare a eventi sportivi</li>
                    <li>Supportare giovani talenti</li>
                    <li class="accent chiusura">Creare una community inclusiva</li>
                </ul>
            </div>

            <div class="info-card">
                <p class="card-title">i nostri valori</p>
                <ul class="info-list">
                    <li>Passione</li>
                    <li class="accent">Professionalità</li>
                    <li>Spirito di squadra</li>
                    <li class="accent">Sicurezza</li>
                    <li class="chiusura">Innovazione</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- news -->

    <section class="news" id="news">
        <div class="news-container">

            <div class="news-header">
                <h1 class="news-eyebrow">news</h1>
                <h2 class="news-heading">ultime notizie</h2>
            </div>

            <div class="news-category-filter">
                <button class="news-filter-btn active" data-filter="tutte">tutte</button>
                <button class="news-filter-btn" data-filter="gare">gare</button>
                <button class="news-filter-btn" data-filter="community">community</button>
                <button class="news-filter-btn" data-filter="annunci">annunci</button>
            </div>

            <article class="news-highlight" data-id="1" data-category="gare" data-date="2026-07-20">
                <img class="news-highlight-image" src="assets/img/news/img1.png" alt="" loading="lazy">
                <div class="news-highlight-content">
                    <div class="news-item-meta">
                        <span class="news-item-tag">gare</span>
                        <span class="news-item-date">20 luglio 2026</span>
                    </div>
                    <h3 class="news-highlight-title">Titolo dell'articolo in evidenza</h3>
                    <p class="news-highlight-text">Breve descrizione dell'articolo in evidenza.</p>
                    <a href="#" class="news-readmore-link">leggi tutto →</a>
                </div>
            </article>

            <div class="news-article-grid">

                <article class="news-article-card" data-id="2" data-category="community" data-date="2026-07-15">
                    <img class="news-card-image" src="assets/img/news/img2.png" alt="" loading="lazy">
                    <div class="news-card-content">
                        <div class="news-item-meta">
                            <span class="news-item-tag">community</span>
                            <span class="news-item-date">15 luglio 2026</span>
                        </div>
                        <h4 class="news-card-title">Titolo secondo articolo</h4>
                        <p class="news-card-text">Descrizione breve dell'articolo.</p>
                        <a href="#" class="news-readmore-link">leggi tutto →</a>
                    </div>
                </article>

                <article class="news-article-card" data-id="3" data-category="annunci" data-date="2026-07-10">
                    <img class="news-card-image" src="assets/img/news/img3.png" alt="" loading="lazy">
                    <div class="news-card-content">
                        <div class="news-item-meta">
                            <span class="news-item-tag">annunci</span>
                            <span class="news-item-date">10 luglio 2026</span>
                        </div>
                        <h4 class="news-card-title">Titolo terzo articolo</h4>
                        <p class="news-card-text">Descrizione breve dell'articolo.</p>
                        <a href="#" class="news-readmore-link">leggi tutto →</a>
                    </div>
                </article>

                <article class="news-article-card" data-id="4" data-category="gare" data-date="2026-07-05">
                    <img class="news-card-image" src="assets/img/news/img4.png" alt="" loading="lazy">
                    <div class="news-card-content">
                        <div class="news-item-meta">
                            <span class="news-item-tag">gare</span>
                            <span class="news-item-date">5 luglio 2026</span>
                        </div>
                        <h4 class="news-card-title">Titolo quarto articolo</h4>
                        <p class="news-card-text">Descrizione breve dell'articolo.</p>
                        <a href="#" class="news-readmore-link">leggi tutto →</a>
                    </div>
                </article>

            </div>

        </div>
    </section>

    <!-- calendario -->

    <section class="calendario" id="calendario">
        <div class="realRace boxing">
            <h2>Calendario Gare Real Che Supportiamo</h2>
            <h3 class="done">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="during">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
        </div>
        <div class="virtualRace boxing">
            <h2>Calendario Gare Virtuale</h2>
            <h3 class="done">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="during">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
            <h3 class="program">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
        </div>
    </section>

    <!-- sponsor -->

    <section class="sponsor" id="sponsor">
        <h1>I Sostenitori della Pagina</h1>
        <div class="carousel">
            <div class="group">
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
            </div>
            <div aria-hidden class="group">
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
            </div>
            <div aria-hidden class="group">
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.jpg" alt=""></div>
                <div class="card"><img src="assets/img/sponsor/logo.png" alt=""></div>
            </div>
        </div>
    </section>

    <!-- virtuaTeam -->

    <section class="virtualTeam" id="virtualTeam">
        <h1>Passione Motorsport Racing Team</h1>

        <h2>
            Il Team Virtuale è il cuore digitale di Passione Motorsport: una community di quasi 40 persone che vive il
            <br>
            motorsport attraverso il sim racing. Organizziamo gare online, campionati interni e serate a tema, in un
            <br>
            ambiente competitivo ma soprattutto divertente, aperto a chi ama guidare — dal principiante al pilota già
            <br>
            esperto sul simulatore.
        </h2>
        <div class="roadmap">
            <div class="roadmap-item">
                <p class="roadmap-title">numeri della community</p>
                <div class="roadmap-stats">
                    <div><span class="num">40+</span><span class="lbl">membri attivi</span></div>
                    <div><span class="num">10+</span><span class="lbl">gare organizzate</span></div>
                    <div><span class="num">1</span><span class="lbl">campionato stagionale</span></div>
                    <div><span class="num">5+</span><span class="lbl">anni di attività</span></div>
                </div>
            </div>

            <div class="roadmap-item right">
                <p class="roadmap-title">cosa facciamo</p>
                <ul class="roadmap-list">
                    <li>Gare online mensili</li>
                    <li>Campionati con classifica stagionale</li>
                    <li>Supporto ai nuovi piloti</li>
                </ul>
            </div>

            <div class="roadmap-item">
                <p class="roadmap-title">come partecipare</p>
                <ol class="roadmap-steps">
                    <li>Segui la Pagina su Istagram / Facebook</li>
                    <li>Iscriviti al campionato o alla gara</li>
                    <li>Partecipa alle gare con il simulatore supportato</li>
                </ol>
            </div>

            <div class="roadmap-item right">
                <p class="roadmap-title">format delle gare</p>
                <div class="roadmap-badges">
                    <span>E-Rally Completo</span>
                    <span>E-Ronde</span>
                    <span>Campionati a punti</span>
                </div>
            </div>

            <div class="roadmap-item">
                <p class="roadmap-title">regole</p>
                <p class="roadmap-text">Fair play, guida pulita e rispetto degli altri piloti. Regolamento completo
                    disponibile al link della gara</p>
            </div>
        </div>

    </section>

    <!-- contatti -->

    <section class="contatti" id="contatti">
        <div class="spacing send">
            <h2>Scrivici qui sotto se hai qualche domanda</h2>
            <input type="email" class="email" id="email" placeholder="email" name="email">
            <input type="text" maxlength="150" class="text" id="text"
                placeholder="Inserisci qui il contenuto del messaggio" name="text">
            <button type="submit" class="submit" id="submit">Invia</button>
        </div>
        <div class="spacing social">
            <h3>Seguici sui nostri social per rimanere aggiornato</h3>
            <div class="social-links">
                <a href="" target="_blank" class="tiktok">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M14 3c.3 2 1.7 3.4 3.7 3.6v2.6c-1.3 0-2.6-.4-3.7-1.1v6.2a5.3 5.3 0 1 1-5.3-5.3c.3 0 .6 0 .9.1v2.7a2.6 2.6 0 1 0 1.8 2.5V3H14z" />
                    </svg>
                    <span>TikTok</span>
                </a>
                <a href="" target="_blank" class="instagram">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="5" />
                        <circle cx="12" cy="12" r="4" />
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                    </svg>
                    <span>Instagram</span>
                </a>
                <a href="" target="_blank" class="facebook">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M13.5 21v-8h2.7l.4-3.2h-3.1V7.7c0-.9.3-1.6 1.6-1.6h1.7V3.2C16.5 3.1 15.4 3 14.2 3c-2.7 0-4.5 1.6-4.5 4.6v2.2H7v3.2h2.7V21h3.8z" />
                    </svg>
                    <span>Facebook</span>
                </a>
            </div>
        </div>
    </section>

    <!-- footer -->

    <footer>
        <div class="footer-logo">Passione Motorsport Racing Team</div>
        <div class="footer-copy">Passione Motorsport Racing Team © 2026 — TUTTI I DIRITTI RISERVATI</div>
    </footer>

    <script src="js/admin-storage.js"></script>
    <script src="js/services/news.js"></script>
    <script src="js/utils/navbarSwitch.js"></script>
    <script src="js/services/navbar.js"></script>
    <script src="js/index.js"></script>

</body>

</html>
