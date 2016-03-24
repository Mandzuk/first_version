<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invitation".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $sent_date
 * @property string $registration_date
 * @property string $date_of_last_sign_in
 * @property string $status
 * @property integer $id_user
 */
class Invitation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invitation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'auth_key'], 'string'],
            [['sent_date', 'registration_date', 'date_of_last_sign_in'], 'safe'],
            [['id_user','status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'sent_date' => 'Sent Date',
            'registration_date' => 'Registration Date',
            'date_of_last_sign_in' => 'Date Of Last Sign In',
            'status' => 'Status',
            'id_user' => 'Id User',
            'auth_key' => 'Auth key'
        ];
    }
    
    public function createInvitation()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $invitation = new Invitation();
        $invitation->name = $this->name;
        $invitation->email = $this->email;
        $today = date("Y-m-d");
        $invitation->registration_date = $today;
        $invitation->status = $this->status;
        $invitation->id_user = $this->id_user;
        $invitation->auth_key = sha1(mt_rand(10000, 99999).time());

        $save_invitation = $invitation->save() ? $invitation : null;

        $this->sendEmail($this->email);
        
        return $save_invitation;
    }
    public function editstatusInvitation($status){
        $change = Invitation::find()->where(['email' => $status->email])->one();
        $change->status = 3;
        return $change->save() ? true : false;
    }


    public function sendEmail($email)
    {
        /* @var $user User */
        $invitation = Invitation::findOne([
            'email' => $email,
        ]);

        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom('robot@test.my')
            ->setSubject('регистрация на test.my')
            ->setTextBody('Вас приглашают зарегестрироваться: http://test.my/index.php?r=site/index&key='.$invitation->auth_key )
            ->send();
    }
}
