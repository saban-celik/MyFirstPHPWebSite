document.addEventListener('DOMContentLoaded', function () {
    // Mesaj sayaç işlemi
    const messageField = document.getElementById('message');
    const messageCounter = document.getElementById('messageCounter');

    if (messageField && messageCounter) {
        messageField.addEventListener('input', function () {
            const maxLength = messageField.getAttribute('maxlength');
            const currentLength = messageField.value.length;
            messageCounter.textContent = `${currentLength} / ${maxLength}`;
        });
    }

    // Animation class ekleme işlemi
    const aboutSection = document.getElementById('about-section');
    const aboutSectionTop = aboutSection.getBoundingClientRect().top;

    const aboutImages = document.querySelectorAll('.about-image');

    window.addEventListener('scroll', () => {
        const scrollPosition = window.scrollY + window.innerHeight;

        if (scrollPosition >= aboutSectionTop) {
            aboutSection.classList.add('slideIn');
            aboutImages.forEach((img, index) => {
                img.style.animationDelay = `${index * 0.5}s`;
                img.classList.add('slideIn');
            });
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const data = [
        { img: 'img/fotostudyo.jpg', title: 'Stüdyomuz', date: '29 Şubat 2024', comments: 'Yorum yapılmamış' },
        { img: 'img/dugunfoto.jpg', title: 'Düğün Çekimlerimiz', date: '29 Şubat 2024', comments: 'Yorum yapılmamış' },
        { img: 'img/hamilefoto.jpeg', title: 'Hamile Fotoğraf Çekimi', date: '29 Şubat 2024', comments: 'Yorum yapılmamış' },
        { img: 'img/damatfoto.jpeg', title: 'Damat Çekimi', date: '11 Ocak 2024', comments: 'Yorum yapılmamış' },
        { img: 'img/kina.jpg', title: 'Kına Çekimlerimiz', date: '2 Mart 2021', comments: 'Yorum yapılmamış' },
        { img: 'img/sozfoto.jpeg', title: 'Söz Fotoğraf Çekimi – Söz Fotoğrafçısı', date: '1 Mart 2021', comments: 'Yorum yapılmamış' },
        { img: 'img/gaziantepfoto.jpeg', title: 'Gaziantep Tarihi Fotoğrafçısı', date: '1 Mart 2021', comments: 'Yorum yapılmamış' },
        { img: 'img/botanikFoto.jpeg', title: 'Botanik Bahçesi Fotoğraf Çekimlerimiz', date: '24 Şubat 2021', comments: 'Yorum yapılmamış' },
        { img: 'img/mezuniyetfoto.jpeg', title: 'Mezuniyet Fotoğraf Çekimi', date: '11 Ağustos 2020', comments: 'Yorum yapılmamış' },
        { img: 'img/rumkaleFoto.jpeg', title: 'Rumkale Fotoğraf Çekimi', date: '16 Haziran 2020', comments: 'Yorum yapılmamış' },
        { img: 'img/bebekFoto.jpg', title: 'Bebek Fotğraflarımız', date: '15 Mart 2017', comments: 'Yorum yapılmamış' },
        { img: 'img/dugunSalonuFoto.jpeg', title: 'Düğün Salonlarımız', date: '8 Mart 2017', comments: 'Yorum yapılmamış' },
        { img: 'img/cocukFoto.jpeg', title: ' Çocuk Fotoğraflarımız', date: '30 Ocak 2014', comments: 'Yorum yapılmamış' },
    ];
    const container = document.getElementById('blog-cards-container');
    const itemsToShow = 6;
    let currentIndex = 0;

    function createCard(item) {
        return `
            <div class="col-md-4">
                <div class="card">
                    <img src="${item.img}" class="card-img-top" alt="${item.title}">
                    <div class="card-body">
                        <h5 class="card-text">${item.title}</h5>
                        <div class="card-info">
                            <p class="card-date">${item.date}</p>
                            <p class="card-comments">${item.comments}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function loadMoreCards() {
        const nextIndex = currentIndex + itemsToShow;
        data.slice(currentIndex, nextIndex).forEach(item => {
            container.innerHTML += createCard(item);
        });
        currentIndex = nextIndex;

        // Hide button if no more cards to load
        if (currentIndex >= data.length) {
            document.getElementById('load-more-btn').style.display = 'none';
            document.getElementById('no-more-posts').style.display = 'block';
        }
    }

    // Load initial set of cards
    loadMoreCards();

    // Add event listener to the button
    document.getElementById('load-more-btn').addEventListener('click', loadMoreCards);
});document.addEventListener('DOMContentLoaded', function() {
    const services = [
        {
            title: "Ürün Fotoğraf Çekimi",
            description: "Ürün fotoğraf çekimi, bir ürünün en iyi şekilde gösterilmesi için profesyonel bir fotoğrafçılık hizmetidir.",
            img: "img/urun.jpeg",
            alt: "Product Photography"
        },
        {
            title: "Yemek Fotoğraf Çekimi",
            description: "Yemek fotoğraf çekimi, yemekleri çekici ve lezzetli göstermek için yapılan profesyonel bir fotoğrafçılık türüdür.",
            img: "img/yemek.jpeg",
            alt: "Food Photography"
        },
        {
            title: "Otel Fotoğraf Çekimi",
            description: "Otel fotoğraf çekimi potansiyel misafirlere otelin atmosferini, konforunu ve özelliklerini göstererek onları cezbetmeyi amaçlar.",
            img: "img/otel.jpeg",
            alt: "Hotel Photography"
        },
        {
            title: "Moda Fotoğraf Çekimi",
            description: "Moda fotoğraf çekimi profesyonel modeller ve makyaj sanatçılarıyla çalışılarak giyim, aksesuar ve stil unsurlarını vurgulayan profesyonel bir fotoğrafçılık türüdür.",
            img: "img/moda.jpeg",
            alt: "Fashion Photography"
        },
        {
            title: "Portre Fotoğraf Çekimi",
            description: "Portre fotoğraf çekimi, bireylerin ya da grupların yüz ifadelerini, güzelliğini, kişiliğini ve duygusal durumları vurgulayan profesyonel bir fotoğrafçılık türüdür.",
            img: "img/portre.jpeg",
            alt: "Portrait Photography"
        },
        {
            title: "Drone Çekimi",
            description: "Drone çekimi, muhteşem fotoğraflar, manzaralar ve videolar çekmek için bir drone'un kullanılmasını içeren bir hava fotoğrafçılığı tekniğidir.",
            img: "img/drone.png",
            alt: "Drone Photography"
        },
        {
            title: "Endüstriyel Fotoğraf Çekimi",
            description: "Endüstriyel fotoğraf çekimi, fabrikalar, üretim tesisleri, altyapı projeleri ve diğer endüstriyel ortamlarda faaliyetleri ve ürünleri belgelemek için kullanılan profesyonel bir fotoğrafçılık türüdür.",
            img: "img/endustriyelFoto.jpg",
            alt: "Industrial Photography"
        },
        {
            title: "Still Life Fotoğraf Çekimi",
            description: "Still life fotoğraf çekimi, hareketsiz nesnelerin görsel estetik, düzen ve detaylar üzerine odaklanan bir yaklaşımla profesyonel olarak fotoğraflanmasıdır.",
            img: "img/moda.jpeg",
            alt: "Still Life Photography"
        },
        {
            title: "Headshot / Cast Fotoğraf Çekimi",
            description: "Headshot ve cast fotoğraf çekimleri, oyuncular, modeller, sunucular, iş profesyonelleri ve kariyerlerinde profesyonel bir görüntü sunmak isteyen herkes için önemlidir.",
            img: "img/heaadshotFoto.jpeg",
            alt: "Headshot Photography"
        },
        {
            title: "Kişisel-Doğa Fotoğraf Çekimi",
            description: "Kişisel fotoğraf çekimi, bireylerin portresini, kişisel tarzını, hikayesini fotoğraflar aracılığıyla anlatan profesyonel bir fotoğraf türüdür.",
            img: "img/kiselDogaFoto.jpeg",
            alt: "Personal Photography"
        },
        {
            title: "Reklam Fotoğraf Çekimi",
            description: "Reklam fotoğraf çekimi, ürünlerin, hizmetlerin veya fikirlerin potansiyel müşterilere çekici ve ikna edici bir şekilde sunulması için yapılan bir fotoğrafçılık türüdür.",
            img: "img/reklamFoto.jpeg",
            alt: "Advertising Photography"
        },
        {
            title: "Sosyal Medya Uzmanı",
            description: "Sosyal medya uzmanı, dijital dünyada marka bilinirliğini artırmak, müşteri sadakatini sağlamak ve işletme hedeflerini desteklemek için sosyal medya platformlarının dinamiklerini ve trendlerini yakından takip ederek, hedef kitleye uygun stratejiler geliştirmektedir.",
            img: "img/sosyalMedyaFoto.jpeg",
            alt: "Social Media Expert"
        }
    ];

    const servicesContainer = document.getElementById('services-cards');

    services.forEach(service => {
        const colDiv = document.createElement('div');
        colDiv.className = 'col-md-4 mb-4';

        const cardDiv = document.createElement('div');
        cardDiv.className = 'card h-100';

        const img = document.createElement('img');
        img.src = service.img;
        img.className = 'card-img-top';
        img.alt = service.alt;

        const cardBodyDiv = document.createElement('div');
        cardBodyDiv.className = 'card-body';

        const cardTitle = document.createElement('h5');
        cardTitle.className = 'card-title';
        cardTitle.textContent = service.title;

        const cardText = document.createElement('p');
        cardText.className = 'card-text';
        cardText.textContent = service.description;

        const cardFooter = document.createElement('div');
        cardFooter.className = 'card-footer';

        cardBodyDiv.appendChild(cardTitle);
        cardBodyDiv.appendChild(cardText);
        cardDiv.appendChild(img);
        cardDiv.appendChild(cardBodyDiv);
        cardDiv.appendChild(cardFooter);
        colDiv.appendChild(cardDiv);
        servicesContainer.appendChild(colDiv);
    });
});
