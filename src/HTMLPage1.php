    <?php
    /*
     * Danny Mejia PHP assignment 2 MySQL PHP implementation into movie rental store
     * THIS MOVIE STORE CAN OLNY HOLD UP TO 10 CATEGORIES DUE TO CATEGORY ARRAY
    */
    ini_set('display_errors', 'On'); // note out when done
    
    include 'storedInfo.php'; // stores secret code
    $table = 'videoStore'; // table created assosiated with these functions
    $wide = 4; // width of table
    
    $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "mejiad-db", $myPassword, "mejiad-db");
    if ($mysqli->connect_errno){
        echo "Failed to connect to the Video Store database: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
    }else {
        echo "Your connected to the Video Store database!<br><br>";
    }
    
    /*
    // USED TO CREATE THE TABLE AND IDEA FROM THE CLASS VIDEO TUTORIAL
    if (!$mysqli->query("DROP TABLE IF EXISTS videoStore") ||
        !$mysqli->query("CREATE TABLE videoStore(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255)UNIQUE NOT NULL, category VARCHAR(255)NOT NULL, length INT, rented BOOL)") ||
        !$mysqli->query("INSERT INTO videoStore(id, name, category, length, rented) VALUES (1, 'Last Action Hero', 'Action', 230, false)")) {
        echo "Table creation failed: (" . $mysqli->errno . ")" . $mysqli->error;
    }
    */
    
    // THE PRINT TABLE CODE IDEA CAME FROM http://www.anyexample.com/programming/php/php_mysql_example__display_table_as_html.xml
    $result = mysqli_query($mysqli, "SELECT * FROM $table");
    if (!$result){
        echo "Could not query table <br>";
    }else{
    
    echo '<table border = "1";>';
    $count = 0;
    $categoryArray = array (0=>"");
    while ($row = mysqli_fetch_object($result)){
    $arraySize=count($categoryArray);
        for ($k=0; $k<$arraySize; $k++){
        $arraySize = count($categoryArray);
            if ($row->category == $categoryArray[$k]){ // does nothing if category is already here
            }elseif ($row->category != $categoryArray[$k] && ($k+1) == $arraySize){
                array_push($categoryArray, "$row->category");}
        } 
        
        if ($count == 0) {echo '<tr>' . '<td>' . "Movie name" . '<td>' . "Category" 
                .'<td>' . "Length" . '<td>' . "Availability" . '<td>' 
                . "Remove" . '<td>' . "Check in/out";}
                
        if ($row->rented == 1) {$rented = 'checked out'; $rentText = "Return"; $idName = "checkOut";} 
        else {$rented = 'available'; $rentText = "Check out"; $idName = "available";}
        
        $movieId = $row->id;
                echo '<tr>' . '<td>' . $row->name . '<td>' . $row->category . '<td>' . $row->length . '<td>' . $rented
                . '<td>' . "<form id=\"deleteFilm\" action=\"workerFile.php\" method=\"post\">"
                . "<button type=\"submit\" name=\"deleteFilm\" value=$movieId >Delete me</button>"
                . '<td>' . "<form id=$idName action=\"workerFile.php\" method=\"post\">"
                . "<button type=\"submit\" name=$idName value=$movieId >$rentText</button>";
    
        $count++;
    }
    echo '</table>';
    }
    
    // FORM SUBMISSION IDEA IS FROM http://stackoverflow.com/questions/9870838/how-to-submit-a-select-menu-without-a-submit-button USER SARATH TOMY, 2012
    echo "<select name=\"sort\" id=\"list\" action=\"HTMLPage1.php\" onchange='this.form.submit()' >";
    echo "<option value=\"all\" selected>All Movies</option>";
    $j=1;
    do {
       echo "<option value=$categoryArray[$j]>$categoryArray[$j]</option>";
       $j++;
    }while($j <= $arraySize);
    echo "</select>" . " - Sort list by categories<br>";
    
    echo "<br><br>To add a new movie enter all the information below and submit.";
    echo "<br><form id=\"newMovie\" action=\"workerFile.php\" method=\"post\">";
    echo "Name: <input type=\"text\" name=\"movieName\"><br>";
    echo "Category: <input type=\"text\" name=\"movieCategory\"><br>";
    echo "Length: <input type=\"number\" name=\"movieLength\"><br>";
    echo "<input type=\"submit\" name=\"newMovie\">";
    echo "</form>";
    
    echo "<br><br><br><br><form id=\"deleteAll\" action=\"workerFile.php\" method=\"post\">";
    echo "<button type=\"submit\" name=\"deleteAll\">Delete ALL</button>" . " This will delete the entire table";
    
    $mysqli->close();
    ?>

