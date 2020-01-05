'use strict'

var checkInputAdd = document.getElementById('addQuestion');
var checkInputEdit = document.getElementById('editQuestion');

function onCheck(event)
{
    var question = $('#askQuestion').val();
    var answer1 = $('#choice1').val();
    var answer2 = $('#choice2').val();
    var answer3 = $('#choice3').val();
    var regex = /"|&/;

    if (regex.test(question) === true) {
        event.preventDefault();
        $('#errorQuestion').removeClass('noError');
        $('#errorQuestion').text('les symboles \" et & ne sont pas valides')
    } else {
        $('#errorQuestion').addClass('noError');
    }

    if (regex.test(answer1) === true) {
        event.preventDefault();
        $('#errorAnswer1').removeClass('noError');
        $('#errorAnswer1').text('les symboles \" et & ne sont pas valides')
    } else {
        $('#errorAnswer1').addClass('noError');
    }

    if (regex.test(answer2) === true) {
        event.preventDefault();
        $('#errorAnswer2').removeClass('noError');
        $('#errorAnswer2').text('les symboles \" et & ne sont pas valides')
    } else {
        $('#errorAnswer2').addClass('noError');
    }

    if (regex.test(answer3) === true) {
        event.preventDefault();
        $('#errorAnswer3').removeClass('noError');
        $('#errorAnswer3').text('les symboles \" et & ne sont pas valides')
    } else {
        $('#errorAnswer3').addClass('noError');
    }
}

// CODE PRINCIPAL

if (checkInputAdd === null)
{
    checkInputEdit.addEventListener('click', onCheck);

} else if (checkInputEdit === null)
{
    checkInputAdd.addEventListener('click', onCheck);
};