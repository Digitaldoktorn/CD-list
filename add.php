
<?php

  include('config/db_connect.php');

  // 6. Initialize empty strings for input variables
  $title = $artist = $songs = $price = '';

  // 5. Create "errors" array and put the error messages in the html template
  $errors = [
    'title' => '',
    'artist' => '',
    'songs' => '',
    'price' => ''
  ];

  // 1. check if data is set
  if(isset($_POST['submit'])){
    // 2. test check and escape malicious code with htmlspecialchars
    // echo htmlspecialchars($_POST['title']);
    // echo htmlspecialchars($_POST['artist']);
    // echo htmlspecialchars($_POST['songs']);
    // echo htmlspecialchars($_POST['price']);

    // 3. Check every field if it's empty
      if(empty($_POST['title'])) {
      $errors['title'] = "A title is required.";
    } else {
      // 4. Server side validation for every field using filter or reg ex
      $title = $_POST['title'];
      		if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
            $errors['title'] = 'The title must be numbers and letters only.';
		  }
    }
    if(empty($_POST['artist'])) {
      $errors['artist'] = "An artist is required.";
    } else {
      $artist = $_POST['artist'];
      if(!preg_match('/^[a-zA-Z\s]+$/', $artist)){
        $errors['artist'] = 'The artist must be numbers and letters only.';
    }
  }

    if(empty($_POST['songs'])) {
      $errors['songs'] = "At least one song is required.";
    } else {
      $songs = $_POST['songs'];
      if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $songs)){
        $errors['songs'] = 'The songs must be a comma separated list';
      }
    }
    if(empty($_POST['price'])) {
      $errors['price'] = "A price is required.";
    } else {
      $price = $_POST['price'];
      if(!filter_var($price, FILTER_VALIDATE_INT)) {
        $errors['price'] = 'The price must be an integer.';
      }
    }

    // 8. Check if there are errors and redirect user
    if(array_filter($errors)){
      // echo "there are errors in the form";
    } else {
      // 9. escape sql characters - protecting the database (instead of PDO prepared statements)
      $title = mysqli_real_escape_string($conn, $_POST['title']);
      $artist = mysqli_real_escape_string($conn, $_POST['artist']);
      $songs = mysqli_real_escape_string($conn, $_POST['songs']);
      $price = mysqli_real_escape_string($conn, $_POST['price']);

      // 10. create sql query
      $sql = "INSERT INTO albums(title,artist,songs,price) VALUES('$title', '$artist', '$songs', '$price')";

      // 11. Save to DB and check
      if(mysqli_query($conn, $sql)){
        // success
        header('Location: index.php');
      } else {
        // error
        echo 'query error: ' . mysqli_error($conn);
      }

    }
  }
?>

<?php include('templates/header.php'); ?>
<div class="container mt-3">
  <h3>Add CD</h3> 
  <form action="add.php" method="POST">
    <div class="mb-3">
        <label for="artist" class="form-label">Artist</label>
        <input type="text" class="form-control" id="artist" name="artist" value="<?php echo htmlspecialchars($artist); ?>">
        <div class="text-danger"><?php echo $errors['artist']; ?></div>
    </div>
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <!-- 7. Keep input value in form fields -->
      <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
      <div class="text-danger"><?php echo $errors['title']; ?></div>
    </div>
    <div class="mb-3">
      <label for="songs" class="form-label">Songs (comma separated)</label>
      <input type="textarea" class="form-control" id="songs" name="songs" value="<?php echo htmlspecialchars($songs); ?>">
      <div class="text-danger"><?php echo $errors['songs']; ?></div>
    </div>
    <div class="mb-3">
      <label for="price" class="form-label">Price</label>
      <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">
      <div class="text-danger"><?php echo $errors['price']; ?></div>
    </div>

    <input type="submit" class="btn btn-sm btn-primary" name="submit" value="Submit">
  </form>
</div>
<?php include('templates/footer.php'); ?>