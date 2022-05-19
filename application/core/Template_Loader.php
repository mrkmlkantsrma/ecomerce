<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * /application/core/Template_Loader.php
 *
 **/

class Template_Loader extends CI_Loader {
    
    
    public function template($template_name, $vars = array(), $return = FALSE)
    {

        
         if($return):
            $content  = $this->view('frontend/templates/headerfront', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('frontend/templates/footerfront', $vars, $return);

            return $content;
        else:
            $this->view('frontend/templates/headerfront', $vars);
            $this->view($template_name, $vars);
            $this->view('frontend/templates/footerfront', $vars);
        endif;
        
    }

    public function admintemplate($template_name, $vars = array(), $return = FALSE)
    {
         if($return):
            $content  = $this->view('admin/templates/header', $vars, $return);
            $content  = $this->view('admin/templates/sidebar', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('admin/templates/footer', $vars, $return);

            return $content;
        else:
            $this->view('admin/templates/header', $vars);
            $this->view('admin/templates/sidebar', $vars);
            $this->view($template_name, $vars);
            $this->view('admin/templates/footer', $vars);
        endif;
    }
}

?>
