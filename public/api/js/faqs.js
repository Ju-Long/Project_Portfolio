$(document).ready(() => {
    const displayquestions = () => {
        var msg = "";
        questions.forEach(i => {
            msg += `<div class="question-container" id="${i.id}"><div class="question-header">`;
            msg += `<span>${i.question}</span><i class="fa-duotone fa-plus"></i></div>`;
            msg += `<div class="question-answer">${i.answer}</div></div>`;
        });
        $(".list-of-questions").html(msg);}
    displayquestions();
    $(".question-container").hover((e) => {
            $(`#${e.target.id} .question-header i`).removeClass("fa-plus");
            $(`#${e.target.id} .question-header i`).addClass("fa-minus");
        }, (e) => {
            $(`#${e.target.id} .question-header i`).removeClass("fa-minus");
            $(`#${e.target.id} .question-header i`).addClass("fa-plus");
        }
    );
});

const questions = [{
    id: 1,
    question: "how long is the data kept?",
    answer: "the data kept will only have a life span of 3 month from the time u last called it."
}, {
    id: 2,
    question: "do i (website creator) earn anything other than donations?",
    answer: "no. i do not plan to put ads on this website or earn from other 3rd party company."
}];