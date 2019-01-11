<?php

namespace app\blocks;

use Yii;
use luya\helpers\Html;
use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;

/**
 * Media Block.
 *
 * File has been created with `block/create` command. 
 */
class MediaBlock extends PhpBlock
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
        return Yii::t('blocks/media', 'name');
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'music_video'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                [
                    'var' => 'sc_playlist',
                    'label' => Yii::t('blocks/media', 'label_sc_playlist'),
                    'type' => self::TYPE_TEXTAREA,
                ],
                [
                    'var' => 'sc_link',
                    'label' => Yii::t('blocks/media', 'label_sc_link'),
                    'type' => self::TYPE_TEXT,
                ],
                [
                    'var' => 'youtube_video',
                    'label' => Yii::t('blocks/media', 'label_youtube_video'),
                    'type' => self::TYPE_TEXTAREA,
                ],
                [
                    'var' => 'youtube_link',
                    'label' => Yii::t('blocks/media', 'label_youtube_link'),
                    'type' => self::TYPE_TEXT,
                ],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'sc_frame_escaped' => $this->frameSize($this->getEscapedHtml('sc_playlist')),
            'youtube_frame_escaped' => $this->frameSize($this->getEscapedHtml('youtube_video')),
            'sc_url_escaped' => $this->getEscapedUrl('sc_link'),
            'youtube_url_escaped' => $this->getEscapedUrl('youtube_link'),
        ];
    }
    private function frameSize($html)
    {
        return preg_replace (['/width=".+"/U', '/height=".+"/U'], ['width="100%"', 'height="300"'], $html);
    }

    private function getEscapedHtml($var)
    {
        $value = $this->getVarValue($var, '');
        return preg_replace (['|<script>.*</script>|', '|on.+=".+"|U'], '', $value);
    }

    private function getEscapedUrl($var)
    {
        $value = $this->getVarValue($var, '');
        $l = parse_url ($value);
        return "{$l['scheme']}://{$l['host']}{$l['path']}";
    }
    
    /**
     * {@inheritDoc} 
     *
    */
    public function admin()
    {
        $content = Html::tag('h5', $this->name(), ['class' => 'mb-3']);
        $sc = $this->getVarValue('sc_playlist');
        $yt = $this->getVarValue('youtube_video');
        $items = [];
        if ($sc) {
            $item = 'Soundcloud';
            if ($this->getVarValue('sc_link')) {
                $item .= ' (' . Yii::t('blocks/media', 'with_link') . ')';
            }
            $items[] = $item;
        }
        if ($yt) {
            $item = 'Youtube';
            if ($this->getVarValue('youtube_link')) {
                $item .= ' (' . Yii::t('blocks/media', 'with_link') . ')';
            }
            $items[] = $item;
        }
        if (empty ($items)) {
            $content .= Html::tag('p', Yii::t('blocks/media', 'empty'));
        } else {
            $content .= Html::ul($items);
        }
        return $content;
    }
}
