wordpress_timthumb_multisite
============================
This function pulls timthumb into wordpress and is a easy way to load images into the script
timthumb.php doesn't know how to deal with the blogs.dir directory in which WordPress stores images in Multisite,
so this function tells timthumb exactly where to find those image.
timthumb.php is not modified by this function,
this function simply tells the script where to find the images in wordpress

download the timthumb script from http://www.binarymoon.co.uk/projects/timthumb/ 
then  add the mr_timthumb  function to your wordpress function.php

--NOTE------//////////  --- This function also works on single site wordpress installs. ------///////////-----

    Copyright 2013  Moya Richards  (website : moyarich.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  

##The beauty about this function is that it allows you use an array of parameters##

this array support all acceptable timthumb parameters   
http://www.binarymoon.co.uk/2012/02/complete-timthumb-parameters-guide/  
as well as readable values for the alignment parameter:   
these values are (center, top, bottom, left, right )    

####example:####
-----------------------------------------------------

    $timthumb_img_param = array(
                      'src' => $orig_uploaded_img,
                      'w'=>590,
                      'h' => 315,
                      'a'=>'top'
                      );

     mr_timthumb($timthumb_img_param);

Note: you could use :
        'a'=>'top' or 'a'=>'t'   
        'a'=>'center' or 'a'=>'c'   

/////---------------------------------

###To pass non array values to this function you can simply type the (src, width, height, zoomCrop, quality,cropAlignment)###
The src is required,
    the width defaults to 200 if not specified,   
    the height defaults to 200 if not specified,   
    zoomCrop defaults to 1,   
    quality defaults to 100 if not specified,   
    cropAlignment defaults to center if not specified   


###example a:###
-----------------------------------------------------
    mr_timthumb($imgsrc,590, 315,1,100,'t');

###example b:
-----------------------------------------------------
    mr_timthumb($imgsrc,590, 315);




###--NOTE---###

-----------------------------------------------------
To use this function you have to change the location to the timthumb script
===========================
  /** $timthumblocation Stores the location of the timthumb script */

     $timthumblocation = get_template_directory_uri()."/inc/scripts/timthumb.php";
  

//get_template_directory_uri() looks for the script in a parent theme    
//get_stylesheet_directory_uri() looks for the script in a child theme   
     

after adding this script to the functions.php, you can use like this in a wordpress template
---to display a featured image (thumbnail) in wordpress
=======================================================
    <?php if(has_post_thumbnail()): ?>
      <div class="photospeak-gallery-image">
       <div class="aligncenter">
          <?php
            // Featured image
            $featured_image_id = get_post_thumbnail_id ( $post->ID );
            $featured_img_post_details = get_post ( $featured_image_id );
            $featured_img_caption = $featured_img_post_details->post_excerpt;
            $orig_uploaded_img = wp_get_attachment_url ( $featured_image_id, 'full' );
  
            $timthumb_img_param = array (
                                   'src' => $orig_uploaded_img,
                                   'w' => 590,
                                   'h' => 315,
                                   'a' => 'top' 
                                   );
                                        
     ?>

     
      <a href="<?php echo $orig_uploaded_img; ?>"title="<?php echo !empty($featured_img_caption) ? $featured_img_caption : get_the_title(); ?>" class="featured_img"><img src="<?php echo mr_timthumb($timthumb_img_param ); ?>"></a>
      
     </div>
    </div>

    <?php endif; ?>
