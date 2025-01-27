function showSection(sectionId) {
        
    document.querySelectorAll('.admin-section').forEach(section => {
        section.style.display = 'none';
    });

    
    document.getElementById(sectionId).style.display = 'block';
}