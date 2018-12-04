<?php 
namespace App;

use App\Util;
use App\Config;

class View
{
    const HEADER_FILE = 'app/Views/Templates/header.php';
    const FOOTER_FILE = 'app/Views/Templates/footer.php';

    private $data = array();
    private $file = false;

    /**
     * Create a new view from the specified template name.
     * e.g. 'Articles/index'
     */
    public function __construct($template)
    {
        $file = 'app/Views/' . $template . '.php';
        
        if (file_exists($file)) 
            $this->file = $file;
        else 
            $this->file = 'app/Views/Pages/error.php';
    }

    /**
     * Add the variables that need to be displayed on the view.
     */
    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    /**
     * Display the view with the header and footer.
     */
    public function render()
    {
        $this->assign('loggedIn', Util::isLoggedIn());
        $this->assign('isReporter', Util::isReporter());
        $this->assign('siteName', Config::SITE_NAME);
        $this->assign('siteDesc', Config::SITE_DESC);
        extract($this->data); 

        include(View::HEADER_FILE);
        include($this->file);
        include(View::FOOTER_FILE);
    }
}