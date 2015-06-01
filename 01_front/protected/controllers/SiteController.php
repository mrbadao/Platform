<?php

/**
 * Class SiteController
 * @action: index, login, logout, error
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        $redirectUrl = '';
        if(Yii::app()->user->isGuest)
            $redirectUrl = $this->createUrl('member/login');
        elseif(Yii::app()->user->isAdmin)
             $redirectUrl = $this->createUrl('admin/index');
        else $redirectUrl = $this->createUrl('member/index');
        $this->redirect($redirectUrl);
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



}