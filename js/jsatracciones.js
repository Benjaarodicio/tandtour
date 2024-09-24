// JavaScript para abrir y cerrar el modal
document.querySelectorAll('.open-modal').forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        const modalId = this.getAttribute('data-modal');
        const modal = document.getElementById(modalId);
        modal.classList.add('show');
        setTimeout(() => { // Delay para que la transformación comience después de la visibilidad
            modal.querySelector('.modal-content').classList.add('show');
        }, 50);
    });
});

document.querySelectorAll('.close').forEach(span => {
    span.addEventListener('click', function () {
        const modal = this.closest('.modal');
        modal.querySelector('.modal-content').classList.remove('show');
        setTimeout(() => { // Delay para ocultar el modal después de que la transformación haya terminado
            modal.classList.remove('show');
        }, 500);
    });
});

window.addEventListener('click', function (event) {
    if (event.target.classList.contains('modal')) {
        const modal = event.target;
        modal.querySelector('.modal-content').classList.remove('show');
        setTimeout(() => {
            modal.classList.remove('show');
        }, 500);
    }
});