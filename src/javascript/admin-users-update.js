function openAddUserModal() {
    document.getElementById('addUserModal').style.display = 'flex';
}

function closeAddUserModal() {
    document.getElementById('addUserModal').style.display = 'none';
}

function openUpdateUserModal(id, username, name, email, telephone, address) {
    document.getElementById('update-user-id').value = id;
    document.getElementById('update-username').value = username;
    document.getElementById('update-name').value = name;
    document.getElementById('update-email').value = email;
    document.getElementById('update-telephone').value = telephone;
    document.getElementById('update-address').value = address;
    document.getElementById('updateUserModal').style.display = 'flex';
}

function closeUpdateUserModal() {
    document.getElementById('updateUserModal').style.display = 'none';
}