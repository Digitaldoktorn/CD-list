<?php

    include('config/db_connect.php');

    if(isset($_POST['delete'])) {
        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        $sql ="DELETE FROM albums WHERE id=$id_to_delete";

        if(mysqli_query($conn, $sql)) {
            // success
            header('Location: index.php');
        } else {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }

    }

     // Check GET request id param
     if(isset($_GET['id'])){
         // escaping any sensitive SQL character
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        // make sql
        $sql = "SELECT * FROM albums WHERE id = $id";

        // get the query results
        $result = mysqli_query($conn, $sql);

        // fetch result in array format
        $album = mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        mysqli_close($conn);

        // print_r($album);
     }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php'); ?>
    <div class="container mt-3 p-4">
    <h3>Details</h3>
        <?php if($album): ?>
            <table class="table table table-striped">
                <tr>
                    <th>ID</th>
                    <td><?php echo htmlspecialchars($album['id']); ?></td>
                </tr>
                <tr>
                    <th>Artist</th>
                    <td><?php echo htmlspecialchars($album['artist']); ?></td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td><?php echo htmlspecialchars($album['title']); ?></td>
                </tr>
                <tr>
                    <th>Songs</th>
                    <td><?php echo htmlspecialchars($album['songs']); ?></td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td><?php echo htmlspecialchars($album['price']); ?>$</td>
                </tr>
            </table>
            <form action="details.php" method="POST">
                            <input type="hidden" name="id_to_delete" value="<?php echo $album['id'] ?>">
                            <input type="submit" name="delete" value="Delete record" class="btn btn-sm btn-danger">
                        </form>
        <?php else: ?>
            <h5>No such album exist in this database.</h5>
        <?php endif; ?>
    </div>
    <?php include('templates/footer.php'); ?>
</html>