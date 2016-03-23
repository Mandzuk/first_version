<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use frontend\rbac\OwnerRule;
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные

        //создание роли "админ"
        $admin = $auth->createRole('admin');
        $admin->description = 'Админ';
        $auth->add($admin);
        $auth->assign($admin, 1);
        
        //создание роли "юзер"
        $user = $auth->createRole('user');
        $user->description = 'Юзер';
        $auth->add($user);


        // создание права для "админ"
        $actionAdmin = $auth->createPermission('actionAdmin');
        $actionAdmin->description = 'Права для "админ"';
        $auth->add($actionAdmin);
        $auth->addChild($admin, $actionAdmin);

        //создание права для "юзер"
        $actionUser = $auth->createPermission('actionUser');
        $actionUser->description = 'Права для "юзер"';
        $auth->add($actionUser);
        $auth->addChild($user, $actionUser);

	    
    }
}
