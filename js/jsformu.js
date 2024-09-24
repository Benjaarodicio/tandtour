// Seleccionando todos los elementos requeridos
const start_btn = document.querySelector(".start_btn button");
const info_box = document.querySelector(".info_box");
const exit_btn = info_box.querySelector(".buttons .quit");
const continue_btn = info_box.querySelector(".buttons .restart");
const quiz_box = document.querySelector(".quiz_box");
const result_box = document.querySelector(".result_box");
const option_list = document.querySelector(".option_list");
const next_btn = document.querySelector("footer .next_btn");
const bottom_ques_counter = document.querySelector("footer .total_que");

// Si se hace clic en el botón Iniciar prueba
start_btn.onclick = () => {
    info_box.classList.add("activeInfo"); // Mostrar cuadro de información
}

// Si se hace clic en el botón Salir del cuestionario
exit_btn.onclick = () => {
    info_box.classList.remove("activeInfo"); // Ocultar cuadro de información
}

// Si se hace clic en el botón Continuar prueba
continue_btn.onclick = () => {
    info_box.classList.remove("activeInfo"); // Ocultar cuadro de información
    quiz_box.classList.add("activeQuiz"); // Mostrar cuadro de cuestionario
    showQuestions(0); // Llamar a la función showQuestions
    queCounter(1); // Pasar 1 parámetro a queCounter
}

let que_count = 0;
let que_numb = 1;


const quit_quiz = result_box.querySelector(".buttons .quit");


// Si se hace clic en el botón Salir del cuestionario
quit_quiz.onclick = () => {
    window.location.reload(); // Recargar la ventana actual
}

// Si se hace clic en el botón Next
next_btn.onclick = () => {
    if (que_count < questions.length - 1) { // Si el conteo de preguntas es menor que la longitud total de las preguntas
        que_count++; // Incrementar el valor de que_count
        que_numb++; // Incrementar el valor de que_numb
        showQuestions(que_count); // Llamar a la función showQuestions
        queCounter(que_numb); // Pasar valor que_numb a queCounter
        next_btn.classList.remove("show"); // Ocultar botón siguiente
    } else {
        showResult(); // Llamar a la función showResult
    }
}

// Obtener preguntas y opciones de la matriz
function showQuestions(index) {
    const que_text = document.querySelector(".que_text");
    let que_tag = '<span>' + questions[index].numb + ". " + questions[index].question + '</span>';
    let option_tag = '';

    // Generar HTML para las opciones disponibles
    questions[index].options.forEach((option, i) => {
        option_tag += '<div class="option"><span>' + option + '</span></div>';
    });

    que_text.innerHTML = que_tag; // Mostrar la pregunta actual
    option_list.innerHTML = option_tag; // Mostrar las opciones disponibles

    const options = option_list.querySelectorAll(".option");

    // Eliminar la clase 'selected' de la opción previamente seleccionada
    const selectedOption = option_list.querySelector(".option.selected");
    if (selectedOption) {
        selectedOption.classList.remove("selected");
    }

    // Añadir evento 'click' a todas las opciones disponibles
    options.forEach(option => {
        option.addEventListener("click", () => optionSelected(option));
    });
}
// Si el usuario hizo clic en una opción
function optionSelected(option) {
    // Desmarcar opción previamente seleccionada
    const selectedOption = option_list.querySelector(".option.selected");
    if (selectedOption) {
        selectedOption.classList.remove("selected");
    }

    // Marcar la opción seleccionada actual
    option.classList.add("selected");

    // Mostrar el botón siguiente si no se ha mostrado ya
    if (!next_btn.classList.contains("show")) {
        next_btn.classList.add("show");
    }
}
function showResult() {
    info_box.classList.remove("activeInfo"); // Ocultar cuadro de información
    quiz_box.classList.remove("activeQuiz"); // Ocultar cuadro de cuestionario
    result_box.classList.add("activeResult"); // Mostrar cuadro de resultados
    const scoreText = result_box.querySelector(".score_text");
    let scoreTag = '<span>Has completado el cuestionario</span>';
    scoreText.innerHTML = scoreTag; // Agregar nueva etiqueta span dentro de score_Text
}

function queCounter(index) {
    // Crear una nueva etiqueta span y pasar el número de pregunta y la cantidad total de preguntas
    let totalQueCounTag = '<span><p>' + index + '</p> de <p>' + questions.length + '</p> Preguntas</span>';
    bottom_ques_counter.innerHTML = totalQueCounTag; // Agregar nueva etiqueta span dentro de bottom_ques_counter
}
