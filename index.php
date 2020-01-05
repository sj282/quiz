<?php

session_start();
require 'connection.php';
include 'autoload.php';

$autoload = new Autoload();
$autoload->run();

if (empty($_POST))
{
    //Affichage des questions pour les modifier
    if (array_key_exists('id', $_GET)) {
        $questionId = $_GET['id'];
        $controller = new AdminController;
        $controller->showOneQuestion($questionId);
    
    // S'il n'ya pas de 'page' dans le get redirection vers la page d'accueil
    } else {
        if (array_key_exists('page', $_GET)) {
            $page = $_GET['page'];
        } else {
            $page = 'home';
        }
    
        // Selection des pages à afficher
        switch($page)
        {
            case 'home':
                $controller = new HomeController;
                $controller->showHomePAge();
            break;
            case 'selectCategory':
                $controller = new HomeController;
                $controller->selectCategoryPage();
            break;
            case 'admin':
                $controller = new HomeController;
                $controller->showAdminPage();
            break;
            case 'mix':
                $controller = new HomeController;
                $controller->showMixPage();
            break;
            case 'addQuestion':
                $controller = new HomeController;
                $controller->showAddQuestionPage();
            break;
            case 'deleteQuestion':
                $controller = new HomeController;
                $controller->showDeleteQuestionPage();
            break;
            case 'addTheme':
                $controller = new HomeController;
                $controller->showAddThemePage();
            break;
            case 'editQuestion';
                $controller = new HomeController;
                $controller->showEditQuestionPage();
            break;
            case 'play':
                $controller = new HomeController;
                $controller->showPlayPage($_GET['category']);
            break;
            default :
                $controller = new HomeController;
                $controller->showHomePAge();
        }
    } 
} else {
    $action = $_POST['action'];
    switch ($action)
    {
        case 'addQuestion';
            $controller = new AdminController;
            $controller->addNewQuestion($_POST);
        break;
        case 'addTheme';
            $controller = new AdminController;
            $controller->addNewTheme($_POST);
        break;
        case 'selectQuestionsToDeleteByTheme';
            $controller = new AdminController;
            $controller->showQuestionsByTheme($_POST);
        break;
        case 'deleteQuestions';
            $controller = new AdminController;
            $controller->deleteQuestions($_POST['questionsId']);
        break;
        case 'deleteTheme';
            $controller = new AdminController;
            $controller->deleteCategory($_POST);
        break;
        case 'chooseCategoryToEdit';
            $controller = new AdminController;
            $controller->chooseCategoryToEdit($_POST);
        break;
        case 'editOneQuestion';
            $controller = new AdminController;
            $controller->editQuestion($_POST);
        break;
    }
}