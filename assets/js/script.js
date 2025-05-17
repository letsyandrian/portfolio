// Validation simple du formulaire de contact
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('#contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const email = document.querySelector('#email').value;
            const name = document.querySelector('#name').value;
            const message = document.querySelector('#message').value;
            
            // Remove any existing alerts
            const existingAlert = contactForm.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }

            // Validate fields
            if (!name || !email || !message) {
                e.preventDefault();
                showAlert('Veuillez remplir tous les champs.', 'danger');
            } else if (!/\S+@\S+\.\S+/.test(email)) {
                e.preventDefault();
                showAlert('Veuillez entrer une adresse email valide.', 'danger');
            }
        });
    }

    // Function to create and display a Bootstrap alert
    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        contactForm.prepend(alertDiv);
    }
});