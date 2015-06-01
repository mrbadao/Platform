<?php

/**
 * Class SiteController
 * @action: index, login, logout, error
 */
class MemberController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionLogin()
    {
        $indexUrl = $this->createUrl('member/index');
        //Check logined
        if (!Yii::app()->user->IsGuest) {
            $this->redirect($indexUrl);
        }

        $model = new LoginForm;

        //Reject  ajax request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $hasError = false;

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $_POST['LoginForm']['rememberMe'] = $_POST['LoginForm']['rememberMe'] == 'on' ? true : false;
            $model->attributes = $_POST['LoginForm'];
            $model->role = $_POST['LoginForm']['role'];

            if ($model->validate() && $model->login()) {
                $this->redirect($indexUrl);
            }

            $hasError = true;
            $errorMessage = $model->getError('username') ? $model->getError('username') : $model->getError('password');
        }

        // display the login form
        $this->layout = 'login';
        $this->render('login', compact('model', 'hasError', 'errorMessage'));
    }

    public function actionError()
    {
        var_dump(Yii::app()->errorHandler->error); die;
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else

                $this->render($error['code'], $error);
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