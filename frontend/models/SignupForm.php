<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $location;
    public $sex;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['location', 'filter', 'filter' => 'trim'],
            ['location', 'required'],
            ['location', 'string', 'min' => 2, 'max' => 255],

            ['sex', 'filter', 'filter' => 'trim'],
            ['sex', 'required'],
            ['sex', 'string', 'min' => 2, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->sex = $this->sex;
        $user->location = $this->location;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $save_user = $user->save() ? $user : null;


        if($save_user){
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('user');
            $auth->assign($userRole, $user->getId());
        }
        
        return $save_user;
    }

    /**
     * Signs user up FB.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signupFB($profile)
    {
        if (!$profile) {
            return null;
        }
        


        $user = new User();
        $user->username = $profile['name'];
        //$user->email = $profile['email'];
        $user->setPassword('1234567u');
        $user->generateAuthKey();

        $save_user = $user->save() ? $user : null;

        if($save_user){
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('user');
            $auth->assign($userRole, $user->getId());
        }
        
        return $save_user;
    }    

}
