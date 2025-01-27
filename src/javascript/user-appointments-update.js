function openEditPopup(appointment) {
    document.getElementById('appointment_id').value = appointment.id;
    document.getElementById('edit_pet').value = appointment.pet;
    document.getElementById('edit_date').value = appointment.date;
    document.getElementById('edit_time').value = appointment.time;
    document.getElementById('edit_phone').value = appointment.phone;
    document.getElementById('edit_doctor').value = appointment.doctor;
    document.getElementById('edit_location').value = appointment.location;
    openPopup('editAppointmentPopup');
}

function openDeletePopup(appointmentId) {
    document.getElementById('delete_appointment_id').value = appointmentId;
    openPopup('deleteAppointmentPopup');
}

function openPopup(popupId) {
    document.getElementById(popupId).style.display = 'flex';
}

function closePopup(popupId) {
    document.getElementById(popupId).style.display = 'none';
}

window.addEventListener('click', function(event) {
    const popups = document.querySelectorAll('.popup');
    popups.forEach(popup => {
        if (event.target === popup) {
            popup.style.display = 'none';
        }
    });
});