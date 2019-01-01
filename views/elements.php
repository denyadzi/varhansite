<?php

use luya\TagParser;

return [
	'bigHeader' => function(){ return TagParser::convert('page[2]'); },
	'smallHeader' => function(){ return TagParser::convert('page[3]'); },
	'footer' => function(){ return TagParser::convert('page[4]'); },
	];
