const formsWithConfirmation = document.getElementsByClassName("form_checker");

for(let i = 0; i < formsWithConfirmation.length; i++) {
  formsWithConfirmation.item(i).addEventListener('submit', (event) => {
    if(!confirm("Voulez vous effectuer cette action")) {
      event.preventDefault();
    }
  });
}