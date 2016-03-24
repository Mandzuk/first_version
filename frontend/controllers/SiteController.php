<?php
namespace frontend\controllers;

use Yii;
//use common\models\User;
use app\models\User;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\SignupFbForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Profile;
use app\models\Invitation;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'profile'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    /*[
                        'actions' => ['profile'],
                        'allow' => true,
                        'roles' => ['admin','user'],
                    ],
                    [
                        'actions' => ['updateprofile'],
                        'allow' => true,
                        'roles' => ['admin','user'],
                    ],*/

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'eauth' => [
                // required to disable csrf validation on OpenID requests
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only' => ['login'],
            ],            
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    /*
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } 

        else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    */
    public function actionLogin() {
        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

            try {
                if ($eauth->authenticate()) {
                    //var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;

                    $identity = User::findByEAuth($eauth);
                    Yii::$app->getUser()->login($identity);

                    $eauth->redirect();  

                }
                else {
                    // close popup window and redirect to cancelUrl
                    $eauth->cancel();
                }
            }
            catch (\nodge\eauth\ErrorException $e) {
                // save error to show it later
                Yii::$app->getSession()->setFlash('error', 'EAuthException: '.$e->getMessage());

                // close popup window and redirect to cancelUrl
                //$eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }
        }

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
            //return $this->render('about');
        }
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } 

        else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }

    }


    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }



    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
        /* Edit profile*/
    /*public function actionProfile()
    {
        $model = Profile::findOne(Yii::$app->user->id);

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    public function actionUpdateprofile()
    {
        $model = ($model = Profile::findOne(Yii::$app->user->id)) ? $model : new Profile();

        if($model->load(Yii::$app->request->post()) && $model->validate()):
            if($model->updateProfile($model)):
                Yii::$app->session->setFlash('success', 'Все зашибись');
            else:
                Yii::$app->session->setFlash('erro', 'Все херня, давай сначала');
                Yii::error('Все херня, давай сначала');
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'updateprofile',
            [
                'model' => $model
            ]
        );
    }*/

    /* user`s Invations  */
  /*  public function actionInvitation()
    {
        $model = Invitation::find()->where(['id_user'=>Yii::$app->user->id])->all();

        return $this->render('invitation', [
            'dataProvider' => $model,
        ]);

    }
    public function actionCreateinvitation()
    {
        $model = new Invitation();

        if($model->load(Yii::$app->request->post())):
            if($model->createInvitation($model)):
                Yii::$app->session->setFlash('success', 'Все зашибись');
            else:
                Yii::$app->session->setFlash('erro', 'Все херня, давай сначала');
                Yii::error('Все херня, давай сначала');
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'createinvitation',
            [
                'model' => $model,
            ]
        );

    }

    public function actionUpdateinvitation()
    {
        $model = Invitation::find()->where(['id_user'=> Yii::$app->user->id])->one();

        if($model->load(Yii::$app->request->post()) && $model->validate()):
            if($model->updateInvitation($model)):
                Yii::$app->session->setFlash('success', 'Все зашибись');
            else:
                Yii::$app->session->setFlash('erro', 'Все херня, давай сначала');
                Yii::error('Все херня, давай сначала');
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'updateinvitation',
            [
                'model' => $model,
            ]
        );
    }*/

    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
 
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        } 

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Signs user up.
     *
     */
    public function actionActivatekey($key)
    {
        $get_user = User::find()->where(['auth_key' => $key])->one();
        
        if($get_user){
            $change_status = new User($get_user);
            $change_status->changeStatust();
            $get_user->status = $get_user::STATUS_AUTH;
            $save_user = $get_user->save() ? $get_user : null;
        }
        else{
            
        }

        return $this->goHome();

    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
