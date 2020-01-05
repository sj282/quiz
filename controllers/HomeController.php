<?php

class HomeController
{
    public function showHomePage()
    {
        $template ='home';
        include 'layout.phtml';
    }

    public function selectCategoryPage()
    {
        $model = new AdminModel;
        $themes = $model->showTheme(); //Récupération des thèmes existants
        $template = 'selectCategory';
        include 'layout.phtml';
    }

    public function showAdminPage()
    {
        $template = 'admin';
        include 'layout.phtml';
    }
    
    public function showPlayPage($category)
    {
        $model = new GameModel;
        $questions = $model->questions($category); //tableau qui récupère toute les questions
        $answers = $model->answers($category); //tableau qui récupère toute les réponses
        $theme = $model->themeName($category); // Récuperation du nom de la catégorie
        $nameOfCategory = $theme['name'];

        $template = 'play';
        include 'layout.phtml';
    }

    public function showMixPage()
    {
        $template = 'mix';
        include 'layout.phtml';
    }

    public function showAddQuestionPage()
    {
        $model = new AdminModel;
        $themes = $model->showTheme(); //Récupération des thèmes existants
        $template = 'addQuestion';
        include 'layout.phtml';
    }

    public function showDeleteQuestionPage()
    {
        $model = new AdminModel;
        $themes = $model->showTheme(); //Récupération des thèmes existants
        $template = 'deleteQuestion';
        include 'layout.phtml';
    }

    public function showAddThemePage()
    {
        $template = 'addTheme';
        include 'layout.phtml';
    }

    public function showEditQuestionPage()
    {
        $model = new AdminModel;
        $themes = $model->showTheme(); //Récupération des thèmes existants
        $template = 'editQuestion';
        include 'layout.phtml';
    }
}