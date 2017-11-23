<?php

namespace app\modules\shortlink\controllers;

use app\modules\shortlink\models\ShortUrl;
use yii\web\Controller;

/**
 * Default controller for the `shortlink` module
 */
class DefaultController extends Controller
{
    public $layout = 'main';

    public function actionCreate()
    {
        return $this->render('index');
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $shortLink = \Yii::$app->request->get('shortLink');
        if (empty($shortLink)) {
            $this->redirect(['default/create']);
            return;
        }

        $model = ShortUrl::findOne(['cod' => $shortLink]);
        if (empty($model)) {
            return $this->render('404');
        } else {
            $this->redirect($model->url);
        }
    }
}
