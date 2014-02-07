<?php

class FilterController extends Controller
{

    public function actionSave()
    {
        $filterForm = new Filter();
        $filterForm->getFilterData();
        $filterForm->saveFilter();
    }

}