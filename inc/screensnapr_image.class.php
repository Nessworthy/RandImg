<?php

class Screensnapr_Image extends Image {
	
		protected $uri_base = 'http://screensnapr.com/e/';
		
		protected $uri_append = '.png';
	
		protected function validate_image($uri) {
			
			// Nope.
			return true;
			
		}
	
}

?>