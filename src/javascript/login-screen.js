document.addEventListener('DOMContentLoaded', () => {
    const visitorBtn = document.getElementById('visitorBtn');
    const adminBtn = document.getElementById('adminBtn');
    const visitorPanel = document.getElementById('visitorPanel');
    const adminPanel = document.getElementById('adminPanel');
    const visitorLoginForm = document.getElementById('visitorLoginForm');
    const adminLoginForm = document.getElementById('adminLoginForm');

    function toggleLoginType(type) {
        if (type === 'visitor') {
            visitorBtn.classList.add('active');
            adminBtn.classList.remove('active');
            visitorPanel.classList.add('active');
            adminPanel.classList.remove('active');
        } else {
            adminBtn.classList.add('active');
            visitorBtn.classList.remove('active');
            adminPanel.classList.add('active');
            visitorPanel.classList.remove('active');
        }
    }

    visitorBtn.addEventListener('click', () => toggleLoginType('visitor'));
    adminBtn.addEventListener('click', () => toggleLoginType('admin'));
});