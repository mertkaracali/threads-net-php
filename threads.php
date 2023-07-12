<?php
class Threads
{

	public $threads = "https://www.threads.net/api/graphql";

	public function default_header()
	{
		$headers["Authority"] = "www.threads.net";
		$headers["Accept"] = "*/*";
		$headers["Accept-Language"] = "en-US,en;q=0.9";
		$headers["Cache-Control"] = "no-cache";
		$headers["user-agent"] = "threads-client";
		$headers["Content-Type"] = "application/x-www-form-urlencoded";
		$headers["Origin"] = "https://www.threads.net";
		$headers["Pragma"] = "no-cache";
		$headers["Sec-Fetch-Site"] = "same-origin";
		$headers["X-ASBD-ID"] = "129477";
		$headers["X-IG-App-ID"] = "238260118697367";
		return $headers;
	}
	public function request($url, $headers, $params = NULL, $post = NULL)
	{

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, $post);
		if (!empty($post)) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, @http_build_query($params));
		}
		print_r(http_build_query($params));
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	public function get_token()
	{
		$response =  file_get_contents("https://www.instagram.com/mertkaracali34");
		preg_match_all('@LSD",\[\],{"token":"(.*?)"@si', $response, $res);
		return $res[1][0];
	}
	public function get_user($id)
	{
		$lsd = $this->get_token();
		$headers = $this->default_header();
		$headers["X-FB-LSD"] = $lsd;
		$headers["X-FB-Friendly-Name"] = "BarcelonaProfileRootQuery";
		$params = ["lsd" => $lsd, "variables" => json_encode(["userID" => $id]), "doc_id" => "23996318473300828"];
		return $this->request($this->threads, $headers, $params, 1);
	}
	public function get_user_threads($id)
	{
		$lsd = $this->get_token();
		$headers = $this->default_header();
		$headers["X-FB-LSD"] = $lsd;
		$headers["X-FB-Friendly-Name"] = "BarcelonaProfileThreadsTabQuery";
		$params = ["lsd" => $lsd, "variables" => json_encode(["userID" => $id]), "doc_id" => "6232751443445612"];
		return $this->request($this->threads, $headers, $params, 1);
	}
	public function get_user_reply($id)
	{
		$lsd = $this->get_token();
		$headers = $this->default_header();
		$headers["X-FB-LSD"] = $lsd;
		$headers["X-FB-Friendly-Name"] = "BarcelonaProfileRepliesTabQuery";
		$params = ["lsd" => $lsd, "variables" => json_encode(["userID" => $id]), "doc_id" => "6307072669391286"];
		return $this->request($this->threads, $headers, $params, 1);
	}
	public function get_threads($id)
	{
		$lsd = $this->get_token();
		$headers = $this->default_header();
		$headers["X-FB-LSD"] = $lsd;
		$headers["X-FB-Friendly-Name"] = "BarcelonaProfileRepliesTabQuery";
		$params = ["lsd" => $lsd, "variables" => json_encode(["postID" => $id]), "doc_id" => "5587632691339264"];
		return $this->request($this->threads, $headers, $params, 1);
	}
	public function get_threads_likers($id)
	{
		$lsd = $this->get_token();
		$headers = $this->default_header();
		$headers["X-FB-LSD"] = $lsd;
		$params = ["lsd" => $lsd, "variables" => json_encode(["postID" => $id]), "doc_id" => "9360915773983802"];
		return $this->request($this->threads, $headers, $params, 1);
	}
}
