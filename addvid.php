<?php
  $title = "Add Video";
  include('header.php');
  include('includes/library.php');
  $pdo = & dbconnect();


if (isset($_POST['submit'])) {
    
    $errors=array();

    //get, validate movie title, min length
    $movie_title=$_POST['movie_title'];
    if(!$movie_title || strlen($movie_title)>100)
      $errors[]="<h2>Movie title must be between 1-100 characters</h2>";

    //get, validate star rating
    $star_rating=$_POST['star_rating'];
    if(!$star_rating || $star_rating>5)
      $errors[]="<h2>Star rating must be between 1-5</h2>";

    //get, validate genre
    $genrearray = array();
    if(!$_POST['movie_genre']){
    $errors[]="<h2>Please select at least one genre</h2>";
    }else{
    foreach($_POST['movie_genre'] as $genre_selected){
      $genrearray[] = $genre_selected;
    }
    $genre = implode(", ",$genrearray);
    }

    //get, validate MPAA rating
    $m_rating=$_POST['m_rating'];
    if(!$m_rating)
      $errors[]="<h2>You must enter an MPAA rating</h2>";

    //get, validate year
    $year=$_POST['year'];
    if(!$year || strlen($year)>4)
      $errors[]="<h2>Year must be 4 characters long</h2>";

    //get running time
    $run_time=$_POST['run_time'];
    if(!$run_time || strlen($run_time)>10)
      $errors[]="<h2>Run time must be between 1-10 characters</h2>";
    
    //get, validate theatre release
    $theatre_release=$_POST['theatre_release'];
    if(strlen($theatre_release)>50)
      $errors[]="<h2>Theatre release must not be more than 50 characters</h2>";

    //get, validate dvd release
    $dvd_release=$_POST['dvd_release'];
    if(strlen($dvd_release)>50)
      $errors[]="<h2>DVD release must not be more than 50 characters</h2>";

    //get, validate actors
    $actors=$_POST['actors'];
    if (!$actors || strlen($actors)>100)
      $errors[]="<h2>Actors must be between 1-100 characters</h2>";

    //get, validate studio
    $studio=$_POST['studio'];
    if(strlen($studio)>100)
      $errors[]="<h2>Studio must not be more than 100 characters</h2>";

    //get, validate summary
    $summary=$_POST['summary'];
    if(!$summary|| strlen($summary)>100)
      $errors[]="<h2>Summary must be between 1-100 characters</h2>";

    //get, validate format
    $formatarray = array();
    if (!$_POST['format']){
      $errors[]="<h2>Please select at least one format</h2>";
    }else{
    foreach($_POST['format'] as $format_selected){
      $formatarray[] = $format_selected;
      }
    $format = implode(", ",$formatarray);
    }

$user_id = $_SESSION['userid'];

  
    //check if no errors, push to database
    if(sizeof($errors)==0){

      $sql = "INSERT INTO movies (title, stars, genre, m_rating, year, run_time, theatre_release, dvd_release, actors, studio, summary, format, user_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";  

      $pdo->prepare($sql)->execute([$movie_title, $star_rating, $genre, $m_rating, $year, $run_time, $theatre_release, $dvd_release, $actors, $studio, $summary, $format, $user_id]);


      //redirect
      header('Location: displaydetails.php');
    }else{
      //print errors
      foreach ($errors as $error){
        echo $error;
      }
    }
}

