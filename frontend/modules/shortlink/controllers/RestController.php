<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 22.11.2017
 * Time: 16:19
 */

namespace app\modules\shortlink\controllers;

use app\modules\shortlink\models\ShortUrl;
use app\modules\shortlink\models\ShortUrlSearch;
use yii\data\Sort;
use yii\debug\models\timeline\DataProvider;
use yii\helpers\Json;
use yii\web\Controller;

class RestController extends Controller{

    public function init()
    {
        parent::init();
        $this->enableCsrfValidation = false;
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
    }

    /**
     * Шаблон ответа
     * @param $data
     * @param bool $success
     * @return array
     */
    public static function getAnswer($data, $success = true)
    {
        return [
            'success' => $success,
            'data' => $data
        ];
    }

    /**
     * Добавление ссылки
     * @return array
     */
    public function actionAddLink()
    {
        $params = Json::decode(\Yii::$app->request->getRawBody());

        $model = new ShortUrl();
        $model->attributes = $params;
        $model->cod = '';

        if ($model->save()) {
            return self::getAnswer($model);
        } else {
            return self::getAnswer($model->getErrors(), false);
        }
    }

    public function actionDeleteLink($id)
    {
        $result = self::findModel($id)->delete();
        return self::getAnswer(['delete' => $id], $result);
    }

    public function actionUpdateLink($id)
    {
        $model = self::findModel($id);

        $params = Json::decode(\Yii::$app->request->getRawBody());
        $model->attributes = $params;

        if ($model->save()) {
            return self::getAnswer($model);
        } else {
            return self::getAnswer($model->getErrors(), false);
        }
    }

    /**
     * Получить список записей
     * @return array
     */
    public function actionListLink()
    {
        $params = \Yii::$app->request->get();
        /** @var DataProvider $dp */
        $dp = (new ShortUrlSearch())->search($params);
        $models = $dp->getModels();
        return self::getAnswer($models);
    }

    protected function findModel($id)
    {
        if (($model = ShortUrl::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \Exception('Запись не найдена');
        }
    }
}