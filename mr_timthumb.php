<?php
/*
 * Allow timthumb to work on a wordpress multisite site
 * @package WordPress
 * @uses wp_parse_args()
 * @uses add_query_arg()
 * @uses network_site_url()
 * @uses site_url()
 *
 * @Since 3.5
 *
 * @param mixed $args. User defined arguments for replacing the defaults, if $args is a string optional parameters are expected.
 * @param int $width Optional, default is 200
 * @param int $height Optional, default is 200
 * @param int $zoomCrop Optional, default is  1
 * @param int $quality Optional, default is 100
 * @param string $cropAlignment Optional, default is c

 * @returns string ,timthumb url src
*/


function mr_timthumb($args = array(), $width=200, $height=200, $zoomCrop = 1, $quality = 100,$cropAlignment = "c"){
  
  /** Stores the location of the timthumb script */
     //get_template_directory_uri() looks for the script in a parent theme
     //get_stylesheet_directory_uri() looks for the script in a child theme

  $timthumblocation = get_template_directory_uri()."/inc/scripts/timthumb.php";

    //if a string is passed to the function convert to array
    if ( is_string( $args ) ) {
           $args = array(
                        'src' => $args,
                        'w' => $width,
                        'h'=>$height,
                        'zc'=>$zoomCrop,
                        'q'=>$quality,
                        'a'=>$cropAlignment
                     );
   }
      //set default values
      $defaults = array(
                        'w' => $width,
                        'h'=>$height,
                        'zc'=>1,
                        'q'=>100,
                        'a'=>'c'
                      );

      $args = wp_parse_args( $args, $defaults ); // merge  new value with defaults
      $img_orig_src = $args['src']; // hold the unaltered image path

       //creates useful names for the crop alignment
       switch (strtolower($args['a']))
          {
          case "center":
              $args['a'] = "c";
              break;
          case "top":
              $args['a'] = "t";
              break;
         case "bottom":
              $args['a'] = "b";
              break;
          case "left":
              $args['a'] = "l";
              break;
          case "right":
              $args['a'] = "r";
              break;
          };


	if (is_multisite())
	{
		$img_upload_folder = "wp-content/blogs.dir/" . get_current_blog_id() . "/files/";

		$imageParts = explode("/files/", $args['src']);

		//uses network_site_url() to retrieves the site url for the "main" site of the current network
		//useful when trying to locate images in a wordpress Multisite Sub-directory Setup

	       /** Changes the image src to the correct location on the wordpress multisite */
		$args['src'] = network_site_url().$img_upload_folder.$imageParts[1];
	}
      /** Append the array values to the end of the timthumb script URL */
      $timthumb_image_src = add_query_arg($args,$timthumblocation);

      /** If the image is on the same server as the website use timthumb*/
      if(strpos($img_orig_src, site_url()) === FALSE){
		return $img_orig_src;
	}else{
		return $timthumb_image_src;
	}

}
?>
