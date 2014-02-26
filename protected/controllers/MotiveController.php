<?php

class MotiveController extends Controller
{

    public function beforeAction($action)
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css') . '/admin.css'));
        return parent::beforeAction($action);
    }

    /**
     * @var string the default layout for the views. 
     */
    public $layout = 'admin';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        if (Yii::app()->params['authentication']['required']) {
            return array(
                array('deny',
                    'users' => array('?'),
                ),
            );
        } else {
            return array();
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Motive;

        if (isset($_POST['Motive'])) {
            $model->attributes = $_POST['Motive'];
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Motive'])) {
            $model->attributes = $_POST['Motive'];
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new Motive('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Motive']))
            $model->attributes = $_GET['Motive'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Motive the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Motive::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Motive $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'survey-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
