<?php
namespace App\Base;

class Config
{
    public function init()
    {
        /**
        * Configure error reporting.
        */
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        /**
        * Configure the database connection credentials.
        */
        define('DB_SERVER', 'lochnagar.abertay.ac.uk');
        define('DB_NAME', 'sql1800833');
        define('DB_USER', 'sql1800833');
        define('DB_PASS', 'rgcGZejkmcci');

        /**
        * Configure site title. This is displayed in several
        * places throughout the site.
        */
        define('SITE_NAME', 'Scranton Herald');
        define('SITE_DESC', 'The trusted source for Scranton news.');
        define('ROOT', './uni/');
    }
}
