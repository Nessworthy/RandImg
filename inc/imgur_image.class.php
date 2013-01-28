<?php

class Imgur_Image extends Image {
	
		protected $uri_base = 'http://i.imgur.com/';
		
		protected $uri_append = '.jpg';
	
		protected function validate_image($uri) {
			
			list($width, $height) = getimagesize($uri);
			
			// 404 image, one assumes.
			if($width == 161 && $height == 81) {
				return false;
			}
			
			return true;
			
		}
	
}

?>