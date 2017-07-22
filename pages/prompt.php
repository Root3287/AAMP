<?php
$user = new User();
if(!$user->isLoggedIn()){
	Redirect::to('/');
}
$prompt = new Prompt($user->data()->id);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require "assets/head.php";?>
	</head>
	<body>
		<?php require "assets/nav.php";?>
		<div class="container">
			<h3><?php echo $prompt->getPrompt($prompt_id)->prompt;?></h3>
			<ol>
			<?php
			$rs = Response::get($prompt_id);
			for($i = count($rs)-1; $i >= 0; $i--){
				echo "<li> <a data-toggle='modal' data-target='#".$rs[$i]->hash."'>".$rs[$i]->time."</a> <button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#".$rs[$i]->hash."'>Show</button><br></li>";
			}
			?>
			</ol>
		</div>

		<?php
		foreach($rs as $r){
			
		?>
		<div class="modal fade" id="<?php echo $r->hash?>" tabindex="-1" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title"><?php echo $r->time;?></h4>
		      </div>
		      <div class="modal-body">
		        <p><?php echo $r->response;?>&hellip;</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<?php	
		}
		?>
		<?php require "assets/foot.php";?>
	</body>
</html>