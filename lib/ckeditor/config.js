/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
	// Define changes to default configuration here. For example:
	config.language = 'ko';
	config.height = 500;
	// config.uiColor = '#AADC6E';

	// 업로드 설정
	config.filebrowserUploadUrl = '/php/upload.php';
	config.filebrowserUploadMethod = 'form';
	config.filebrowserImageUploadUrl = '/php/upload.php?command=QuickUpload&type=Images';
	config.filebrowserWindowWidth = '640';
	config.filebrowserWindowHeight = '480';
	
	config.toolbarCanCollapse = true;
	config.enterMode = CKEDITOR.ENTER_BR;
	config.font_names = '맑은 고딕/Malgun Gothic;굴림/Gulim;돋움/Dotum;바탕/Batang;궁서/Gungsuh;' + config.font_names;
};
