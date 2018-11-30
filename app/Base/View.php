<?php 
namespace App\Base;

use App\Base\Util;

class View
{
    const HEADER_FILE = 'app/Views/templates/header.php';
    const FOOTER_FILE = 'app/Views/templates/footer.php';

    private $data = array();
    private $file = false;

    public function __construct($template)
    {
        $file = 'app/Views/' . strtolower($template) . '.php';

        if (file_exists($file)) 
            $this->file = $file;
    }

    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    public function render()
    {
        $this->assign('loggedIn', Util::isLoggedIn());
        extract($this->data);
        
        include(View::HEADER_FILE);
        include($this->file);
        include(View::FOOTER_FILE);
    }
}