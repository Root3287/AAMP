<?php 
$user = new User();
if(!$user->isLoggedIn()){
	Redirect::to("/");
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
			<?php
			if(Session::exists("complete")){
				echo Session::flash("complete");
			}
			?>

			<div class="panel panel-primary">
				<div class="panel-heading">Pompts</div>
				<div class="panel-body">
					<ol>
						<?php 
						foreach($prompt->getPrompt() as $p){
							echo "<a href='/prompt/".$p->id."'>".$p->prompt."</a> \t <a class='btn btn-xs btn-primary' href='/r/".$p->hash."'>Response Link</a><br>";
						}
						?>
					</ol>
				</div>
			</div>
		</div>
		<?php require "assets/foot.php";?>
	</body>
</html>