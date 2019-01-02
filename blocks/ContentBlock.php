<?php

namespace app\blocks;

use Yii;
use luya\Hook;
use luya\helpers\Html;
use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;
use app\views\Constants;

/**
 * Content Block.
 *
 * File has been created with `block/create` command. 
 */
class ContentBlock extends PhpBlock
{
    
    public $isContainer = true;
    
    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    public function init()
    {
        Hook::on(Constants::HOOK_NAVIGATION_INJECT_AFTER_HOME, [$this, 'injectAfterHome']);
        parent::init();
    }
    
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
        return Yii::t('blocks/content', 'name');
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'inbox'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                [
                    'var' => 'title',
                    'label' => Yii::t('blocks/content', 'title_label'),
                    'type' => self::TYPE_TEXT,
                ],
            ],
            'cfgs' => [
                [
                    'var' => 'fragment',
                    'label' => Yii::t('blocks/content', 'fragment_label'),
                    'type' => self::TYPE_TEXT,
                ],
            ],
            'placeholders' => [
                [
                    'var' => 'content',
                    'cols' => 12,
                    'label' => Yii::t('blocks/content', 'content_label'),
                ],
            ],
        ];
    }

    public function extraVars()
    {
        $sectionId = str_replace ('#', '', $this->getCfgValue('fragment', ''));
        return [
            'section_id' => $sectionId,
        ];
    }

    public function injectAfterHome($hook)
    {
        $title = $this->getVarValue('title');
        $fragment = $this->getCfgValue('fragment');
        if ($title && $fragment) {
            $hook[$fragment] = $title;
        }
    }
    
    /**
     * {@inheritDoc} 
     *
    */
    public function admin()
    {
        $title = $this->getVarValue('title', Yii::t('blocks/content', 'no_title'));
        return Html::tag('h5', $title, ['class' => 'mb-3']);
    }
}
