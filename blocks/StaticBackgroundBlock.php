<?php

namespace app\blocks;

use Yii;
use luya\helpers\Html;
use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;

/**
 * Static Background Block.
 *
 * File has been created with `block/create` command. 
 */
class StaticBackgroundBlock extends PhpBlock
{
    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    /**
     * @inheritDoc
     */
    public function blockGroup()
    {
        return ProjectGroup::class;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return Yii::t('blocks/static-background', 'name');
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'image'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                [
                    'var' => 'image',
                    'label' => Yii::t('blocks/static-background', 'image_label'),
                    'type' => self::TYPE_IMAGEUPLOAD,
                ],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'background_url' => $this->getImageUrl(),
        ];
    }

    public function getImageUrl($hook = null)
    {
        $selected = $this->getVarValue('image');
        if ( ! $selected) return '';

        $image = Yii::$app->storage->getImage($selected);
        return $image->source;
    }
    
    /**
     * {@inheritDoc} 
     *
    */
    public function admin()
    {
        $selected = $this->getVarValue('image');
        $content = '';
        if ($selected) {
            $image = Yii::$app->storage->getImage($selected);
            $content = Html::tag('div', '', [
                'style' => [
                    'background-image' => "url({$image->source})",
                    'background-size' => 'cover',
                    'height' => '300px',
                ]]);
        } else {
            $content = Yii::t('blocks/header-background', 'empty');
        }
        return Html::tag('h5', $this->name(), ['class' => 'mb-3']) . $content;
    }
}
