function openAddDoctorModal() {
    document.getElementById('addDoctorModal').style.display = 'flex';
}

function closeAddDoctorModal() {
    document.getElementById('addDoctorModal').style.display = 'none';
}

function openUpdateDoctorModal(id, name, username, email, location, contact) {
    document.getElementById('update-doctor-id').value = id;
    document.getElementById('update-doctor-name').value = name;
    document.getElementById('update-doctor-username').value = username;
    document.getElementById('update-doctor-email').value = email;
    document.getElementById('update-doctor-location').value = location;
    document.getElementById('update-doctor-contact').value = contact;
    document.getElementById('updateDoctorModal').style.display = 'flex';
}

function closeUpdateDoctorModal() {
    document.getElementById('updateDoctorModal').style.display = 'none';
}