<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private  $_id;
    private  $_name;
    private  $_logoutUrl;
    public $role;

    public function __construct($username,$password, $role)
    {
        $this->username=$username;
        $this->role=$role;
        $this->password=$password;
    }
    /**
    * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $staff = null;

        $c = new CDbCriteria();
        $c->condition = 'login_id=:loginid';
        $c->params = array(':loginid' => $this->username);

        if($this->role =='1'){
            $staff = Administrators::model()->find($c);
            $this->_logoutUrl = Yii::app()->createUrl('admin/logout');
        }else{
            $staff = Staff::model()->find($c);
            $this->_logoutUrl = Yii::app()->createUrl('member/logout');
        }

        if ($staff === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($staff->password !== $staff->hashPassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id = $staff->id;
            $this->_name = $staff->name;
            $this->setState('isAdmin', $this->role);
            $this->setState('isSuperAdmin', $this->role == '1' ? $staff->is_super : 0);
            $this->setState('profileImg', $staff->profile_image);
            $this->setState('joinDate', date('M, Y', strtotime($staff->created)));
            $this->setState('position', $this->role == '1' ? 'Administrator' : 'Member');
            $this->setState('logoutUrl', $this->_logoutUrl);
            $this->errorCode = self::ERROR_NONE;
        }

         return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getName(){
        return $this->_name;
    }
}
