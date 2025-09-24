function showSection(sectionId){
    const sections = document.querySelectorAll('.section')

    sections.forEach(function(section) {
        section.style.display = 'none';
    });

    const activeSection = document.getElementById(sectionId)
    if (activeSection){
        activeSection.style.display = 'block';
    }

}

document.addEventListener('DOMContentLoaded', function(){
    showSection('home');
});