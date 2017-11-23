<?php

namespace app\modules\shortlink\models;

/**
 * This is the ActiveQuery class for [[ShortUrl]].
 *
 * @see ShortUrl
 */
class ShortUrlQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ShortUrl[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShortUrl|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
