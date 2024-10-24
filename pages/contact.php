<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
</head>
<body>
    <div class="mt-4">
        <div class="map-container mb-4">
            <iframe 
                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAaVVRssyo46AxfLO6PzNnXw5WQiog74k4&q=Umut+Mahallesi+73084+Nolu+Sokak+No:60+Gaziantep" 
                width="100%" 
                height="500" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>

    <div class="contact-two-content-all">
        <div class="contact-two-content container">
            <div class="text-center">
                <h1 class="contact-heading">İletişim</h1>
                <p class="contact-description">Sormak istedikleriniz mi var? Benimle iletişime geçin.</p>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa-solid fa-envelope"></i> Bana bir mail gönderin</h5>
                            <p class="card-text">info@fotox.com.tr</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa-solid fa-clock"></i> Çalışma Saatleri</h5>
                            <p class="card-text">Pzt - Cuma (9:00 - 20:00)<br>Cumartesi (10:00 - 19:00)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa-solid fa-phone"></i> Telefon ile iletişim</h5>
                            <p class="card-text">0536*******</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa-solid fa-location-dot"></i> Adres</h5>
                            <p class="card-text">Umut Mahallesi 73084 Nolu Sokak No:60, Gaziantep / Türkiye</p>
                        </div>
                    </div>
                </div>
                <div class="message col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form class="contact-form" novalidate>
                                <div class="mb-3 position-relative">
                                    <input type="text" class="form-control" id="name" placeholder=" " required>
                                    <label for="name" class="form-label">Adınız Soyadınız *</label>
                                    <div class="form-text">Bu alan gereklidir. Lütfen adınızı giriniz.</div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <input type="email" class="form-control" id="email" placeholder=" " required>
                                    <label for="email" class="form-label">E-posta Adresi *</label>
                                </div>
                                <div class="mb-3 position-relative">
                                    <input type="tel" class="form-control" id="phone" placeholder=" " required>
                                    <label for="phone" class="form-label">Telefon Numarası *</label>
                                </div>
                                <div class="mb-3 position-relative">
                                    <textarea class="form-control" id="message" rows="3" maxlength="180" placeholder=" " required></textarea>
                                    <label for="message" class="form-label">Mesajınız *</label>
                                    <div class="form-text">Bu alan gereklidir. Lütfen mesajınızı giriniz.</div>
                                </div>
                                <button type="submit" class="btn btn-danger">Gönder</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-three-content-all">
        <div class="contact-three-content container">
            <h2 class="contact-three-heading">Sıkça Sorulan Sorular</h2>
            <p class="contact-three-description">
                Müşterilerimiz tarafından sıkça sorulan ve merak edilen genel soruları sizler için derledik. Cevap aradığınız sorular burada yoksa bize iletişim kanallarımızdan ulaşabilirsiniz.
            </p>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="accordion" id="faqAccordionLeft">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Hangi tür fotoğrafçılık hizmetleri sunuyorsunuz?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    Vermiş olduğumuz tüm fotoğrafçılık hizmetlerini hizmetler sayfamızdan veya ürün çekimi sayfamızdan görebilirsiniz.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Hangi Şehirlere Hizmet Veriyorsunuz?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    [Açıklama buraya gelecek]
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="accordion" id="faqAccordionRight">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    Fiyatlandırma nasıl çalışıyor?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                    [Açıklama buraya gelecek]
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Çekim süreci nasıl işler?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                    [Açıklama buraya gelecek]
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
