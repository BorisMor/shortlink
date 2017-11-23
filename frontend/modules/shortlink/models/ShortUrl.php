<?php

namespace app\modules\shortlink\models;

use Yii;

/**
 * This is the model class for table "short_url".
 *
 * @property integer $id
 * @property string $url
 * @property string $cod
 * @property string $md5
 */
class ShortUrl extends \yii\db\ActiveRecord
{
    protected static $chars = "abcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ123456789";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'short_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['url'], 'validateUrl'],
            [['cod'], 'required', 'on' => 'update'],
            [['url'], 'string', 'max' => 2048],
            [['cod'], 'string', 'max' => 20],
            [['cod'], 'unique'],
        ];
    }

    public function validateUrl($attribute, $params)
    {
        if (empty($this->url)) {
            return;
        }

        $md5 = self::getMd5Url($this->url);
        $checkModel = self::findOne(['md5' => $md5]);
        if (!empty($checkModel) && $checkModel->id !== $this->id) {
            $this->addError('url', 'Уже есть данная ссылка');
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Длинная ссылка',
            'cod' => 'Код',
        ];
    }

    /**
     * https://www.sitepoint.com/building-your-own-url-shortener/
     * @param $id
     * @return string
     * @throws \Exception
     */
    protected function convertIntToShortCode($id) {
        $id = intval($id);
        if ($id < 1) {
            throw new \Exception("The ID is not a valid integer");
        }

        $length = strlen(self::$chars);
        // make sure length of available characters is at
        // least a reasonable minimum - there should be at
        // least 10 characters
        if ($length < 10) {
            throw new Exception("Length of chars is too small");
        }

        $code = "";
        while ($id > $length - 1) {
            // determine the value of the next higher character
            // in the short code should be and prepend
            $code = self::$chars[fmod($id, $length)] .
                $code;
            // reset $id to remaining value to be converted
            $id = floor($id / $length);
        }

        // remaining value of $id is less than the length of
        // self::$chars
        $code = self::$chars[$id] . $code;

        return $code;
    }

    public static function getMd5Url($url)
    {
      return md5(mb_strtolower(trim($url)));
    }

    public function beforeSave($insert)
    {
        $this->md5 = self::getMd5Url($this->url); // используется для уникальности т.к. поле url слишком большое для индекса
        return parent::beforeSave($insert);
    }

    protected function getShortCod()
    {
        $sole = rand(100,999);
        return $sole . $this->convertIntToShortCode($this->id);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (empty($this->cod)) {
            $this->cod = $this->getShortCod();
            $this->scenario = 'update';
            $this->update();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     * @return ShortUrlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShortUrlQuery(get_called_class());
    }
}
