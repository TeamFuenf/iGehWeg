<?php

class Userimage extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }
  
  private $plainsize = array(64,64);

  private $markersize = array(44,54);
  private $markerarrowsize = array(30,15);  
  private $markerborder = 0;
  
  private $timelinesize = array(128,128);
  private $timelinearrowsize = array(15,30);  
  private $timelineborder = 0;
    
// ----------------------------------------------------------------------------

  private function getUserImage($userid)
  {
    $query = $this->db->get_where("user", array("id" => $userid));
    $row = $query->row(); 
    return $row->picture;
  }

// ----------------------------------------------------------------------------
   
    public function plain($userid)
    {
      $image = @imagecreatetruecolor($this->plainsize[0], $this->plainsize[1]);

      $imgurl = $this->getUserImage($userid);
      $userimage = imagecreatefromjpeg($imgurl);      
      $userimagesize = getimagesize($imgurl);  
      imagecopyresampled($image, $userimage, 0, 0, 0, 0, 64, 64, $userimagesize[0], $userimagesize[1]);
            
      header("Content-Type: image/png;");
      imagepng($image);
    }
  
    public function marker($userid)
    {
      $pw = $this->markersize[0];
      $ph = $this->markersize[1];
      $mw = $this->markerarrowsize[0];
      $mh = $this->markerarrowsize[1];
      $b = $this->markerborder;
  
      $image=imagecreatetruecolor($pw, $ph+$mh);
      imagealphablending($image,false);
      $col=imagecolorallocatealpha($image,255,255,255,127);
      imagefilledrectangle($image,0,0,$pw,$ph+$mh,$col);
      imagealphablending($image,true);

      $back_color = imagecolorallocate($image, 32, 32, 32);      
            
      $spitze = array(
        $pw/2-$mw/2, $ph,
        $pw/2+$mw/2, $ph,
        $pw/2, $ph+$mh
      );

      imagefilledrectangle($image, 0, 0, $pw, $ph, $back_color);
      imagefilledpolygon($image, $spitze, 3, $back_color);

      $imgurl = $this->getUserImage($userid);
      $userimage = imagecreatefromjpeg($imgurl);      
      $userimagesize = getimagesize($imgurl);
      imagecopyresampled($image, $userimage, $b, $b, 0, 0, $pw-2*$b+1, $ph-2*$b+1, $userimagesize[0], $userimagesize[1]);

      header("Content-Type: image/png;");
      imagealphablending($image,false);
      imagesavealpha($image,true);
      imagepng($image);
    }

    public function timeline($userid)
    {
      $pw = $this->timelinesize[0];
      $ph = $this->timelinesize[1];
      $mw = $this->timelinearrowsize[0];
      $mh = $this->timelinearrowsize[1];
      $b = $this->timelineborder;
 
      $image=imagecreatetruecolor($pw+$mw, $ph);
      imagealphablending($image,false);
      $col=imagecolorallocatealpha($image,255,255,255,127);
      imagefilledrectangle($image,0,0,$pw+$mw,$ph,$col);
      imagealphablending($image,true);

      $back_color = imagecolorallocate($image, 64, 64, 64);      
            
      $spitze = array(
        0, $ph/2,
        $mw, $ph/2-$mh/2,
        $mw, $ph/2+$mh/2
      );

      imagefilledrectangle($image, $mw, 0, $pw+$mw, $ph, $back_color);
      imagefilledpolygon($image, $spitze, 3, $back_color);

      $imgurl = $this->getUserImage($userid);
      $userimage = imagecreatefromjpeg($imgurl);      
      $userimagesize = getimagesize($imgurl);
      imagecopyresampled($image, $userimage, $b+$mw, $b, 0, 0, $pw-2*$b, $ph-2*$b, $userimagesize[0], $userimagesize[1]);

      header("Content-Type: image/png;");
      imagealphablending($image,false);
      imagesavealpha($image,true);
      imagepng($image);
    }

// ----------------------------------------------------------------------------

}
