<?php

namespace app\controllers;

use app\models\ReportParametersForm;
use app\reports\Top10PublishedAuthorsReport;

class ReportController extends \yii\web\Controller
{
    /**
     * @return int[]
     */
    protected function getYears(): array
    {
        $endYear = + date('Y');
        $startYear = $endYear - 5;
        $result = [];
        for ($year = $endYear; $year >= $startYear; $year--) {
            $result[$year] =  $year;
        }
        return  $result;
    }

    public function actionTop10PublishedAuthors(): string
    {
        $model = new ReportParametersForm();
        $model->year = (int) date('Y');
        $show = false;

        $report = new Top10PublishedAuthorsReport();
        $result = null;

        if ($this->request->isPost &&  $model->load($this->request->post())) {
            $report->setParam('year', $model->year);
            $result = $report->run();
            $show = true;
        }

        return $this->render('top10-published-authors', [
            'years' => $this->getYears(),
            'model' => $model,
            'show' => $show,
            'result' => $result,
        ]);
    }

}
