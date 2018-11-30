<?php
namespace App\Controllers;

use App\Models\EvaluationModel;
use App\Base\View;

class EvaluationController
{
    private $evaluationModel;

    /**
    * Creates a new EvaluationsController object
    * and instantiate dependencies.
    */
    public function __construct()
    {
        $this->evaluationModel = new EvaluationModel();
    }

    /**
    * Display a single evaluation. If no week is defined then display
    * the latest one.
    */
    public function index()
    {
        if (isset($_GET['week']))
        {
            $week = $_GET['week'];
            $evaluation = $this->evaluationModel->getEvaluation($week);
        }
        else
        {
            $evaluation = $this->evaluationModel->getLatestEvaluation();
            $week = $evaluation->Week;
        }

        $totalEvaluations = $this->evaluationModel->getTotalEvaluations();
        $pageTitle = 'Evaluations';

        $view = new View('Evaluations/index');
        $view->assign('pageTitle', $pageTitle);
        $view->assign('evaluation', $evaluation);
        $view->assign('totalEvaluations', $totalEvaluations);
        $view->assign('week', $week);
        $view->render();
    }
}
