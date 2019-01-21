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
 * Social Links Block.
 *
 * File has been created with `block/create` command. 
 */
class SocialLinksBlock extends PhpBlock
{
    const ICONS_BASE_URL = '/icons/social-links';
    
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
        parent::init();
        Hook::on(Constants::HOOK_SOCIAL_LINKS, function($hook) {
            foreach ($this->getExtraValue('escaped_links') as $link) {
                $hook[$link['icon']] = $link['link'];
            }
        });
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
        return Yii::t('blocks/social-links', 'name');
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'people_outline'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                [
                    'var' => 'links',
                    'label' => Yii::t('blocks/social-links', 'label_links'),
                    'type' => self::TYPE_MULTIPLE_INPUTS,
                    'options' => [
                        [
                            'var' => 'icon',
                            'label' => Yii::t('blocks/social-links', 'label_icon'),
                            'type' => self::TYPE_SELECT,
                            'options' => [
                                [ 'value' => self::ICONS_BASE_URL . '/vk.svg', 'label' => 'VKontakte' ],
                                [ 'value' => self::ICONS_BASE_URL . '/fb.svg', 'label' => 'Facebook' ],
                                [ 'value' => self::ICONS_BASE_URL . '/inst.svg', 'label' => 'Instagram' ],
                            ],
                        ],
                        [
                            'var' => 'link',
                            'label' => Yii::t('blocks/social-links', 'label_link'),
                            'type' => self::TYPE_TEXT,
                        ],
                    ],
                ],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'escaped_links' => $this->getEscapedLinks(),
        ];
    }

    private function getEscapedLinks()
    {
        $links = $this->getVarValue('links', []);
        foreach ($links as &$link) {
            $link['link'] = $this->getEscapedUrl($link['link']);
        }
        return $links;
    }


    private function getEscapedUrl($value)
    {
        if (empty ($value)) return '';
        
        $l = parse_url ($value);
        $scheme = $l['scheme'] ?? 'http';
        $host   = $l['host'] ?? '';
        $path   = $l['path'] ?? '';
        return "{$scheme}://{$host}{$path}";
    }

    
    /**
     * {@inheritDoc} 
     *
    */
    public function admin()
    {
        $content = Html::tag('h5', $this->name(), ['class' => 'mb-3']);

        $links = $this->getEscapedLinks();
        $linksHtml = '';
        $empty = true;
        foreach ($links as $link) {
            if (empty ($link['link'])) continue;

            $empty = false;
            $imgHtml = Html::img($link['icon'], ['style' => 'max-width:100px']);
            $linksHtml .= Html::tag('div', $imgHtml, ['class' => 'col col-12 col-sm-4', 'style' => 'text-align:center']);
        }
        if ($empty) {
            $linksHtml = Yii::t('blocks/social-links', 'empty');
        }
        $row = Html::tag('div', $linksHtml, ['class' => 'row']);
        $content .= Html::tag('div', $row, ['class' => 'container']);
        return $content;
    }
}
