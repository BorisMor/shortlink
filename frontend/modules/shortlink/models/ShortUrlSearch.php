<?php
/**
 * Класс для поиска
 * User: Boris
 * Date: 22.11.2017
 * Time: 22:19
 */

namespace app\modules\shortlink\models;

use yii\data\ActiveDataProvider;
use yii\data\Sort;

class ShortUrlSearch extends ShortUrl{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['url', 'cod'], 'safe'],
        ];
    }

    protected function setSettings(ActiveDataProvider $dp)
    {
        // Варианты сортировки
        $dp->sort = new Sort([
            'defaultOrder' => ['id'=>SORT_DESC],
            'attributes' => [
            'id' => [
                'asc' => ['id' => SORT_ASC],
                'desc' => ['id' => SORT_DESC],
                'default' => SORT_ASC,
                'label' => 'ID',
            ]
        ]]);

        $dp->sort->sortParam = true;

        // сколько записей выводим
        $dp->pagination->page = 0;
        $dp->pagination->pageSize = 20;

        return $dp;
    }

    public function search($params = [])
    {
        $query = ShortUrl::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->setSettings($dataProvider);

        $this->attributes = $params;
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'cod', $this->cod]);

        return $dataProvider;
    }
}