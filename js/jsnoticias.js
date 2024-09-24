document.addEventListener('DOMContentLoaded', async function() {
    console.log('DOM fully loaded and parsed');

    const apiKey = '38bcfcbc22294053999b66281ca3de9d';
    const sources = 'clarin,la-nacion,infobae,ambito-financiero';
    const query = 'Tandil';
    const url = `https://newsapi.org/v2/everything?sources=${sources}&q=${query}&sortBy=publishedAt&apiKey=${apiKey}`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        console.log('Data from API:', data);

        const newsContainer = document.querySelector('.news-list');
        const featuredSection = document.querySelector('.featured-news .card');

        if (!newsContainer || !featuredSection) {
            console.error('Uno o más elementos no se encuentran en el DOM.');
            return;
        }

        if (data.status === "ok") {
            if (data.articles.length > 0) {
                const latestNews = data.articles[0];

                // Actualizar la sección destacada
                const featuredImg = featuredSection.querySelector('#featured-img');
                const featuredTitle = featuredSection.querySelector('#featured-title');
                const featuredDesc = featuredSection.querySelector('#featured-desc');

                if (featuredImg) featuredImg.src = latestNews.urlToImage || 'fondoimg.jpg';
                if (featuredTitle) featuredTitle.textContent = latestNews.title;
                if (featuredDesc) featuredDesc.textContent = latestNews.description;

                // Mostrar las noticias en la lista de últimas noticias
                newsContainer.innerHTML = ''; // Limpiar contenedor antes de agregar nuevas noticias
                for (let i = 1; i < Math.min(data.articles.length, 4); i++) {
                    const newsItem = createNewsItem(data.articles[i]);
                    newsContainer.appendChild(newsItem);
                }
            } else {
                newsContainer.innerHTML = '<p>No se encontraron noticias relacionadas con el turismo en Tandil.</p>';
            }
        } else {
            newsContainer.innerHTML = `<p>Error: ${data.message}</p>`;
            featuredSection.innerHTML = `<h1 class="mb-4">Destacado</h1><p>Error: ${data.message}</p>`;
        }
    } catch (error) {
        console.error('Error fetching news:', error);
        const newsContainer = document.querySelector('.news-list');
        if (newsContainer) {
            newsContainer.innerHTML = `<p>Error al cargar las noticias: ${error.message}</p>`;
        }
    }

    function createNewsItem(news) {
        const newsItem = document.createElement('a');
        newsItem.href = news.url;
        newsItem.className = 'news-item d-flex align-items-center';

        const newsImg = document.createElement('img');
        newsImg.src = news.urlToImage || 'fondoimg.jpg';
        newsImg.alt = news.title;
        newsImg.className = 'news-img';

        const newsContent = document.createElement('div');
        newsContent.className = 'news-content';

        const newsTitle = document.createElement('h5');
        newsTitle.className = 'mb-1';
        newsTitle.textContent = news.title;

        const newsDetail = document.createElement('small');
        newsDetail.className = 'text-muted';
        const publishedTime = new Date(news.publishedAt).toLocaleString('es-AR', { timeZone: 'UTC' });
        newsDetail.textContent = `${publishedTime}`;

        newsContent.appendChild(newsTitle);
        newsContent.appendChild(newsDetail);
        newsItem.appendChild(newsImg);
        newsItem.appendChild(newsContent);

        return newsItem;
    }
});
