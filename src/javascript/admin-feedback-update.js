function openUpdateModal(id, name, email, message) {
    document.getElementById('update-id').value = id;
    document.getElementById('update-name').value = name;
    document.getElementById('update-email').value = email;
    document.getElementById('update-message').value = message;
    document.getElementById('updateModal').style.display = 'flex';
}

function closeUpdateModal() {
    document.getElementById('updateModal').style.display = 'none';
}