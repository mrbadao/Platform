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
            $this->redirect('site/login');
        }else{
//            $staff_id = Yii::app()->user->getId();
//
//            $staff = Staffs::model()->findByPk($staff_id);
//            if($staff->is_super == 1){
//                $this->redirect("/staffs");
//            }

        }
        $this->render('index');
	}

    public function actionLogin(){
        $this->layout ='login';

        $model = new LoginForm;
        $iserror = false;

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            $data = Helpers::postJsonData('site/login', $model->attributes);

            if (!empty($data['staff_id'])) {
                if(!empty($data['is_super'])){ // admin login
                    $this->Login($model->username, $model->password, $data['staff_id'], $data['token'], $data['site_id']);
                    $this->redirect('/staffs');
                }
                if (!empty($data['token'])) { //cms user login and only have 1 site
                    $this->Login($model->username, $model->password, $data['staff_id'], $data['token'], $data['site_id']);
                    $this->redirect(Yii::app()->user->returnUrl);
                } else { // multiple sites, redirect to choosesite
                    $data['username'] = $model->username;
                    $data['password'] = $model->password;
                    $_SESSION['chooseSite'] = $data;
                    $this->redirect('chooseSite');
                }

            } else {
                $iserror = true;
                $model->addError("username", $data['error']['error_message']);
            }

        }
        // display the login form
        $this->render('login', compact('model', 'iserror'));
    }
}