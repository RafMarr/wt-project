// Risolvere l'errore di bootstrap per gli aria hidden sui modal
// Bootstrap fa rimanere il focus sugli elementi del modal che poi vengono nascosti sotto aria-hidden="true"
// https://stackoverflow.com/questions/30298041/capture-close-event-on-bootstrap-modal

const modalElements = document.querySelectorAll("div.modal");

modalElements.forEach(modal => {
    modal.addEventListener('hide.bs.modal', () => {
        if (document.activeElement) {
            document.activeElement.blur();
        }
    });
});