<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
    public function template($template_name, $vars = array(), $return = FALSE)
    {

        
         if($return):
            $content  = $this->view('home/templates/header', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('home/templates/footer', $vars, $return);

            return $content;
        else:
            $this->view('home/templates/header', $vars);
            $this->view($template_name, $vars);
            $this->view('home/templates/footer', $vars);
        endif;
        
    }

    public function admintemplate($template_name, $vars = array(), $return = FALSE)
    {
         if($return):
            $content  = $this->view('admin/templates/header', $vars, $return);
            // $content  = $this->view('admin/templates/sidebar', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('admin/templates/footer', $vars, $return);

            return $content;
        else:
            $this->view('admin/templates/header', $vars);
            // $this->view('admin/templates/sidebar', $vars);
            $this->view($template_name, $vars);
            $this->view('admin/templates/footer', $vars);
        endif;
    }

}