<?php

namespace app\models;

use yii\base\Model;

class ReportParametersForm extends Model
{
    public int $year;

    public function rules()
    {
        return [
            [['year'], 'required'],
            [['year'], 'integer'],
        ];
    }

}

