<div class="container">
    <h2>Upload Files</h2>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php } ?>
    <form action="<?= site_url('inventory/upload_action') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">File:</label>
            <input type="file" class="form-control" id="file_name" name="file_name">
        </div>
        <div class="alert alert-warning" role="alert">
            <strong>Allowed Formats :</strong> <?= implode(', ', $fileTypes) ?>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
    
    <div style='margin-top: 10px;'>
        <a href="<?= base_url() ?>index.php/Inventory/listFiles">List Files</a>
    </div>
</div>


