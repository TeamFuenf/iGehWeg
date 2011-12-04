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
      
      $data["css"][] = link_tag("../css/normalize.css");
      $data["css"][] = link_tag("../css/main.css");
      $data["css"][] = link_tag("../css/timeline.css");
      
      $data["javascript"][] = "<script src=\"".base_url()."javascript/jquery.js\" type=\"text/javascript\"></script>";
      $data["javascript"][] = "<script src=\"".base_url()."javascript/meetupp.js\" type=\"text/javascript\"></script>";
      
      $data["control_dashboard"] = anchor("/", img("../images/control_dashboard.png"));
      $data["control_map"] = anchor("/map", img("../images/control_map.png"));
      $data["control_friends"] = anchor("/friends", img("../images/control_friends.png"));
      $data["control_timeline"] = anchor("/timeline", img("../images/control_timeline.png"));
      
      $CI->load->view("base/header.php", $data);
      $CI->load->view($view, $vars);
      if ($controls)
      {
        $CI->load->view("base/controls.php", $data);
      }
      $CI->load->view("base/footer.php");
    }
  
}

?>
