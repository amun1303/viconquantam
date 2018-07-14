<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    public function surveyForms()
    {
        return $this->hasMany(SurveyForm::class);
    }


}
