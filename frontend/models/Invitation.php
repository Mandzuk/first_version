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
            [['name', 'email'], 'string'],
            [['sent_date', 'registration_date', 'date_of_last_sign_in'], 'safe'],
            [['id_user'], 'integer'],
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
        ];
    }
}
