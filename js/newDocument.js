window.addEventListener("load", () => {
    CKEDITOR.replace('editor');

    let data = CKEDITOR.instances.editor.getData();
    CKEDITOR.instances.editor.setData('<?= $mod != 0 ? $data->content : "" ?>');
});
