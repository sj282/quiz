'use strict'

function onDeleteQuestion(event)
{
    event.preventDefault();
    var check = confirm('Etes vous certain de vouloir supprimer la/les question(s) selectionnée(s) ?'); //Demande de confirmation avant suppression

    if(check == true) // si la réponse est oui on lance le script
    {
        var questionSelected = $('input[type="checkbox"]:checked');
        var totalQuestionSelected = [];
        for(var i = 0; i < questionSelected.length; i++)
        {
            totalQuestionSelected.push(questionSelected[i].value);
        }
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                questionsId : JSON.stringify(totalQuestionSelected),
                action : "deleteQuestions"
            },
        });
        questionSelected.parentsUntil('tbody').remove();

    } else { //sinon on le stop
        return;
    }
    
}

// CODE PRINCIPAL

$(function () {
    $('#btnDelete').on('click', onDeleteQuestion);
})