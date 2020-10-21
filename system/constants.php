<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 7:29 AM
 */


define("DIVINEPATH", __DIR__ . '/../');
define("VIEWSPATH", DIVINEPATH . 'app/Views/');
define("DEBUG", TRUE);


/* DATABASE */
define("USERTABLE", "finddc_user");
define("CATEGORYTABLE", "finddc_categories");
define("SESSIONSTABLE", "finddc_sessions");
define("ORDERSTABLE", "finddc_order");
define("TESTSTABLE", "finddc_tests");


/* SMARTY */
define("PATHTOSMARTY", __DIR__ . '/templating/smarty-3.1.33/libs/Smarty.class.php');
define("SMARTYCACHE", __DIR__ . '/templating/cache/');
define("SMARTYCOMPILED", __DIR__ . '/templating/compiled/');