/*
if(isset($_REQUEST['btn_insert']))
{
 try
 {
  $name = $_REQUEST['txt_name']; //textbox name "txt_name"
   
  $image_file = $_FILES["txt_file"]["name"];
  $type  = $_FILES["txt_file"]["type"]; //file name "txt_file" 
  $size  = $_FILES["txt_file"]["size"];
  $temp  = $_FILES["txt_file"]["tmp_name"];
  
  $path="upload/".$image_file; //set upload folder path
  
  if(empty($name)){
   $errorMsg="Please Enter Name";
  }
  else if(empty($image_file)){
   $errorMsg="Please Select Image";
  }
  else if($type=="image/jpg" || $type=='image/jpeg' || $type=='image/png' || $type=='image/gif') //check file extension
  { 
   if(!file_exists($path)) //check file not exist in your upload folder path
   {
    if($size < 5000000) //check file size 5MB
    {
     move_uploaded_file($temp, "upload/" .$image_file); //move upload file temperory directory to your upload folder
    }
    else
    {
     $errorMsg="Your File To large Please Upload 5MB Size"; //error message file size not large than 5MB
    }
   }
   else
   { 
    $errorMsg="File Already Exists...Check Upload Folder"; //error message file not exists your upload folder path
   }
  }
  else
  {
   $errorMsg="Upload JPG , JPEG , PNG & GIF File Formate.....CHECK FILE EXTENSION"; //error message file extension
  }
  
  if(!isset($errorMsg))
  {
   $insert_stmt=$db->prepare('INSERT INTO tbl_file(name,image) VALUES(:fname,:fimage)'); //sql insert query     
   $insert_stmt->bindParam(':fname',$name); 
   $insert_stmt->bindParam(':fimage',$image_file);   //bind all parameter 
  
   if($insert_stmt->execute())
   {
    $insertMsg="File Upload Successfully........"; //execute query success message
    header("refresh:3;index.php"); //refresh 3 second and redirect to index.php page
   }
  }
 }
 catch(PDOException $e)
 {
  echo $e->getMessage();
 }
}
*/

