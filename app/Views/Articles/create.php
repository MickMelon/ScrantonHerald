<div class="container">
    <form name="createArticleForm" action="index.php?controller=article&action=submit_create" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="headline">Headline*</label>
            <input type="text" class="form-control" id="headline" name="headline" placeholder="Enter article headline" maxlength="80" minlength="3" required />
            <div id="headlineFeedback" class="invalid-feedback" style="display:none;">
              Headline must be between 3 and 80 characters in length.
            </div>
        </div>
        <div class="form-group">
            <label for="headlineImage">Headline Image</label>
            <input type="file" class="form-control" id="headlineImage" name="headlineImage" />
        </div>
        <div class="form-group">
            <label for="file">File</label>
            <input type="file" class="form-control" id="fileUpload" name="fileUpload"/>
        </div>
        <div class="form-group">
            <label for="content">Content*</label>
            <textarea rows="10" class="form-control" id="content" name="content" placeholder="Enter article content" minlength="3" maxlength="63206" required></textarea>
            <div id="contentFeedback" class="invalid-feedback" style="display:none;">
              Content must be between 3 and 63206 characters in length.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>

    <hr />
    <h3>Live Preview</h3>
    <div id="preview" class="fr-view">
        <i>This will update as you start typing...</i>
    </div>
</div>



<script>
    $(document).ready(function()
    {
        $(function() { $('textarea').froalaEditor()
            .on('froalaEditor.contentChanged', function (e, editor) {
                $('#preview').html(editor.html.get());
            })
        });

        $(function() 
        {
            $('#content').froalaEditor(
            {
                imageUploadMethod: 'POST',
                imageMaxSize: 100 * 1024 * 1024, // 10MB
                imageAllowedTypes: ['jpeg', 'jpg', 'png']
            })
        });
    });
</script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/froala_editor.min.js'></script>
<script src="public/vendor/froala/plugins/js/image.min.js"></script>
<script src="public/vendor/froala/plugins/js/font_size.min.js"></script>