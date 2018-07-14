<?php

namespace App\Admin\Controllers;

use App\City;
use App\Hospital;
use App\SurveyForm;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Input;

class SurveyFormController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(SurveyForm::class, function (Grid $grid) {

//            $grid->id('ID')->sortable();
            $grid->column('hospital_id', 'Bệnh viện')->display(function () {
                return Hospital::find($this->hospital_id) ? Hospital::find($this->hospital_id)->hospital : '';
            });
            $grid->column('city_id', 'Tỉnh thành')->display(function () {
                return City::find($this->city_id) ? City::find($this->city_id)->city : '';
            });

            $grid->ngay_do_HA()->display(function () {
                return date('d-m-Y', strtotime($this->ngay_do_HA));
            })->sortable();;
            $grid->year_of_birth();
            $grid->gender('Giới tính')->display(function () {
                return $this->gender == 1 ? 'Nam' : 'Nữ';
            });;
            $grid->dang_dieu_tri_THA('Đang điều trị THA')->display(function () {
                return $this->dang_dieu_tri_THA == 1 ? 'Có' : 'Không';
            });

            $grid->tieu_duong('Tiểu đường')->display(function () {
                return $this->tieu_duong == 1 ? 'Có' : ($this->tieu_duong == 2 ? 'Không' : 'Không biết');
            });
            $grid->hut_thuoc('Hút thuốc')->display(function () {
                return $this->hut_thuoc == 1 ? 'Có' : 'Không';
            });
            $grid->chung_toc('Chủng tộc')->display(function () {
                switch ($this->chung_toc) {
                    case 1:
                        return 'Da đen';
                        break;
                    case 2:
                        return 'Da trắng';
                        break;
                    case 3:
                        return 'Châu Á';
                        break;
                    case 4:
                        return 'Lai';
                        break;
                    case 5:
                        return 'Đông Á';
                        break;
                    case 6:
                        return 'Hispanic (Mỹ)';
                        break;
                    case 7:
                        return 'Ả Rập';
                        break;
                    case 8:
                        return 'Khác';
                        break;
                    default:
                        return '';
                }
            });

            $grid->SBP_lan_1('SBP 1');
            $grid->DBP_lan_1('DBP 1');
            $grid->TS_lan_1('TS 1');
            $grid->SBP_lan_2('SBP 2');
            $grid->DBP_lan_2('DBP 2');
            $grid->TS_lan_2('TS 2');

            $grid->tay_do_huyet_ap('Tay đo HA')->display(function () {
                return $this->tay_do_huyet_ap == 1 ? 'Phải' : 'Trái';
            });
            $grid->dau_tim('Đau tim')->display(function () {
                return $this->dau_tim == 1 ? 'Có' : 'Không';
            });
            $grid->dot_quy('Đột quỵ')->display(function () {
                return $this->dot_quy == 1 ? 'Có' : 'Không';
            });
            $grid->mang_thai('Mang thai')->display(function () {
                return $this->mang_thai == 1 ? 'Có' : 'Không';
            });

            $grid->can_nang('Cân nặng');
            $grid->chieu_cao('Chiều cao');
            $grid->con('Cồn')->display(function () {
                return $this->tieu_duong == 1 ? 'Không bao giờ | hiếm' : ($this->tieu_duong == 2 ? 'Ít hơn 1 lần/tuần' : 'Thường xuyên');
            });

            $grid->disableRowSelector();
            $grid->disableFilter();
            $grid->actions(function ($a) {
                $a->disableDelete();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(SurveyForm::class, function (Form $form) {

            $form->display('id', 'ID');


            $form->select('hospital_id', 'Bệnh viện')->options(function ($id) {
                $hospital = Hospital::find($id);

                if ($hospital) {
                    return [$hospital->id => $hospital->hospital];
                }
            })->ajax('/admin/api/hospitals');

            $form->select('city_id', 'Tỉnh thành')->options(function ($id) {
                $city = City::find($id);

                if ($city) {
                    return [$city->id => $city->city];
                }
            })->ajax('/admin/api/cities');

            $form->date('ngay_do_HA', 'Ngày đo Huyết Áp');
            $form->text('year_of_birth', 'Năm sinh')->rules('integer|between:1900,2018', [
                'integer' => 'Năm sinh phải là số',
                'between' => 'Năm sinh hợp lệ chỉ từ năm 1900 đến 2018',
            ]);

            $genders = [
                'on' => ['value' => 1, 'text' => 'Nam', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'Nữ', 'color' => 'danger'],
            ];
            $yesNo = [
                'on' => ['value' => 1, 'text' => 'Có', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'Không', 'color' => 'danger'],
            ];
            $leftRight = [
                'on' => ['value' => 1, 'text' => 'Phải', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'Trái', 'color' => 'danger'],
            ];

            $yesNoUnknow = [1 => 'Có', 2 => 'Không', 3 => 'Không biết'];
            $chungToc = [
                1 => 'Da đen'
                , 2 => 'Da trắng'
                , 3 => 'Châu Á'
                , 4 => 'Lai'
                , 5 => 'Đông Á'
                , 6 => 'Hispanic (Mỹ)'
                , 7 => 'Ả Rập'
                , 8 => 'Khác'
            ];
            //da den | da trang | chau a | lai | dong a | hispanic | a rap | khac

            $thucUongChuaCon = [
                1 => 'Không bao giờ | hiếm'
                , 2 => 'Ít hơn 1 lần/tuần'
                , 3 => 'Thường xuyên'
            ];
            // khong bao gio hiem | it hon 1 lan / tuan | thuong xuyen

            $form->switch('gender', 'Giới tính')->states($genders);
            $form->switch('dang_dieu_tri_THA', 'Đang điều trị Tăng Huyết Áp?')->states($yesNo);
            $form->select('tieu_duong', 'Có đang bị tiểu đường?')->options($yesNoUnknow);
            $form->switch('hut_thuoc', 'Có hút thuốc?')->states($yesNo);

            $form->select('chung_toc', 'Chủng tộc?')->options($chungToc);

            $form->text('SBP_lan_1', 'SBP lần 1')->rules('integer');
            $form->text('DBP_lan_1', 'DBP lần 1')->rules('integer');
            $form->text('TS_lan_1', 'TS lần 1')->rules('integer');

            $form->text('SBP_lan_2', 'SBP lần 2')->rules('integer');
            $form->text('DBP_lan_2', 'DBP lần 2')->rules('integer');
            $form->text('TS_lan_2', 'TS lần 2')->rules('integer');

            $form->switch('tay_do_huyet_ap', 'Tay đo huyết áp?')->states($leftRight);
            $form->switch('dau_tim', 'Đau tim?')->states($yesNo);
            $form->switch('dot_quy', 'Đột quỵ?')->states($yesNo);
            $form->switch('mang_thai', 'Đang mgan thai?')->states($yesNo);
            $form->text('can_nang', 'Cân nặng')->rules('integer');
            $form->text('chieu_cao', 'Chiều cao')->rules('integer');
            $form->select('con', 'Uống thức uống chứa cồn?')->options($thucUongChuaCon);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
            $form->saving(function (Form $form) {
//                dd($form);
            });
            $form->saved(function () {
                return redirect('/admin/survey/create');
            });
        });
    }
}
