
// fonction de confirmation de suppression du commentaire
const foodReportForm = document.getElementById('foodReportForm');
const healthReportForm = document.getElementById('healthReportForm');

foodReportForm.style.display = 'none';
healthReportForm.style.display = 'none';

function toggleForm(nbr) {
    
    let form;
    let formBis;
   if (nbr === 1) {
    form = foodReportForm;
    formBis = healthReportForm;
   } else if (nbr === 2) {
    formBis = foodReportForm;
    form = healthReportForm;
   } else { return;}

    form.style.display = form.style.display === "none" ? "block" : "none"; 
    formBis.style.display = "none"; 


}