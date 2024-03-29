<?php
/**
 * Created by PhpStorm.
 * User: Roma Volkov
 * Email: Drakyla60@gmail.com
 * Date: 7/16/2018
 * Time: 11:09 AM
 */

namespace core\entities\behaviors;


use core\entities\Blog\Type;
use core\entities\Meta;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class MetaBehavior
 * @package core\entities\behaviors
 */
class MetaBehavior extends Behavior
{
    /**
     * @var string
     */
    public $attribute = 'meta';
    /**
     * @var string
     */
    public $jsonAttribute = 'meta_json';

    /**
     * @return array
     */
    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    /**
     * @param Event $event
     */
    public function onAfterFind(Event $event): void
    {
        $model = $event->sender;
        $meta = Json::decode($model->getAttribute($this->jsonAttribute));
        $model->{$this->attribute} = new Meta(
            ArrayHelper::getValue($meta, 'title'),
            ArrayHelper::getValue($meta, 'description'),
            ArrayHelper::getValue($meta, 'keywords')
        );
    }

    /**
     * @param Event $event
     */
    public function onBeforeSave(Event $event): void
    {
        $model = $event->sender;
        $model->setAttribute($this->jsonAttribute, Json::encode([
            'title' => $model->{$this->attribute}->title,
            'description' => $model->{$this->attribute}->description,
            'keywords' => $model->{$this->attribute}->keywords,
        ]));
    }
}