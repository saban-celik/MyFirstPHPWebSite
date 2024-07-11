<div class="container mt-4">
    <div class="map-container mb-4">
        <iframe 
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAaVVRssyo46AxfLO6PzNnXw5WQiog74k4&q=Umut+Mahallesi+73084+Nolu+Sokak+No:60+Gaziantep" 
            width="100%" 
            height="500" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">İletişim</h5>
                    <p class="card-text">Sormak istedikleriniz mi var? Benimle iletişime geçin.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bana bir mail gönderin</h5>
                    <p class="card-text">info@fotox.com.tr</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Çalışma Saatleri</h5>
                    <p class="card-text">Pzt - Cuma (9:00 - 20:00)<br>Cumartesi (10:00 - 19:00)</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Telefon ile iletişim</h5>
                    <p class="card-text">0536*******</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Adres</h5>
                    <p class="card-text">Umut Mahallesi 73084 Nolu Sokak No:60, Gaziantep / Türkiye</p>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-form">
        <form id="contactForm">
            <div class="mb-3">
                <label for="name" class="form-label">Adınız Soyadınız *</label>
                <input type="text" class="form-control" id="name" placeholder="Adınız Soyadınız" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-posta Adresi *</label>
                <input type="email" class="form-control" id="email" placeholder="E-mail" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Telefon Numarası *</label>
                <input type="tel" class="form-control" id="phone" placeholder="+90" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Mesaj</label>
                <textarea class="form-control" id="message" rows="3" placeholder="Mesajınızı giriniz..." maxlength="180"></textarea>
                <div id="messageCounter" class="form-text">0 / 180</div>
            </div>
            <button type="submit" class="btn btn-primary">Gönder</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