?>

  <body>
    <div class="container">
      <h1>Add Movie</h1>
        <form id="addmov" name="addmov" method="post">
        <!-- :D Finished -->
        <div class="form-element">
          <label for="title">Title:</label>
          <input type="text" name="movie_title" id="movie_title" maxlength="100"/>
        </div>
        <!-- Later when javascript -->
        <!--<div class="form-element">
          <label for="star_rating">Star Rating:</label>
          <div class="star_rating">
            <span class="fa fa-star" name="star_rating" id="1"></span>
            <span class="fa fa-star" name="star_rating" id="2"></span>
            <span class="fa fa-star" name="star_rating" id="3"></span>
            <span class="fa fa-star" name="star_rating" id="4"></span>
            <span class="fa fa-star" name="star_rating" id="5"></span>
          </div>
        </div>-->
        <!-- :D Finished -->
        <div>
          <label for="star_rating">Star rating (1-5):</label>
          <input type="text" name="star_rating" id="star_rating">
        </div>
        <div class="form-element">
          <label>Genre:</label>
          <div class="genre">
            <div class="criteria-element">
              <label>Action</label>
              <input type="checkbox" name="movie_genre[]" value="Action">
            </div>
            <div class="criteria-element">
              <label>Adventure</label>
              <input type="checkbox" name="movie_genre[]" value="Adventure">
            </div>
            <div class="criteria-element">
              <label>Comedy</label>
              <input type="checkbox" name="movie_genre[]" value="Comedy">
            </div>
            <div class="criteria-element">
              <label>Crime</label>
              <input type="checkbox" name="movie_genre[]" value="Crime">
            </div>
            <div class="criteria-element">
              <label>Drama</label>
              <input type="checkbox" name="movie_genre[]" value="Drama">
            </div>
            <div class="criteria-element">
              <label>Epic/Historical</label>
              <input type="checkbox" name="movie_genre[]" value="Epic">
            </div>
            <div class="criteria-element">
              <label>Horror</label>
              <input type="checkbox" name="movie_genre[]" value="Horror">
            </div>
            <div class="criteria-element">
              <label>Musical</label>
              <input type="checkbox" name="movie_genre[]" value="Musical">
            </div>
            <div class="criteria-element">
              <label>Science Fiction</label>
              <input type="checkbox" name="movie_genre[]" value="Sci-Fi">
            </div>
            <div class="criteria-element">
              <label>War</label>
              <input type="checkbox" name="movie_genre[]" value="War">
            </div>
            <div class="criteria-element">
              <label>Western</label>
              <input type="checkbox" name="movie_genre[]" value="Western">
            </div>
          </div>
        </div>
        <!-- :D Finished -->
        <div class="form-element">
          <label for="MPAA_rating">MPAA Rating:</label>
          <div class="MPAA_rating">
            <div class="criteria-element">
              <label for="g"><img src="./images/G.png" alt="General Audiences" height=20px></label>
              <input type="radio" name="m_rating" id="g" value="g"/>
            </div>
            <div class="criteria-element">
              <label for="pg"><img src="./images/PG.png" alt="Parental Guidance" height=20px></label>
              <input type="radio" name="m_rating" id="pg" value="pg"/>
            </div>
            <div class="criteria-element">
              <label for="13"><img src="./images/PG-13.png" alt="PG 13" height=20px></label>
              <input type="radio" name="m_rating" id="13" value="13"/>
            </div>
            <div class="criteria-element">
              <label for="r"><img src="./images/R.png" alt="Restricted" height=20px></label>
              <input type="radio" name="m_rating" id="r" value="r"/>
            </div>
            <div class="criteria-element">
              <label for=" nc"><img src="./images/NC-17.png" alt="No children under 17" height=20px></label>
              <input type="radio" name="m_rating" id="nc" value="nc"/>
            </div>
          </div>
        </div>

        <div class="form-element">
          <label for="year">Year:</label>
          <input type="number" name="year" min="1900" max="2099" step="1" id="year" />
        </div>

        <div class="form-element">
          <label for="run_time">Running Time (in minutes):</label>
          <input type="number" name="run_time" id="run_time">
        </div>

        <div class="form-element">
          <label for="theatre_release">Theatre Release:</label>
              <input type="text" name="theatre_release" id="theatre_release"/>
        </div>

        <div class="form-element">
          <label for="dvd_release">DVD Release:</label>
              <input type="text" name="dvd_release" id="dvd_release" />
            </div>

        <div class="form-element">
          <label for="actors">Actors:</label>
          <input type="text" name="actors" id="actors" maxlength="100"/>
        </div>

        <div class="form-element">
          <label for="studio">Studio:</label>
          <input type="text" name="studio" id="studio" maxlength="100"/>
        </div>

        <div class="form-element">
          <label for="plot">Plot Summary:</label>
          <input type="textarea" name="summary" rows="8" cols="80" id="summary">
        </div>

        <div class="form-element">
          <label for="vid_type">Video Format:</label>
          <div class="vid_type">
            <div class="criteria-element">
              <label for="DVD">DVD</label>
              <input type="checkbox" name="format[]" value="DVD">
            </div>
            <div class="criteria-element">
              <label for="Blu-Ray">Blu-Ray</label>
              <input type="checkbox" name="format[]" value="Blu-Ray">
            </div>
            <div class="criteria-element">
              <label for="4K-Disk">4k Disk</label>
              <input type="checkbox" name="format[]" value="4K-Disk">
            </div>
            <div class="criteria-element">
              <label for="Digital-SD">Digital SD</label>
              <input type="checkbox" name="format[]" value="Digital-SD">
            </div>
            <div class="criteria-element">
              <label for="Digital-HD">Digital HD</label>
              <input type="checkbox" name="format[]" value="Digital-HD">
            </div>
            <div class="criteria-element">
              <label for="Digital-4K">Digital 4k</label>
              <input type="checkbox" name="format[]" value="Digital-4K">
            </div>
          </div>
        </div>
        












<!--
 <form method="post" class="form-horizontal" enctype="multipart/form-data">
     
 <div class="form-group">
 <label class="col-sm-3 control-label">Name</label>
 <div class="col-sm-6">
 <input type="text" name="txt_name" id="txt_name" class="form-control" placeholder="enter name" />
 </div>
 </div>
         
 <div class="form-group">
 <label class="col-sm-3 control-label">File</label>
 <div class="col-sm-6">
 <input type="file" name="txt_file" id="txt_file" class="form-control" />
 </div>
 </div>
         
 <div class="form-group">
 <div class="col-sm-offset-3 col-sm-9 m-t-15">
 <input type="submit"  name="btn_insert" class="btn btn-success " value="Insert">
 <a href="index.php" class="btn btn-danger">Cancel</a>
 </div>
 </div>
     
</form>

-->











  </div>
        <div class="form-buttons">
          <input type="submit" name="submit" value="Add Movie!">
          <input type="reset" />


        </div>
      </form>
    </div>
  </body>
</html>