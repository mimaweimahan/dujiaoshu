<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Lang;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class LangController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Lang(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('icon');
            $grid->column('title');
            $grid->column('code');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Lang(), function (Show $show) {
            $show->field('id');
            $show->field('icon');
            $show->field('title');
            $show->field('code');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Lang(), function (Form $form) {
            $form->display('id');
            $form->text('icon');
            $form->text('title');
            $form->text('code');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
