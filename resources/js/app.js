import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(() => {
            // Use the Alert class directly since it was imported
            try {
                const bsAlert = new Alert(alert);
                bsAlert.close();
            } catch (e) {
                // Fallback if the above fails: just remove it from DOM
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }
        }, 3000);
    });
});