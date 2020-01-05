<?php

class AdminController
{
    public function addNewQuestion($newQuestionData)
    {
        if (empty($newQuestionData)) {
            // Formulaire vide
            $controller = new HomeController;
            $controller->showAddQuestionPage();

        } else {
            // Enregistrement de la question
            $model = new AdminModel;
            $registerQuestion = $model->addNewQuestion($newQuestionData);

            // Récupération de l'id de la question pour y associer les réponses
            $questionId = $model->questionId($newQuestionData['askQuestion']);

            // Vérification de la bonne réponse
            $answer1;
            $answer2;
            $answer3;
            switch ($newQuestionData['rightAnswer'])
            {
                case 'réponse n°1';
                    $answer1 = "true";
                    $answer2 = "false";
                    $answer3 = "false";
                break;
                case 'réponse n°2';
                    $answer1 = "false";
                    $answer2 = "true";
                    $answer3 = "false";
                break;
                case 'réponse n°3';
                    $answer1 = "false";
                    $answer2 = "false";
                    $answer3 = "true";
                break;
            }

            // Création d'un tableau d'enregistrement pour chaque réponse
            $answer1Array = [
                "answer" => $newQuestionData['answer1'],
                "id" => $questionId[0]['id'],
                "trueOrFalse" => $answer1,
                "themeId" => $newQuestionData['questionTheme'],
            ];
            $answer2Array = [
                "answer" => $newQuestionData['answer2'],
                "id" => $questionId[0]['id'],
                "trueOrFalse" => $answer2,
                "themeId" => $newQuestionData['questionTheme'],
            ];
            $answer3Array = [
                "answer" => $newQuestionData['answer3'],
                "id" => $questionId[0]['id'],
                "trueOrFalse" => $answer3,
                "themeId" => $newQuestionData['questionTheme'],
            ];

            //Enregistrement de chaque réponse en bdd
            $registerAnswer1 = $model->addNewAnswer($answer1Array);
            $registerAnswer2 = $model->addNewAnswer($answer2Array);
            $registerAnswer3 = $model->addNewAnswer($answer3Array);

            // Message de confirmation d'enregistrement de la question pour l'utilisateur 
            $_SESSION['message'] = "Votre question a bien été enregistrée, Si vous avez fait une erreur lors de la saisie de la question vous pouvez toujours la modifier dans l'onglet 'Modifier une question'.";

            $template = 'admin';
            include 'layout.phtml';
        }
    }

    public function addNewTheme($formField)
    {
        if (empty($formField)) {
            // Formulaire vide
            $controller = new HomeController;
            $controller->showAddThemePage();

        } else {
            // Enregistrement du nouveau thème en bdd
            $model = new AdminModel;
            $registerTheme = $model->addNewTheme($formField['themeName']);
            if ($registerTheme == '1')
            {
                $_SESSION['message'] = "Votre thème a bien été enregistré, vous pouvez désormais y ajouter des questions!";

                $themes = $model->showTheme(); //Récupération des thèmes existants

                $template = 'addQuestion';
                include 'layout.phtml';

            } else if($registerTheme == '0') {

                $_SESSION['message'] = "Ce thème éxiste déjà";

                $template = 'addTheme';
                include 'layout.phtml';
            }
        }
    }

    public function showQuestionsByTheme($themeSelected)
    {
        if (empty($themeSelected)) {
            // Formulaire vide
            $controller = new HomeController;
            $controller->showDeleteQuestionPage();

        } else {
            $model = new AdminModel;
            $questions = $model->showQuestionsByTheme($themeSelected['selectQuestionsToDeleteByTheme']);

            $themes = $model->showTheme(); //Récupération des thèmes existants
            
            $template = 'deleteQuestion';
            include 'layout.phtml';
        }
    }

    public function deleteQuestions($questionsId)
    {
        $id = json_decode($questionsId);
        for( $i = 0; $i < count($id); $i++)
        {
            $model = new AdminModel;
            $delete = $model->deleteQuestion($id[$i]);
        }
    }

    public function deleteCategory($categoryToDelete)
    {
        $model = new AdminModel;
        $categoryId = $categoryToDelete['selectCategoryToDelete'];
        $categoryName = $model->showOneTheme($categoryId); // Récupération du nom de la catégorie à supprimer
        $_SESSION['message'] = "la catégorie " . $categoryName['name'] . " et toutes ces questions ont bien été supprimé";
        $delete = $model->deleteCategory($categoryId); //suppression d'une catégorie'

        $themes = $model->showTheme(); //Récupération des thèmes existants

        $template = 'deleteQuestion';
        include 'layout.phtml';
    }

    public function chooseCategoryToEdit($category)
    {
        $model = new AdminModel;
        $categoryId = $category['selectCategoryToEdit'];
        $questions = $model->showQuestionsByTheme($categoryId);
        $themes = $model->showTheme();

        $template = 'editQuestion';
        include 'layout.phtml';
    }

    public function showOneQuestion($questionId)
    {
        if (empty($questionId)) {
            // Formulaire vide
            $controller = new HomeController;
            $controller->showEditQuestionPage();

        } else {
            $model = new AdminModel;
            // Récupération de toutes les données de la question et de son id
            $questionData = $model->QuestionData($questionId);
            $themes = $model->showTheme();
            
            $template = 'editOneQuestion';
            include 'layout.phtml';
        }
    }

    public function editQuestion($formField)
    {
        if (empty($formField)) {
            //formulaire vide
            $_SESSION['message'] = "Veuillez remplir le formulaire";

        } else {
            //Modification de la question
            $model = new AdminModel;
            $registerQuestion = $model->editQuestion($formField);

            // Vérification de la bonne réponse
            $answer1;
            $answer2;
            $answer3;
            switch ($formField['rightAnswer'])
            {
                case 'réponse n°1';
                    $answer1 = "true";
                    $answer2 = "false";
                    $answer3 = "false";
                break;
                case 'réponse n°2';
                    $answer1 = "false";
                    $answer2 = "true";
                    $answer3 = "false";
                break;
                case 'réponse n°3';
                    $answer1 = "false";
                    $answer2 = "false";
                    $answer3 = "true";
                break;
            }

            // Création d'un tableau d'enregistrement pour chaque réponse
            $answer1Array = [
                "answerId" => $formField['answerId1'],
                "answer" => $formField['answer1'],
                "questionId" => $formField['id'],
                "trueOrFalse" => $answer1,
                "themeId" => $formField['questionTheme'],
            ];
            $answer2Array = [
                "answerId" => $formField['answerId2'],
                "answer" => $formField['answer2'],
                "questionId" => $formField['id'],
                "trueOrFalse" => $answer2,
                "themeId" => $formField['questionTheme'],
            ];
            $answer3Array = [
                "answerId" => $formField['answerId3'],
                "answer" => $formField['answer3'],
                "questionId" => $formField['id'],
                "trueOrFalse" => $answer3,
                "themeId" => $formField['questionTheme'],
            ];

            //Modification de chaque réponse en bdd

            $editAnswer1 = $model->editAnswer($answer1Array);
            $editAnswer2 = $model->editAnswer($answer2Array);
            $editAnswer3 = $model->editAnswer($answer3Array);

            //Message pour l'utilisateur
            $_SESSION['message'] = "Votre question a bien été modifié";

            $themes = $model->showTheme();
            $template = 'editQuestion';
            include 'layout.phtml';
        }
    } 
}