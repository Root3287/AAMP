<?php
if(!$prompt = DB::getInstance()->get("prompt", ["hash", "=", escape($hash)])->first()){
	Redirect::to("/404");
}
if(Input::exists()){
	if(Token::check(Input::get("token"))){
		$val = new Validation();
		$validate = $val->check($_POST, [
			"reponse"=>[
				"require"=>true,
			],
		]);

		if($validate->passed()){
			Response::add($prompt->id, escape(Input::get("reponse")));
			Session::flash("complete", "<div class='alert alert-success'>You have submited your response!</div>");
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
			<?php if(Session::exists("complete")){echo Session::flash("complete");}?>
			<h3><center><?php echo $prompt->prompt;?></center></h3>
			<form action="" method="post" autocomplete="off">
				<div class="form-group">
					<textarea class="form-control" name="reponse"></textarea>
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