document.querySelectorAll('.news-filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.news-filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.dataset.filter;
        document.querySelectorAll('.news-article-card, .news-highlight').forEach(item => {
            const match = filter === 'tutte' || item.dataset.category === filter;
            item.style.display = match ? '' : 'none';
        });
    });
});