function openAddAppointmentModal() {
    document.getElementById('addAppointmentModal').style.display = 'flex';
}

function closeAddAppointmentModal() {
    document.getElementById('addAppointmentModal').style.display = 'none';
}

function openUpdateAppointmentModal(id, name, pet, date, time, phone, doctor, location) {
    document.getElementById('update-appointment-id').value = id;
    document.getElementById('update-appointment-name').value = name;
    document.getElementById('update-appointment-pet').value = pet;
    document.getElementById('update-appointment-date').value = date;
    document.getElementById('update-appointment-time').value = time;
    document.getElementById('update-appointment-phone').value = phone;
    document.getElementById('update-appointment-doctor').value = doctor;
    document.getElementById('update-appointment-location').value = location;
    document.getElementById('updateAppointmentModal').style.display = 'flex';
}

function closeUpdateAppointmentModal() {
    document.getElementById('updateAppointmentModal').style.display = 'none';
}