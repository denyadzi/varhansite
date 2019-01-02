<?php
/**
 * View file for block: ContentBlock 
 *
 * File has been created with `block/create` command. 
 *
 *
 * @var $this \luya\cms\base\PhpBlockView
 */
use app\assets\blocks\ContentAsset;

ContentAsset::register($this);
?>
<section class="content-block" id="<?=$this->extraValue('section_id')?>">
    <div class="container">
	<h3><?=$this->varValue('title')?></h3>
	<?=$this->placeholderValue('content')?>
    </div>
</section>
