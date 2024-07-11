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
