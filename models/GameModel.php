<?php

class GameModel
{
    public function questions($category)
    // récupération des questions selon la catégorie
    {
        $db = getConnection();

        $query = $db->prepare('SELECT *
                                FROM questions
                                WHERE theme_id = ?');
        $query->execute([
            $category,
        ]);
        $questions = $query->fetchAll();

        return $questions;
    }

    public function answers($category)
    //Récupération des réponses selon la catégorie
    {
        $db = getConnection();

        $query = $db->prepare('SELECT *
                                FROM answers
                                WHERE theme_id = ?');
        $query->execute([
            $category,
        ]);
        $answers = $query->fetchAll();

        return $answers;
    }

    public function themeName($category)
    //Récupération du nom de la catégorie
    {
        $db = getConnection();

        $query = $db->prepare('SELECT name
                                FROM themes
                                WHERE themeId = ?');
        $query->execute([
            $category,
        ]);
        $themeName = $query->fetch();

        return $themeName;
    }
}