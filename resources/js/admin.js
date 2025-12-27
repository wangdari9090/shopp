document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');
    const wrapper = document.getElementById('main-wrapper');

    btn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        wrapper.classList.toggle('expanded');
    });

    
    document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    }, 3000);
    });
});

document.addEventListener('DOMContentLoaded', function () {
        var myCarousel = document.querySelector('#arrivalCarousel')
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 3000,
            ride: 'carousel',
            wrap: true 
        });
    });