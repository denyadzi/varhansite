<?php

use yii\helpers\ArrayHelper;

$config = [
    /*
     * For best interoperability it is recommend to use only alphanumeric characters when specifying an application ID.
     */
    'id' => 'varhan',
    /*
     * The name of your site, will be display on the login screen
     */
    'siteTitle' => 'Varhan Folk-band From Polack',
    /*
     * Let the application know which module should be executed by default (if no url is set). This module must be included
     * in the modules section. In the most cases you are using the cms as default handler for your website. But the concept
     * of LUYA is also that you can use a website without the CMS module!
     */
    'defaultRoute' => 'cms',
    /*
     * Define the basePath of the project (Yii Configration Setup)
     */
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerMap' => [
        'fb-albums' => 'app\commands\FbAlbumsController',
    ],
    'modules' => [
        /*
         * If you have other admin modules (e.g. cmsadmin) then you going to need the admin. The Admin module provides
         * a lot of functionality, like storage, user, permission, crud, etc. But the basic concept of LUYA is also that you can use LUYA without the
         * admin module.
         *
         * @secureLogin: (boolean) This will activate a two-way authentication method where u get a token sent by mail, for this feature
         * you have to make sure the mail component is configured correctly. You can test this with console command `./vendor/bin/luya health/mailer`.
         */
        'admin' => [
            'class' => 'luya\admin\Module',
            'secureLogin' => false, // when enabling secure login, the mail component must be proper configured otherwise the auth token mail will not send.
            'strongPasswordPolicy' => false, // If enabled, the admin user passwords require strength input with special chars, lower, upper, digits and numbers
            'interfaceLanguage' => 'en', // Admin interface default language. Currently supported: en, de, ru, es, fr, ua, it, el, vi, pt, fa
        ],
        /*
         * Frontend module for the `cms` module.
         */
        'cms' => [
            'class' => 'luya\cms\frontend\Module',
            'contentCompression' => true, // compressing the cms output (removing white spaces and newlines)
        ],
        /*
         * Admin module for the `cms` module.
         */
        'cmsadmin' => [
            'class' => 'luya\cms\admin\Module',
            'hiddenBlocks' => [],
            'blockVariations' => [
                \luya\generic\blocks\TitleBlock::variations()
                ->add('sitesubtitlebig', 'Subtitle Big')
                ->vars(['headingType' => 'h2'])
                ->cfgs(['cssClass' => 'site-header-content--big__subtitle'])
                ->add('locationnamebig', 'Location Name Big')
                ->vars(['headingType' => 'h4'])
                ->cfgs(['cssClass' => 'site-header-content--big__location-name'])
                ->register(),
                \luya\bootstrap3\blocks\ImageBlock::variations()
                ->add('sitelogo', 'Site Logo')
                ->vars(['caption' => '', 'textType' => 0])
                ->cfgs(['internalLink' => 1, 'externalLink' => null, 'cssClass' => 'site-logo__image site-logo--big-header__image', 'divCssClass' => 'site-logo site-logo--big-header', 'width' => null, 'height' => null])
                ->add('frontphoto', 'Front photo')
                ->vars(['caption' => '', 'textType' => 0])
                ->cfgs(['internalLink' => null, 'externalLink' => null, 'cssClass' => 'site-front-photo__image', 'divCssClass' => 'site-front-photo', 'width' => null, 'height' => null])
                ->register(),
            ],
        ],
    ],
    'components' => [
        /*
         * Add your smtp connection to the mail component to send mails (which is required for secure login), you can test your
         * mail component with the luya console command ./vendor/bin/luya health/mailer.
         */
        'mail' => [
            'host' => null,
            'username' => null,
            'password' => null,
            'from' => null,
            'fromName' => null,
        ],
        /*
         * The composition component handles your languages and they way your urls will look like. The composition components will
         * automatically add the language prefix which is defined in `default` to your url (the language part in the url  e.g. "yourdomain.com/en/homepage").
         *
         * hidden: (boolean) If this website is not multi lingual you can hide the composition, other whise you have to enable this.
         * default: (array) Contains the default setup for the current language, this must match your language system configuration.
         */
        'composition' => [
            'hidden' => false, // no languages in your url (most case for pages which are not multi lingual)
            'default' => ['langShortCode' => 'by'], // the default language for the composition should match your default language shortCode in the language table.
            'hideDefaultPrefixOnly' => true,
        ],
        /*
         * If cache is enabled LUYA will cache cms blocks and speed up the system in different ways. In the prep config
         * we use the DummyCache to imitate the caching behavior, but actually nothing gets cached. In production you should
         * use caching which matches your hosting environment. In most cases yii\caching\FileCache will result in fast website.
         *
         * http://www.yiiframework.com/doc-2.0/guide-caching-data.html#cache-apis
         */
        'cache' => [
            'class' => 'yii\caching\DummyCache', // use: yii\caching\FileCache
        ],
        'longCache' => [
            'class' => 'yii\caching\FileCache',
            'fileMode' => 0664,
            'dirMode' => 0775,
            'gcProbability' => 0,
        ],
        /*
    	 * Translation component. If you don't have translations just remove this component and the folder `messages`.
    	 */
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'blocks*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],
        'assetManager' => [
            'class' => 'luya\web\AssetManager',
            'fileMode' => 0664,
            'dirMode' => 0775,
            'bundles' => \yii\helpers\ArrayHelper::merge(require ('env-local-assets.php'), [
                'all' => [
                    'depends' => [
                        'yii\\web\\JqueryAsset',
                    ],
                ],
                'yii\\web\\JqueryAsset' => [
                    'sourcePath' => '@bower/jquery/dist',
                    'js' => ['jquery.js'],
                ]
            ]),
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                    'except' => [
                        'yii\db\*',
                    ],
                ],
            ],
        ],
        'fb' => ArrayHelper::merge([
            'class' => 'app\components\Facebook',
        ], require ('fb-local.php')),
    ],
];

return $config;
