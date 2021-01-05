<?php
require("db.php");

if ($_FILES["upload"]["size"] > 0) {
	//오리지널 파일 이름.확장자
	$ext = substr(strrchr($_FILES["upload"]["name"], "."), 1);
	$ext = strtolower($ext);
	$savefilename = time() . "_" . str_replace(" ", "_", $_FILES["upload"]["name"]);

	$uploadpath	 = $_SERVER['DOCUMENT_ROOT'] . "/upload/board";
	$uploadsrc = $_SERVER['HTTP_HOST'] . "/upload/board/";
	$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '') . '://';

	//php 파일업로드하는 부분
	if ($ext == "jpg" or $ext == "gif" or $ext == "png") {
		move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath . "/" . iconv("UTF-8", "EUC-KR", $savefilename));
		
		// 업로드된 이미지파일 정보를 가져옵니다
		$file = getimagesize($uploadpath . "/" . iconv("UTF-8", "EUC-KR", $savefilename));
		// 저용량 jpg 파일을 생성합니다
		if ($file['mime'] == 'image/png')
			$image = imagecreatefrompng($uploadpath . "/" . iconv("UTF-8", "EUC-KR", $savefilename));
		else if ($file['mime'] == 'image/gif')
			$image = imagecreatefromgif($uploadpath . "/" . iconv("UTF-8", "EUC-KR", $savefilename));
		else
			$image = imagecreatefromjpeg($uploadpath . "/" . iconv("UTF-8", "EUC-KR", $savefilename));

		imagejpeg($image, $uploadpath . "/" . iconv("UTF-8", "EUC-KR", $savefilename), 75);
		$uploadfile = $savefilename;
	} else {
		echo "<script type='text/javascript'>alert('jpg, gif, png 파일만 업로드 가능합니다.');</script>;";
	}
} else {
	exit;
}

echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']}, '" . $http . $uploadsrc . "$uploadfile');</script>;";
