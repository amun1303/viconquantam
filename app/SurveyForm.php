<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyForm extends Model
{
    protected $connection = 'mysql';

    protected $table = 'survey_forms';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'hospital_id',
        'city_id',
        'ngay_do_HA',
        'year_of_birth',
        'gender',
        'dang_dieu_tri_THA',
        'tieu_duong', // co | ko | ko biet
        'hut_thuoc',
        'chung_toc', // da den | da trang | chau a | lai | dong a | hispanic | a rap | khac
        'SBP_lan_1',
        'SBP_lan_2',
        'DBP_lan_1',
        'DBP_lan_2',
        'TS_lan_1',
        'TS_lan_2',
        'tay_do_huyet_ap', // trai | phai
        'dau_tim',
        'dot_quy',
        'mang_thai',
        'can_nang',
        'chieu_cao',
        'con', // khong bao gio hiem | it hon 1 lan / tuan | thuong xuyen
    ];
    protected $guarded = [];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
