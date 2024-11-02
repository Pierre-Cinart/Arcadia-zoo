
// fonction de confirmation de suppression du commentaire
const foodReportForm = document.getElementById('foodReportForm');
const healthReportForm = document.getElementById('healthReportForm');
const reports = document.getElementById('reports');

foodReportForm.style.display = 'none';
healthReportForm.style.display = 'none';
reports.style.display = 'none';

function toggleForm(nbr) {
    
    let form;
    let formBis;
    let formTer;
   if (nbr === 1) {
    form = foodReportForm;
    formBis = healthReportForm;
    formTer = reports;
   } else if (nbr === 2) {
    formBis = foodReportForm;
    form = healthReportForm;
    formTer = reports;
   } else if (nbr === 3) {
    formBis = foodReportForm;
    form = reports;
    formTer = healthReportForm;
   }

    form.style.display = form.style.display === "none" ? "block" : "none"; 
    formBis.style.display = "none"; 
    formTer.style.display = "none";


}