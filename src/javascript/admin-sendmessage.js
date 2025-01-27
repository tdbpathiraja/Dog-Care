function updateEmailField() {
    const select = document.getElementById('booking-select');
    const selectedOption = select.options[select.selectedIndex];
    const emailField = document.getElementById('booking-email');
        
    emailField.value = selectedOption.getAttribute('data-email');
}