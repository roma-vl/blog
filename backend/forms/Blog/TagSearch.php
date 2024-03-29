<?php
/**
 * Created by PhpStorm.
 * User: Roma Volkov
 * Email: Drakyla60@gmail.com
 * Date: 7/27/2018
 * Time: 12:12 PM
 */

namespace backend\forms\Blog;


use core\entities\Blog\Tag;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class TagSearch
 * @package backend\forms\Blog
 */
class TagSearch extends Model
{
    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public  $slug;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name', 'slug'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Tag::find();

        $dataProvider = new ActiveDataProvider([
           'query' => $query,
           'sort' => [
             'defaultOrder' => ['name' => SORT_ASC],
           ],
        ]);

        $this->load($params);

        if (!$this->validate()){
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}







