const menuToggle = document.querySelector('.menu-toggle');
const navList = document.querySelector('.menu ul');

menuToggle.addEventListener('click', () => {
    navList.classList.toggle('active'); // Ajouter ou retirer la classe active
});
