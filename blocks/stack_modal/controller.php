<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));

class StackModalBlockController extends BlockController {

	// Block Settings
	protected $btDescription = "Include a stack in a modal window.";
	protected $btName = "Stack Modal";
	protected $btTable = 'btStackModal';
	protected $btInterfaceWidth = "400";
	protected $btInterfaceHeight = "430";
	
	public function getBlockTypeDescription() {
		return t("Include a stack in a modal window.");
	}
	
	public function getBlockTypeName() {
		return t("Stack Modal");
	}
	
	// Cache Settings
	protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = false;
    protected $btCacheBlockOutputOnPost = false;
    protected $btCacheBlockOutputForRegisteredUsers = false;
    protected $btCacheBlockOutputLifetime = 1440;
	
	public function on_page_view() {
		
		/**********************************************
			SPECIAL NOTE FOR BOOTSTRAP THEME USERS
		***********************************************
		If your theme uses bootstrap, then you may find it beneficial to disable
		the following call to this package's bootstrap modal files and use your own.
		*/	
		
		$html = Loader::helper('html/v2');
		$this->addHeaderItem($html->css('bootstrap.min.css','stack_modal'));
		$this->addFooterItem($html->javascript('bootstrap.min.js','stack_modal'));
	}
	
	public function getJavaScriptStrings() {
			return array(
				'image-required' => t('You must select an image.'),
				'text-required' => t('You must enter text for the link.'),
				'stack-required' => t('You must select a stack.')
			);
		}
	
	public function add() {
		$this->set('linkType','text');
		$this->set('stackList',$this->getStackList());
	}
	
	public function edit() {
		$this->set('stackList',$this->getStackList());
		if($this->linkType == 'image') {
			if($this->linkContent > 0) {
				$img = File::getByID($this->linkContent);
				$this->set('linkImage',$img);
				$this->set('img_width',$this->width);
				$this->set('img_height',$this->height);

			}
		} else {
			$this->set('linkText',$this->linkContent);
		}
	}
	
	public function save($args) {
		// translate linkText or linkImage into linkContent for storage
		if($args['linkType'] == 'image') {
			$args['linkContent'] = $args['linkImage'];
			
			// If both values are zero, use the actual image size
			if($args['img_width'] == 0 && $args['img_height'] == 0) {
				$img = File::getByID($args['linkImage']);
				$args['img_width'] = $img->getAttribute('width');
				$args['img_height'] = $img->getAttribute('height');
			}
			
			// Compute width/height based on any provided value (used when only one value is provided)
			$args['width'] = ($args['img_width'] > 0) ? $args['img_width'] : ($args['img_height']*1.5);
			$args['height'] = ($args['img_height'] > 0) ? $args['img_height'] : ($args['img_width']*1.5);
		} else {
			$args['linkContent'] = $args['linkText'];
		}
		
		parent::save($args);
	}
	
	public function view() {
		Loader::model('stack/model');
		$stack = Stack::getByID($this->stack);
		
		if($this->linkType == 'image') {
			$this->set('linkContents',$this->getImage());
		} else {
			$this->set('linkContents',htmlentities($this->linkContent));	
		}
		if($this->title != '') {
			$this->set('modalTitle',htmlentities($this->title));
		} else {
			if(is_object($stack)) {
				$this->set('modalTitle',$stack->getStackName());
			}
		}
		if(is_object($stack)) {
			$this->set('modalBody',$stack);
		}
	}
	
	private function getStackList() {
		Loader::model('stack/list');
		$stackList = new StackList();
		$stackList->filterByUserAdded();
		$stackList->sortByName();
		return $stackList->get();
	}
	
	private function getImage() {
		$im = Loader::helper('image');
		$image = File::getByID($this->linkContent);
		$alt = $image->getApprovedVersion()->getTitle();
		$thumbnail = $im->getThumbnail($image,$this->width,$this->height);
		$img = '<img src="'.$thumbnail->src.'" alt="'.$alt.'" />';
		return $img;
	}
}