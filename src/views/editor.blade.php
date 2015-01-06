<link rel="stylesheet" href="/packages/vinelab/editor/css/bootstrap-markdown.min.css">

<textarea name="vinelab-editor-text" id="vinelab-editor-textarea" rows="10"></textarea>

<script type="text/javascript" src="/packages/vinelab/editor/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/packages/vinelab/editor/js/markdown.min.js"></script>
<script type="text/javascript">
$(function(){

    $("#vinelab-editor-textarea").markdown({
        savable:false,
        autofocus:false,
        iconLibrary: 'fa',
        hiddenButtons: ['cmdCode', 'cmdList', 'cmdListO', 'cmdHeading', 'cmdQuote'],
        additionalButtons: [
        [{
            name: "groupCustom",
            data: [{
                toggle: true, // this param only take effect if you load bootstrap.js
                name: "cmdUploadPhoto",
                title: "Upload Photo",
                icon: "glyphicon glyphicon-camera",
                callback: function(e){

                }
            }]
        }]
      ]
    });

});
</script>
