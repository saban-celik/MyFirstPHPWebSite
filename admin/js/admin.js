document.getElementById("menu-toggle").addEventListener("click", function (e) {
    e.preventDefault();
    document.getElementById("wrapper").classList.toggle("toggled");
});

document.getElementById("homeMenuToggle").addEventListener("click", function (e) {
    e.preventDefault();
    $('#homeSubmenu').collapse('toggle');
});

document.getElementById("aboutMenuToggle").addEventListener("click", function (e) {
    e.preventDefault();
    $('#aboutSubmenu').collapse('toggle');
});

document.getElementById("servicesMenuToggle").addEventListener("click", function (e) {
    e.preventDefault();
    $('#servicesSubmenu').collapse('toggle');
});
document.getElementById("blogMenuToggle").addEventListener("click", function (e) {
    e.preventDefault();
    $('#blogSubmenu').collapse('toggle');
});
document.getElementById("contactMenuToggle").addEventListener("click", function (e) {
    e.preventDefault();
    $('#contactSubmenu').collapse('toggle');
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            if (confirm('Bu içeriği silmek istediğinize emin misiniz?')) {
                window.location.href = `?page=home1&delete=${id}`;
            }
        });
    });
});
