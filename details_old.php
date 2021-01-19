<?php include('templates/header.php'); ?>
<?php
    include('config/db_connect.php'); 

    // 1. Write query for all albums
    $sql = 'SELECT * FROM albums ORDER BY artist';

    // 2. make query & get results
    $result = mysqli_query($conn, $sql);

    // 3. fetch the resulting rows as an array
    $albums = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // 4. check the array
    // print_r($albums);

    // 5. free result from memory
    mysqli_free_result($result);

    // 6. close connection
    mysqli_close($conn);
?>

<h1>Details</h1>
<table class="table table-success table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Artist</th>
                <th>Title</th>
                <th>Songs</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
        <!-- 7. cycle through the array -->
        <?php foreach($albums as $album) : ?>
            <tr>
                    <td><?php echo htmlspecialchars($album['id']); ?></td>
                    <td><?php echo htmlspecialchars($album['artist']); ?></td>
                    <td><?php echo htmlspecialchars($album['title']); ?></td>
                    <td>
                        <ul>
                            <!-- 8. cycle explode array and cycle through -->
                            <?php foreach(explode(',', $album['songs']) as $song) : ?>
                                <li><?php echo htmlspecialchars($song); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td><?php echo htmlspecialchars($album['price']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>   
<?php include('templates/footer.php');