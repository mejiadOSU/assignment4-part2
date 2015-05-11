    <?php
ini_set('display_errors', 'On');
    include 'storedInfo.php';
    
    $table = 'videoStore';
        
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "mejiad-db", $myPassword, "mejiad-db");

if (isset($_POST['newMovie'])){  
    if (!empty($_POST['movieName']) && !empty($_POST['movieCategory']) && 
            !empty($_POST['movieLength']) && ($_POST['movieLength']>0)) {
        echo "Adding movie:";
        $movieName = $_POST['movieName'];
        $movieCategory = $_POST['movieCategory'];
        $movieLength = $_POST['movieLength'];
        echo " $movieName" . " $movieCategory" . " $movieLength";
        
        $sql = "INSERT INTO $table".
                "(name, category, length, rented) ".
                "VALUES('$movieName', '$movieCategory', '$movieLength', 'false')";
        
        if (!mysqli_query($mysqli,$sql)) {
            echo "<br> Error: " . $mysqli->error;
        } else {
            echo "<br>New record created successfully";
          }
        
    }else{
        if (empty($_POST['movieName'])){
            echo "<br>You must enter a movie name.";
        }
        if (empty($_POST['movieCategory'])){
            echo "<br>You must enter a movie category.";
        }
        if (empty($_POST['movieLength'])){
            echo "<br>You must enter a movie length.";
        }elseif ($_POST['movieLength'] < 1){
            echo "<br>Movie length is not correct";
        }
        echo "<br>Please try again.";
    }
}

// SOME OF THIS CODE CAME FROM http://www.w3schools.com/php/php_mysql_delete.asp. I COULDNT THINK OR GET ANY OTHER WAY TO DELETE A RECORD
elseif(isset($_POST['deleteFilm'])) {
    $movieId = $_POST['deleteFilm'];
    echo "$movieId - ";
    $sql = "DELETE FROM $table WHERE id = '$movieId'";

    if ($mysqli->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $mysqli->error;
    }
}

elseif(isset($_POST['checkOut'])){
    $movieId = $_POST['checkOut'];
    echo "$movieId - ";
    $sql = "UPDATE $table SET rented = '0' WHERE id = '$movieId'";
    if ($mysqli->query($sql) === TRUE) {
        echo "Movie successfully returned";
    } else {
        echo "Error returning movie: " . $mysqli->error;
    }
}

elseif(isset($_POST['available'])){
    $movieId = $_POST['available'];
    echo "$movieId - ";
    $sql = "UPDATE $table SET rented = '1' WHERE id = '$movieId'";
    if ($mysqli->query($sql) === TRUE) {
        echo "Movie successfully rented";
    } else {
        echo "Error renting movie: " . $mysqli->error;
    }
}

elseif(isset($_POST['deleteAll'])){

    $sql = "DELETE FROM $table WHERE id = '0' || '1'";
    if ($mysqli->query($sql) === TRUE) {
        echo "All successfully deleted";
    } else {
        echo "Error deleting all: " . $mysqli->error;
    }
}

elseif(isset($_POST['sort'])){
    $value = $_POST['sort'];
    echo "Did not figure out a way to sort by: " . "$value";
}


    echo "<META http-equiv=\"refresh\" content=\"2;URL=http://web.engr.oregonstate.edu/~mejiad/mysql/HTMLPage1.php\">";?>