<?php
$user = new User();
if(!$user->isLoggedIn()){
	Redirect::to("/");
}
if(Input::exists()){
	if(Token::check(Input::get("token"))){
		$val = new Validation();
		$val->check($_POST, [
			"prompt"=>[
				"require"=>true,
			],
		]);
		if($val->passed()){
			$prompt = new Prompt($user->data()->id);
			$prompt->add($user->data()->id, escape(Input::get("prompt")));
			$db1 = DB::getInstance()->get("prompt", ["prompt", "=", escape(Input::get("prompt"))])->first();
			$p1 = new Prompt($user->data()->id);
			$data = $p1->getPrompt($db1->id)->hash;
			Session::flash("complete", "<div class='alert alert-success'>You have added a prompt. Share the link with your friends!</div>");
			Redirect::to("/r/".$data);
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require "assets/head.php";?>
	</head>
	<body>
		<?php require "assets/nav.php";?>
		<div class="container">
			<center><h1>Add Prompt</h1></center>
			<form action="" method="post" autocomplete="off">
				<div class="form-group">
					<input type="text" name="prompt" placeholder="prompt" value="<?php echo Input::get('prompt')?>" class="form-control input-md">
				</div>
				<div class="pull-right col-sm-6 col-md-2">
					<div class="form-group">
						<input class="btn btn-md btn-primary btn-block" type="submit" value="Submit" id="Submit" name="submit"/>
						<input type="hidden" name="token" value="<?php echo Token::generate()?>"/>
					</div>
				</div>
			</form>
		</div>
		<?php require "assets/foot.php";?>
	</body>
</html>