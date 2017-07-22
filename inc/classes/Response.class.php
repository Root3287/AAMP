<?php
class Response{
	private static $_db;
	public static function get($id){
		return DB::getInstance()->get("response", ["pid", "=", $id])->results();
	}
	public static function add($pid, $response){
		DB::getInstance()->insert("response", ["pid"=>$pid, "response"=>$response, "time"=>date('Y-m-d H:i:s'), "hash"=>Hash::unique_length(16)]);
	}
}