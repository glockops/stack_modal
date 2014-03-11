<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<div class="stack-modal-link">
    <a data-toggle="modal" href="#<?php  echo $bID;?>" class="stack-modal-link"><?php  echo $linkContents; ?></a>
</div>
<div class="stack-modal">
    
    <div class="modal hide fade" id="<?php  echo $bID;?>">
    	<div class="modal-header">
        	<a class="close" data-dismiss="modal">×</a>
            <h3><?php  echo $modalTitle; ?></h3>
        </div>
        <div class="modal-body">
        	<?php  if(is_object($modalBody)) {
				echo $modalBody->display();
			} else {
				echo '<p>The stack that is referenced by this block has been deleted.</p>';
			} ?>
        </div>
        <div class="modal-footer">
        	<a class="btn" data-dismiss="modal">Close</a>
        </div>
    </div>
</div>

