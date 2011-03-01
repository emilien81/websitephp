<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\autocomplete\AutoCompleteEvent.class.php
 * Class AutoCompleteEvent
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 17/01/2011
 *
 * @version     1.0.30
 * @access      public
 * @since       1.0.17
 */

class AutoCompleteEvent extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $onselect = "";
	/**#@-*/
	
	function __construct() {
		parent::__construct();
	}
	
	public function onSelectJs($js_function) {
		$this->onselect = trim($js_function);
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		$html = $this->onselect;
		
		$this->object_change = false;
		return $html;
	}
}
?>