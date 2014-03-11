<?php  

defined('C5_EXECUTE') or die(_("Access Denied."));

class StackModalPackage extends Package {

	protected $pkgHandle = 'stack_modal';
	protected $appVersionRequired = '5.6';
	protected $pkgVersion = '1.2.1';
	
	public function getPackageDescription() {
		return t("Easily load a stack into a modal window.");
	}
	
	public function getPackageName() {
		return t("Stack Modal");
	}
	
	public function install() {
		$pkg = parent::install();
		
		// install block		
		BlockType::installBlockTypeFromPackage('stack_modal', $pkg);
		
	}
}