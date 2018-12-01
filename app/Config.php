<?php
namespace App;

class Config
{
    /**
     * Database connection details.
     */
    const DB_SERVER = 'lochnagar.abertay.ac.uk';
    const DB_NAME = 'sql1800833';
    const DB_USER = 'sql1800833';
    const DB_PASS = 'rgcGZejkmcci';
    
    /**
     * General site information.
     */
    const SITE_NAME = 'Scranton Herald';
    const SITE_DESC = 'The trusted source for Scranton news.';
    const ROOT = './uni/';

    /**
     * API keys.
     */
    const GOOGLE_CAPTCHA_KEY = '6LfG23UUAAAAAIFz-cZ97KjwmUQ3qWTMJ1GvQdJg';

    /**
     * Set whether errors should be displayed.
     */
    const DISPLAY_ERRORS = true;
}
