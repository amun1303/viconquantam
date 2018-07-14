<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hospital_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->timestamp('ngay_do_HA')->nullable();
            $table->integer('year_of_birth')->nullable();
            $table->smallInteger('gender')->nullable();
            $table->smallInteger('dang_dieu_tri_THA')->nullable();
            $table->integer('tieu_duong')->nullable(); // co | ko | ko biet
            $table->integer('hut_thuoc')->nullable();
            $table->integer('chung_toc')->nullable(); // da den | da trang | chau a | lai | dong a | hispanic | a rap | khac
            $table->integer('SBP_lan_1')->nullable();
            $table->integer('SBP_lan_2')->nullable();
            $table->integer('DBP_lan_1')->nullable();
            $table->integer('DBP_lan_2')->nullable();
            $table->integer('TS_lan_1')->nullable();
            $table->integer('TS_lan_2')->nullable();
            $table->integer('tay_do_huyet_ap')->nullable(); // trai | phai
            $table->integer('dau_tim')->nullable();
            $table->integer('dot_quy')->nullable();
            $table->integer('mang_thai')->nullable();
            $table->integer('can_nang')->nullable();
            $table->integer('chieu_cao')->nullable();
            $table->integer('con')->nullable(); // khong bao gio hiem | it hon 1 lan / tuan | thuong xuyen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_forms');
    }
}
