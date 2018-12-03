Replying to: <?= $replyingTo; ?>

<div class="container">
    <form name="replyForm" action="index.php?controller=article&action=submit_reply" method="post">
        <div class="form-group">
            <label for="content">Content</label>
            <textarea rows="10" class="form-control" id="content" name="content"></textarea>
            <div id="contentFeedback" class="invalid-feedback" style="display:none;">
                Content must be between 3 and 63206 characters in length.
            </div>
        </div>

        <input type="hidden" id="articleId" name="articleId" value="<?= $articleId ?>" />
        <input type="hidden" id="commentId" name="commentId" value="<?= $commentId; ?>" />
        <button type="submit" class="btn btn-primary">Reply</button>
    </form>
</div>


<script>
    $(document).ready(function()
    {
        $(function() { $('textarea').froalaEditor() });
    });
</script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/froala_editor.min.js'></script>
