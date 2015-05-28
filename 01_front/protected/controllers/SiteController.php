<?php

class SiteController extends Controller
{
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionLogin()
    {
        //Check logined
        if (!Yii::app()->user->IsGuest) {
            $this->redirect('index');
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
            $model->attributes = $_POST['LoginForm'];

            if ($model->validate() && $model->login()) {
                $this->forward('index');
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

    public function actionTest()
    {
        if (stristr(PHP_OS, 'win')) {

            $wmi = new COM("Winmgmts://");
            $server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");

            $cpu_num = 0;
            $load_total = 0;

            foreach($server as $cpu){
                $cpu_num++;
                $load_total += $cpu->loadpercentage;
            }

            $load = (doubleval($load_total/$cpu_num));

        } else {

            $sys_load = sys_getloadavg();
            $load = $sys_load[0];

        }

        $memory_last_line = exec('free',$memory);
//        $memory[1] = str_replace("     ", "-",$memory[1]);
//        $parts = explode(" ",$memory[1]);
//        $parts2 = explode("-",$parts[3]);
//        $mem_percent = $parts2[1] / $parts2[0] * 100;
//        $mem_percent = round($mem_percent);

        echo  $memory_last_line;
    }







}