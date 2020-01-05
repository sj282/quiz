<?php

class AdminModel
{
    public function addNewQuestion(array $newQuestionData)
    //enregistrer la nouvelle question en bdd
    {
        $db = getConnection();

        $query = $db->prepare('INSERT INTO questions(question, theme_id) VALUES (?,?)');
        $query->execute([
            $newQuestionData['askQuestion'],
            $newQuestionData['questionTheme']
        ]);
    }

    public function addNewAnswer(array $answerArray)
    //enregistrer les réponses associées en bdd
    {
        $db = getConnection();

        $query = $db->prepare('INSERT INTO answers(answer, id_question, trueOrFalse, theme_id) VALUES (?,?,?,?)');
        $query->execute([
            $answerArray['answer'],
            $answerArray['id'],
            $answerArray['trueOrFalse'],
            $answerArray['themeId'],
        ]);
    }

    public function questionId($question)
    //récupère l'id de la question à partir de la question
    {
        $db = getConnection();

        $query = $db->prepare('SELECT id
                                FROM questions
                                WHERE question = ?');
        $query->execute([
            $question,
        ]);
        $questionId = $query->fetchAll();

        return $questionId;
    }

    public function addNewTheme($themeName)
    //enregistrer le nouveau thème en bdd
    {
        $db = getConnection();

        //Vérification que le nom du thème n'existe pas déjà
        $query = $db->prepare('SELECT name
                                FROM themes
                                WHERE name = ?');
        $query->execute([
            $themeName,
        ]);
        $checkThemeName = $query->fetch();

        if ($checkThemeName == null)
        //S'il n'existe pas on l'enregistre et on renvoie la réponse '1'
        {
            $query = $db->prepare('INSERT INTO themes(name) VALUES (?)');
            $query->execute([
                $themeName,
            ]);
            
            $register = '1';

        } else {
            //Sinon on renvoie une réponse '0'
            $register = '0';
        }

        return $register;
    }

    public function showTheme()
    //afficher tous les thèmes de la bdd
    {
        $db = getConnection();

        $query = $db->prepare('SELECT *
                                FROM themes');
        $query->execute();

        $showTheme = $query->fetchAll();

        return $showTheme;
    }

    public function showQuestionsByTheme($themeId)
    //Afficher les questions selon la catégorie sélectionnée
    {
        $db = getConnection();

        $query = $db->prepare('SELECT *
                                FROM questions
                                WHERE theme_id = ?
                                ORDER BY question');
        $query->execute([
            $themeId,
        ]);

        $questionsSelected = $query->fetchAll();

        return $questionsSelected;
    }

    public function deleteQuestion($id)
    //suppression des questions selectionnées
    {
        $db = getConnection();

        $query = $db->prepare('DELETE FROM questions
                                WHERE id = ?');
        $query->execute([
            $id,
        ]);
    }

    public function deleteCategory($id)
    //suppression d'une catégorie
    {
        $db = getConnection();

        $query = $db->prepare('DELETE FROM themes
                                WHERE themeId = ?');
        $query->execute([
            $id,
        ]);
    }

    public function showOneTheme($id)
    //Récupération du nom d'un catégorie à partir de l'id
    {
        $db = getConnection();

        $query = $db->prepare('SELECT name
                                FROM themes
                                WHERE themeId = ?');
        $query->execute([
            $id,
        ]);

        $categoryName = $query->fetch();

        return $categoryName;
    }

    public function QuestionData($questionId)
    // Récupération de toutes les données de la question
    {
        $db = getConnection();

        $query = $db->prepare('SELECT question, answers.answer, answers.trueOrFalse,                        themes.name, answers.answer_id
                                FROM questions
                                INNER JOIN answers ON answers.id_question = questions.id
                                INNER JOIN themes ON themes.themeId = questions.theme_id
                                WHERE id = ?');
        $query->execute([
            $questionId,
        ]);

        $questionData = $query->fetchAll();

        return $questionData;
    }

    public function editQuestion($editQuestion)
    //modifier la question en bdd
    {
        $db = getConnection();

        $query = $db->prepare('UPDATE questions
                                SET question = ?, theme_id = ?
                                WHERE id = ?');
        $query->execute([
            $editQuestion['askQuestion'],
            $editQuestion['questionTheme'],
            $editQuestion['id']
        ]);
    }

    public function editAnswer(array $answerArray)
    //modifier les réponses 
    {
        $db = getConnection();

        $query = $db->prepare('UPDATE answers
                                SET answer = ?, trueOrFalse = ?, theme_id = ?
                                WHERE answer_id = ?');
        $query->execute([
            $answerArray['answer'],
            $answerArray['trueOrFalse'],
            $answerArray['themeId'],
            $answerArray['answerId']
        ]);
    }
}