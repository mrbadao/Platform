<?php

class SiteController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        if (Yii::app()->user->IsGuest) {
            $this->forward('login');
        }else{

        }
        $this->render('index');
	}

    public function actionLogin(){
        if (!Yii::app()->user->IsGuest) {
            $this->redirect('index');
        }

        $model = new LoginForm;

        //Reject  ajax request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];

            if ($model->validate() && $model->login()) {
                $this->forward('index');
            }
            var_dump(CHtml::error($model, 'username', array('class' => 'txtWarning'))); die;

        }

        // display the login form
        $this->layout ='login';
        $this->render('login', compact('model'));
    }

    public function actionError(){
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}