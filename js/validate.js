document.getElementById('register-form').addEventListener('submit', function(event) {

    let valid = true;

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const contact = document.getElementById('contact').value.trim();

    const nameError = document.getElementById('name-error');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');
    const contactError = document.getElementById('contact-error');

    nameError.textContent = '';
    emailError.textContent = '';
    passwordError.textContent = '';
    contactError.textContent = '';

    if (name.length < 2) {
        nameError.textContent = 'Name must be at least 2 characters.';
        valid = false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
        emailError.textContent = 'Please enter a valid email.';
        valid = false;
    }

    const passwordPattern = /^(?=.*\d).{8,}$/;

    if (!passwordPattern.test(password)) {
        passwordError.textContent =
            'Password must be at least 8 characters and contain a number.';
        valid = false;
    }

    const phonePattern = /^[0-9+\-\s]{7,15}$/;

    if (!phonePattern.test(contact)) {
        contactError.textContent = 'Please enter a valid contact number.';
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }

});
