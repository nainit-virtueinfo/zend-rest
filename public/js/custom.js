function setUpFCK() {
	if(document.getElementById('body')) {
        var oFCKeditor = new FCKeditor('body') ;
        oFCKeditor.BasePath = "/js/fckeditor/" ;
        oFCKeditor.Height = 400;
        oFCKeditor.ReplaceTextarea() ;
    }

}