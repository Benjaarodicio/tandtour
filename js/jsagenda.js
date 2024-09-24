document.addEventListener('DOMContentLoaded', function() {
    const nextBtns = document.querySelectorAll('.nextBtn');
    const prevBtns = document.querySelectorAll('.prevBtn');
    const questionContainers = document.querySelectorAll('.question-container');
    const options = document.querySelectorAll('.option');
    const submitBtn = document.getElementById('submitBtn');
    const resultContainer = document.getElementById('result');
    const locationInput = document.getElementById('ubicacion'); // Campo oculto para ubicación
    const locationStatus = document.getElementById('locationStatus'); // Elemento para mostrar el estado de la ubicación

    let currentQuestion = 0;
    const answers = {};

    options.forEach(option => {
        option.addEventListener('click', function() {
            const parent = option.parentElement;
            const siblings = parent.querySelectorAll('.option');
            siblings.forEach(sib => sib.classList.remove('selected'));
            option.classList.add('selected');
            const questionId = parent.parentElement.id;
            answers[questionId] = option.getAttribute('data-value');
        });
    });

    nextBtns.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            if (validateQuestion(index)) {
                transitionToNextQuestion();
            } else {
                alert('Por favor, selecciona una opción antes de continuar.');
            }
        });
    });

    prevBtns.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            transitionToPreviousQuestion();
        });
    });

    function validateQuestion(index) {
        const selected = questionContainers[index].querySelector('.option.selected');
        return !!selected;
    }

    function transitionToNextQuestion() {
        questionContainers[currentQuestion].classList.remove('active');
        setTimeout(() => {
            currentQuestion++;
            adjustOptionLayout(questionContainers[currentQuestion]);
            questionContainers[currentQuestion].classList.add('active');
        }, 500);
    }

    function transitionToPreviousQuestion() {
        questionContainers[currentQuestion].classList.remove('active');
        setTimeout(() => {
            currentQuestion--;
            adjustOptionLayout(questionContainers[currentQuestion]);
            questionContainers[currentQuestion].classList.add('active');
        }, 500);
    }

    function adjustOptionLayout(container) {
        const optionsContainer = container.querySelector('.options');
        if (!optionsContainer) {
            console.error('No se encontró el contenedor de opciones.');
            return;
        }
        
        const options = optionsContainer.querySelectorAll('.option');
        if (!options.length) {
            console.error('No se encontraron opciones en el contenedor.');
            return;
        }

        const numOptions = options.length;
        if (numOptions > 4) {
            optionsContainer.classList.add('many-options');
        } else {
            optionsContainer.classList.remove('many-options');
        }
    }

    function saveLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                if (locationInput) {
                    locationInput.value = `${lat},${lon}`;
                    locationStatus.textContent = `Ubicación guardada: Lat ${lat}, Lon ${lon}`;
                } else {
                    console.error('No se encontró el campo de ubicación.');
                }
            }, error => {
                console.error('Error al obtener la ubicación: ', error);
                if (locationStatus) {
                    locationStatus.textContent = 'No se pudo obtener la ubicación.';
                }
            });
        } else {
            console.error('La geolocalización no está soportada en este navegador.');
            if (locationStatus) {
                locationStatus.textContent = 'La geolocalización no está soportada en este navegador.';
            }
        }
    }

    document.getElementById('saveLocation').addEventListener('click', saveLocation);

    // Agregar respuestas como campos ocultos al formulario
    document.getElementById('quizForm').addEventListener('submit', function(e) {
        for (const [key, value] of Object.entries(answers)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            this.appendChild(input);
        }
    });
});
