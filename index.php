<?php 
    include('config/db_connect.php'); 

    // 1. Write query for all albums
    $sql = 'SELECT id, artist, title, price FROM albums ORDER BY artist';

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

    // explode
    // print_r(explode(',', $albums[0]['songs']));



?>

<?php include('templates/header.php'); ?>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>Artist</th>
                <th>Title</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <!-- 7. cycle through the array -->
            <?php foreach($albums as $album) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($album['artist']); ?></td>
                    <td><?php echo htmlspecialchars($album['title']); ?></td>
                    <td><a href="details.php?id=<?php echo $album['id']; ?>"><button class="btn btn-sm btn-light">More info</button></a></td>
                </tr>
                
            <?php endforeach; ?>
        </tbody>
    </table>   
    <hr>
<?php include('templates/footer.php');