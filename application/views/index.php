<div class="container">
    <h2>Files List</h2>   

    <?php if (isset($success)) { ?>
        <div class="alert alert-success" role="alert">
            <?= $success ?>
        </div>
    <?php } ?>

    <form method='post' action="<?= base_url() ?>index.php/Inventory/listFiles" >
        <div class="form-group">
            <label for="search">Search:</label>
            <input type='text' class="form-control" name='search' value='<?= $search ?>'>
        </div>
        <input type='submit' class="btn btn-default" name='submit' value='Submit'>
        <input type='submit' class="btn btn-neutral" name='cancel' value='Reset'>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Created On</th>
                <th>Deleted</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($result) == 0) {
                echo "<tr>";
                echo "<td colspan='3'>No record found.</td>";
                echo "</tr>";
            } else {
                foreach ($result as $data) {
                    echo "<tr>";
                    echo "<td>" . $data['file_name'] . "</td>";
                    echo "<td>" . date('m/d/Y', strtotime($data['created_date'])) . "</td>";
                    echo "<td>" . $data['is_deleted'] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <div style='margin-top: 10px;'>
        <?= $pagination; ?>
    </div>
    
    <div style='margin-top: 10px;'>
        <a href="<?= base_url() ?>index.php/Inventory/upload">Upload Files</a>
    </div>
</div>