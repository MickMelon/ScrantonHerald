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
            <input type="file" class="form-control" id="headlineImage" name="headlineImage" placeholder="Enter headline image URL" />
            <div id="headlineImageFeedback" class="invalid-feedback" style="display:none;">
              Headline image URL must be between 3 and 255 characters in length.
            </div>
        </div>
        <div class="form-group">
            <label for="content">Content*</label>
            <textarea rows="10" class="form-control" id="content" name="content" placeholder="Enter article content" minlength="3" maxlength="63206" required></textarea>
            <div id="contentFeedback" class="invalid-feedback" style="display:none;">
              Content must be between 3 and 63206 characters in length.
            </div>
        </div>
        <div class="form-group">
            <label for="file">File</label>
            <input type="file" class="form-control" id="file" name="file"/>
            <div id="fileFeedback" class="invalid-feedback" style="display:none;">
              Last name must be between 2 and 35 characters in length.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

<div class="fr-view">
    Edited text goes here
</div>

<script>
    $(document).ready(function()
    {
        $(function() { $('textarea').froalaEditor() });

        $(function() 
        {
            $('#content').froalaEditor(
            {
                imageUploadURL: 'index.php?controller=article&action=upload_image',
                imageUploadMethod: 'POST',
                imageMaxSize: 10 * 1024 * 1024, // 10MB
                imageAllowedTypes: ['jpeg', 'jpg', 'png']
            })
            .on('froalaEditor.image.beforeUpload', function (e, editor, images) {
                console.log("Before Upload");
                // Return false if you want to stop the image upload.
            })
            .on('froalaEditor.image.uploaded', function (e, editor, response) {
                console.log("Image was uploaded to the server");
            })
            .on('froalaEditor.image.inserted', function (e, editor, $img, response) {
                console.log("Image was inserted in the editor.");
            })
            .on('froalaEditor.image.replaced', function (e, editor, $img, response) {
                console.log("Image was replaced in the editor.");
            })
        });
    });
</script>
