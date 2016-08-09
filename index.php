<?php
// Set variables
$max_length = 20;
$default_weight = "Medium";
$default_text = "All the buttons!!!";
$original_photo = "photo.jpg";
$photo_dir = "public";

// Process form data
$text = isset($_POST['text']) ? substr($_POST['text'],0,$max_length) : $default_text;
$weight = isset($_POST['weight']) ? $_POST['weight'] : $default_weight;
$filepath = $photo_dir . '/' . md5($text . $weight) . '.jpg';

// Create photo if it doesn't exist
if (!file_exists($filepath)){
  $photo = imagecreatefromjpeg($original_photo);
  $color = imagecolorallocate($photo, 255, 255, 255);
  $font = 'fonts/Lato-' . $weight;

  imagettftext($photo, 25, 10, 205, 255, $color, $font, $text);
  imagejpeg($photo, $filepath, 85);
  imagedestroy($photo);
}

// Respond to ajax request with json
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
   strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
  ){
  header('Content-type: application/json');
  die(json_encode($filepath));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dream Button</title>
  <meta name="description" content="Because everything should be as easy as pushing a button.">
  <meta property="og:title" content="Dream Button" />
  <meta property="og:description" content="Because everything should be as easy as pushing a button.">
  <meta property="og:image" content="https://dreambutton.bhurst.me/photo_default.jpg">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
  <link rel="stylesheet" href="styles.css">
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <div class="container">
    <h2>Dream Button <small>Stock Photo Generator</small></h2>
    <div class="panel panel-default">
      <div class="panel-body">
        <?php if($text !== $default_text){ ?>
        <div class="alert alert-success" role="alert">
          Your Dream Button is ready &mdash; <a class="alert-link" download="<? echo $filepath ?>" href="<? echo $filepath ?>">download it now!</a>
        </div>
        <?php } ?>
        <img src="<? echo $filepath ?>" class="img-responsive" alt="<?php echo htmlspecialchars($text) ?>">
      </div>
      <div class="panel-footer">
        <form class="form-inline" method="POST">
          <div class="form-group">
            <label for="text">Button Text</label>
            <input type="text" class="form-control" name="text" id="text" maxlength="<?php echo $max_length ?>" value="<?php echo htmlspecialchars($text) ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail2">Font Weight</label>
            <select class="form-control" name="weight" id="weight">
              <option <?php if ($weight === "Light"){echo 'selected="selected"';} ?>>Light</option>
              <option <?php if ($weight === "Medium"){echo 'selected="selected"';} ?>>Medium</option>
              <option <?php if ($weight === "Bold"){echo 'selected="selected"';} ?>>Bold</option>
            </select>
          </div>
          <button type="submit" class="btn btn-default">Generate Photo</button>
        </form>
      </div>
    </div>
    <footer class="footer">
      <p>Photo from <a href="https://www.flickr.com/photos/epublicist/22669430823/">Flickr</a>. Fonts from <a href="http://www.latofonts.com/">Lato</a>.</p>
    </footer>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="script.js"></script>
</body>
</html>