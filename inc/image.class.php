<?php

	/**
	 * Handles the core instructions for image generation.
	 * 
	 * @author Jon laCour <jon@lacour.me>
	 * @author Sean Nessworthy <bladescope@gmail.com>
	 * @link http://github.com/Bladescope/RandImg
	 * @link http://github.com/laCour/RandImg/
	 * @copyright See http://github.com/laCour/RandImg/blob/master/README.md
	 * 
	 * @param	string	$hash	String containing the image hash.
	 * @param	mixed	$mode	A supplied image mode, customised by extended classes.
	 * 
	 */
	abstract class Image {
			
		// The base URL used to access the image site.
		protected $uri_base;
		
		// The string to append onto the URI.
		protected $uri_append;
		
		// The image hash. Overwrite generate_hash() to modify this.
		protected $raw_hash;
		
		// Any additional option for the image. This is passed to set_image_mode();
		protected $image_mode;
		
		// The image url (once generated)
		protected $image_uri;
		
		/**
		 * Returns the full image URL.
		 * 
		 * @return	string			The full image URL.
		 */
		protected function generate_uri($prefix,$hash,$suffix) {
			
			return $uri = $prefix.$hash.$suffix;
			
		}
		
		/**
		 * Generates a random hash.
		 * 
		 * @param	integer	$length	An optional integer for hash length.
		 * @return	string			The generated hash.
		 */
		protected function generate_hash($length=5) {
			return key::new_key($length);
		}
		
		/**
		 * Returns the image hash.
		 * 
		 * @return	string			The image hash.
		 */
		public function get_hash() {
			return $this->raw_hash;
		}
		
		/**
		 * Checks if a URL exists by pinging it via. cURL.
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
		abstract protected function validate_image($uri);
		
		/**
		 * Returns an image URL.
		 */
		final public function get_image() {
			
			$return;
			
			if(!$this->image_uri) {
				// Validation!
				$hash = $this->raw_hash;
				
				$this->set_image_mode($this->image_mode);
				
				$uri = $this->generate_uri($this->uri_base,$hash,$this->uri_append);
				
				if($this->validate_uri($uri)) {
					
					
					if($this->validate_image($uri)) {
						
						$return = $this->image_uri = $uri;
						
					}
					
				}
			} else {
				
				$return = $this->image_uri;
			
			}
			
			return $return ? $return : false;
			
			
		}
		
		/**
		 * Is passed the image mode. Use this method to modify the image's URI.
		 * 
		 * @param	string	$mode	The image mode of the object.
		 */
		protected function set_image_mode($mode) {
			return;
		}
		
		public function __construct($hash=null, $mode=null) {
			
			if(!$hash) {
				$hash = $this->generate_hash();
			}
			
			$this->raw_hash = $hash;
			$this->image_mode = $mode;
		}
		
	}

?>