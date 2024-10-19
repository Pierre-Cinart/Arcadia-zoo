document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('popupMessage');
    
    if (popup) {
      
        setTimeout(function () {
            popup.style.display = 'none';
        }, 5000);
    }
});
