<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{

    public function __construct()
    {
        // Do something with $params
    }

    function view($view, $vars = array(), $controls = true)
    {
      $CI =& get_instance();
        
      $CI->session->unset_userdata("lastpage");
      
      $data["css"][] = link_tag("../css/normalize.css");
      $data["css"][] = link_tag("../css/main.css");
      $data["css"][] = link_tag("../css/timeline.css");
      
      $data["javascript"][] = "<script src=\"".base_url()."javascript/jquery.js\" type=\"text/javascript\"></script>";
      $data["javascript"][] = "<script src=\"".base_url()."javascript/jquery-ui.js\" type=\"text/javascript\"></script>";
      $data["javascript"][] = "<script src=\"".base_url()."javascript/meetupp.js\" type=\"text/javascript\"></script>";
      $data["javascript"][] = "<script src=\"".base_url()."javascript/OpenLayers.js\" type=\"text/javascript\"></script>";
      
      $data["dashboard"] = anchor("/dashboard/dashboard", img("../images/dashboard.png"));
      $data["map"] = anchor("/map", img("../images/map.png"));
      $data["friends"] = anchor("/friends", img("../images/friends.png"));
      $data["timeline"] = anchor("/timeline", img("../images/timeline.png"));
	  
      $CI->load->view("base/header.php", $data);
      $CI->load->view($view, $vars);
      if ($controls)
      {
        $CI->load->view("base/controls.php", $data);
      }
      $CI->load->view("base/footer.php");
    }

    function viewexternal($view, $vars = array())
    {
      $CI =& get_instance();
      
      $data["css"][] = link_tag("../css/normalize.css");
      $data["css"][] = link_tag("../css/external.css");
    
      $CI->load->view("base/headerexternal.php", $data);
      $CI->load->view($view, $vars);
      $CI->load->view("base/footerexternal.php");
    }
 
}

?>
