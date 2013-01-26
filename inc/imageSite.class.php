<?php

	class Image {
			
		// The base URL used to access the image site.
		protected $base_url;
		
		
		
		/**
		 * Returns the full image URL.
		 * 
		 * @return	string			The full image URL.
		 */
		protected function get_image_url($code);
		
		/**
		 * Generates an image hash.
		 * 
		 * @return	string			The generated hash.
		 */
		protected function generate_hash();
		
		/**
		 * Checks if a URL exists.
		 * 
		 * @param	string	$uri	The uri to check.
		 * @return	boolean			False on failure to validate, true if successful.
		 */
		protected function validate_uri($url) {
			
		    $request = curl_init($url);
			
		    curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
			
		    curl_exec($request);
			
		    $code = curl_getinfo($request, CURLINFO_HTTP_CODE);
			
		    return ($code == 200) ? true : false;
			
		}
		
		/**
		 * Validates an image. Note that this is called after validate_uri.
		 * 
		 * @param	string	$uri	The uri to check.
		 * @return	boolean			False on failure to validate, true if successful.
		 */
		protected function validate_image($url);
		
		/**
		 * Returns an image URL.
		 */
		public function getImage();
		
		public function __construct() {
			
		}
		
	}

?>