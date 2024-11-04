
// fonction de confirmation de suppression du commentaire
const foodReportForm = document.getElementById('foodReportForm');
const healthReportForm = document.getElementById('healthReportForm');
const fullReports = document.getElementById('fullReports');

foodReportForm.style.display = 'none';
healthReportForm.style.display = 'none';
fullReports.style.display = 'none';

function toggleForm(nbr) {
    
    let form;
    let formBis;
    let formTer;
   if (nbr === 1) {
    form = foodReportForm;
    formBis = healthReportForm;
    formTer = fullReports;
   } else if (nbr === 2) {
    formBis = foodReportForm;
    form = healthReportForm;
    formTer = fullReports;
   } else if (nbr === 3) {
    formBis = foodReportForm;
    form = fullReports;
    formTer = healthReportForm;
    console.log(form.style.display);
   }

    form.style.display = form.style.display === "none" ? "block" : "none"; 
    formBis.style.display = "none"; 
    formTer.style.display = "none";


}