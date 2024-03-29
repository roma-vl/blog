<?php
/**
 * Created by PhpStorm.
 * User: Roma Volkov
 * Email: Drakyla60@gmail.com
 * Date: 7/20/2018
 * Time: 4:00 PM
 */

namespace core\forms\manage\Blog\Post;


use core\entities\Blog\Category;
use core\entities\Blog\Type;
use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use yii\helpers\ArrayHelper;

/**
 * @property MetaForm meta
 * @property CategoriesForm categories
 * @property PhotosForm photos
 * @property TagsForm tags
 */
class PostCreateForm extends CompositeForm
{
    /**
     * @var
     */
    public $typeId;
    /**
     * @var
     */
    public $name;

    /**
     * PostCreateForm constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->meta = new MetaForm();
        $this->categories = new CategoriesForm();
        $this->photos = new PhotosForm();
        $this->tags = new TagsForm();
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['typeId', 'name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['typeId'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function typeList(): array
    {
        return ArrayHelper::map(Type::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    protected function internalForms(): array
    {
        return ['meta', 'photos', 'categories', 'tags'];
    }
}