<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function surveyForms()
    {
        return $this->hasMany(SurveyForm::class);
    }
}
