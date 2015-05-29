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

        $c = new CDbCriteria();
        $c->condition = 'login_id=:loginid';
        $c->params = array(':loginid' => $this->username);
        $administrator = Administrators::model()->find($c);
        if ($administrator === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($administrator->password !== $administrator->hashPassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {

            $this->_id = $administrator->id;
            $this->_name = $administrator->name;

            $this->setState('isAdmin', true);
            $this->setState('isSuperAdmin', $administrator->is_super);
            $this->setState('profileImg', $administrator->profile_image);
            $this->setState('email', $administrator->email);
            $this->setState('joinDate', date('M, Y', strtotime($administrator->created)));
            $this->setState('position', "Administrator");
            $this->username = $administrator->login_id;
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
