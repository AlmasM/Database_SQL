<html>
<head>
<title> Courses </title>  
<style>
.error {color: red;}
</style>
</head>
<body>
  <H2><HR> Provide some information </HR></H2>
     

<?php
	
	/*-------------- connect, check and use database: courseSuggest ----------- */
   $conn = mysqli_connect("localhost","cs377", "cs377_s17");
   	  
   if (mysqli_connect_errno())            # -----------  check connection error
   {      
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit(1);
   }/*else{
   	print("check");
   } */
   	  
   if ( ! mysqli_select_db($conn, "courseSuggest") )          # Select DB
   {      
      printf("Error: %s\n", mysqli_error($conn));
      exit(1);
   }
   
   /*-------------- SETTING VARIABLES  ----------- */
   $semester = "";
   $year = "";
   $yearErr = "";
   $semesterErr = "";
   $major = "";
   $majorErr = "";
   $major2 = "";
   $minor = "";
   $course = array();
   $currSemester = "S";
   $currYear = 2017;
   



   
   
   
   /*-------------- Getting user input  ----------- */
   
   		if (empty($_POST["year"])) {
    		$yearErr = "Year is required";
  		  	} else {
    			$year = test_input($_POST["year"]);
    		// check if year is valid
    		$year = (int)$year;
    		if ($year <= $currYear || $year >= 2030) {
      			$yearErr = "Invalid year"; 
    		}
  		}
   
   		if (empty($_POST["semester"])) {
    		$semesterErr = "* Semester is required<br>";
  		} else {
  			$semester = test_input($_POST["semester"]);
  			
  			if($semester == $currSemester){
    			$semesterErr = "* Invalid semester<br>";
    		}
    		
  		}
  		
  		if (empty($_POST["major1"])) {
    		$majorErr = "<br> * Major is required<br>";
  		}else{
  			$major = test_input($_POST['major1']);
  		}
  		
  		if ($_POST["major2"] != "No") {
    		$major2 = $_POST['major2'];
    	}else{
    		$major2 = "No";
    	}
    	
    	if ($_POST["minor"] != "No") {
    		$minor = $_POST['minor'];
    	}else{
    		$minor = "No";
    	}
    	
    	$course = $_POST['course'];

    	
   
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
   
	
?>
	
	<! -------------- FORM ----------- >
	<p><span class="error">* required field.</span></p>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
	
    <! -------------- YEAR ----------- >
  	
    <p>Enter expected graduation year: <input type="text" name="year" value="<?php echo $year;?>">
    <span class="error">* <?php echo $yearErr;?></span>
	
    <! -------------- Semester ----------- >
  	<p>Choose semester (Current semester: 
  	<?php if($currSemester == "S") { echo "Spring";}else{ echo "Fall";}?>):

   	<br><input type='radio' name='semester' value='F'> Fall <br> 
   	<input type='radio' name='semester' value='S'> Spring <br> 
   	<span class="error"> <?php if($semester == "S" && $year == 2017){ echo $semesterErr;}?></span>


    <! -------------- Major ----------- >
<?php
   $query = 'select * from degree';
    
   if ( ! ( $result = mysqli_query($conn, $query)) )
   {
      printf("Error: %s\n", mysqli_error($conn));
      exit(1);
   }/*else{
   	print("\ncheck query\n");
   }*/
   
   print("<br>Choose major: ");
   print('<select name ="major1">');
   print('<option value="">Select</option>');
      while ( ( $row = mysqli_fetch_assoc( $result ) ) != NULL )
   { 
      foreach ($row as $key => $value)
      {
      	if($key == "majorName"){
          print($key . " = " . $value . "\n");
          print("<option value=".$value.">".$value."</option>");
          } 
      }
   } 
?>

	</select>
	<span class="error">* <?php echo $majorErr;?></span>



	<! -------------- 2ND MAJOR ----------- >
	<?php 
		
	   $query = 'select * from degree where majorName != "$major"';
	   

		if ( ! ( $result = mysqli_query($conn, $query)) )
		{
		  printf("Error: %s\n", mysqli_error($conn));
		  exit(1);
		}/*else{
		print("\ncheck query\n");
		}*/

		print("<br>Do you have 2nd Major? (Optional): ");
		print('<select name ="major2">');
		print('<option value="No">No</option>');
		  while ( ( $row = mysqli_fetch_assoc( $result ) ) != NULL )
		{ 
		  foreach ($row as $key => $value)
		  {
			if($key == "majorName"){
			  print($key . " = " . $value . "\n");
			  echo "<option value=".$value.">".$value."</option>";
			  } 
		  }
		} 
	?>

		</select>
	
	
		<! -------------- Minor ----------- >

	<?php 	
	  
		   $query = 'select distinct minorName from minor';

			if ( ! ( $result = mysqli_query($conn, $query)) )
			{
			  printf("Error: %s\n", mysqli_error($conn));
			  exit(1);
			}/*else{
			print("\ncheck query\n");
			}*/

			print("<br>Do you have Minor? (Optional): ");
			print('<select name ="minor">');
			print('<option value="No">No</option>');
			  while ( ( $row = mysqli_fetch_assoc( $result ) ) != NULL )
			{ 
			  foreach ($row as $key => $value)
			  {
				if($key == "minorName"){
				  print($key . " = " . $value . "\n");
				  echo "<option value=".$value.">".$value."</option>";
				  } 
			  }
			} 
		?>

		</select>
	
	   	
   	<?php
   		$tripleMajorError = 0;
   			
		if($major2 != "No" && $minor != "No"){
			$tripleMajorError = 1;
			print("<p><span class='error'>You can't choose 2 majors and a minor</span></p>");
		
		}
		
		if($major === $major2){
			$tripleMajorError = 1;
			print("<p><span class='error'>You picked same major twice</span></p>");
		}
	?>
	
	
	<! -------------- courses taken ----------- >

<?php
	  $query = 'select * from course';
  
	  if ( ! ( $result = mysqli_query($conn, $query)) )
	   {
		  printf("Error: %s\n", mysqli_error($conn));
		  exit(1);
	   }
   
	   print("<br><br>Check classes you already took: <br>");
		while ( ( $row = mysqli_fetch_assoc( $result ) ) != NULL )
		{ 
		  foreach ($row as $key => $value)
		  {
			if($key == "courseNum"){
			   // print ($key . " = " . $value . "\n");
			  echo "<input type='checkbox' name='course[]' value='$value'> $value <br>";
			  }
		  
		  }
		}
	
?>

	<! -------------- END OF FORM ----------- >
	<p><input type="submit" value="Submit">
   	</form>
   	
   	

   	<! -------------- PRINTING SOME OF THE USER INPUT TO CHECK ----------- >
	
<?php

	print("<br> Semester: ". $semester);
    print("<br> Year: ". $year);
  	print("<br> Major 1: ". $major);
  	print("<br> Major 2: ". $major2);
  	print("<br> Minor: ". $minor);
  	$cnt = count($course);
  	echo("<br> Course count: ". $cnt. "<br>");
  	
  	echo "<br>Classes you already took: ";
  	echo '<pre>'; print_r($course); echo '</pre>';
  	
// 	if(empty($course)){
// 		echo("<br>You didn't select classes");
// 	}else{
// 		for($i = 0; $i < $cnt; $i++){
// 			echo("<br>". $course[$i]. " ");
// 		}
// 	}

?>



	<! -------------- CHECK COURSES FOR ERRORS (I.E. SATISFACTION OF REQS)----------- >

<?php

	  $query = 'select * from preQ';
  
	  if ( ! ( $result = mysqli_query($conn, $query)) )
	   {
		  printf("Error: %s\n", mysqli_error($conn));
		  exit(1);
	   }
	   
	   	$arrayPreReq = array();
	   	
	   	 
	   	while (list($row, $column) = mysqli_fetch_array( $result ))
		{ 
			$arrayPreReq[$row][] = $column;
		}
	   
	   $Tcourse = array();
	   	foreach($course as $keyCourse => $valueCourse){
				$Tcourse = checkReqs($valueCourse, $arrayPreReq["$valueCourse"] , $Tcourse);
	   	}
// 		
// 		print("<br>___All the courses____");
// 		echo '<pre>'; print_r($arrayPreReq); echo '</pre>';
		

function checkReqs($class, $classArray, $Tcourse){		

	foreach($classArray as $key => $value){
		
		if($value == null){
			array_push($Tcourse, trim($class));
		}else if(in_array(trim($value), $Tcourse)){
			array_push($Tcourse, trim($class));
		}else if(!in_array($value, $Tcourse)){
			#remove from array
			$Tcourse = array_diff($Tcourse, array($class));
			print("<br> You couldn't have taken $class without $value. Please, pick classes again <br>");
		}
	
	}
	return $Tcourse;
}

?>

  
	<! -------------- GET SEMESTER OFFERED ----------- >

<?php
	function populateOffered($conn){
	  
	  $arrayOffered = array();
		
	  $query = 'select * from offered';
  
	  if ( ! ( $result = mysqli_query($conn, $query)) )
	   {
		  printf("Error: %s\n", mysqli_error($conn));
		  exit(1);
	   }
	   
	   	
	   	
	   	 
	   	while (list($row, $column) = mysqli_fetch_array( $result ))
		{ 
			$arrayOffered[$row][] = trim($column);
// 			print("\n Current column is: $column ");

// 			print_r($arrayOffered[$row]);
		}
	   
// 			print_r($arrayOffered);
		return $arrayOffered;

	}
?>


<?php

/* -------------- CALCULATING SEMESTERS -------- */

$left = 0;
$left = $year - $currYear;
	if($semester == 'F'){
		$left = ($left * 2) + 1;
	}else{ $left = $left * 2;}

		print("<br>Semesters left to graduate: " . $left);
?>


	<! -------------- GET REQUIRED COURSES  ----------- >

<?php

		$arrayCourses = array();
		$concat = " '%$major%' ";
		$arrayOffered = populateOffered($conn);
		
		if($tripleMajorError == 0){
			$arrayCourses = getCoursesMajor($conn, $arrayCourses, $concat, $arrayOffered, $arrayPreReq);
// 			print("<br>_______Major 1 Only ________");
// 			echo '<pre>'; print_r($arrayCourses); echo '</pre>';

			If($major2 != "No" && $tripleMajorError == 0){	
				$concat = " '%$major2%' ";
				$arrayCourses = getCoursesMajor($conn, $arrayCourses, $concat, $arrayOffered, $arrayPreReq);
// 				print("<br>_______Major 2 Only ________");	
// 				echo '<pre>'; print_r($arrayCoursesN); echo '</pre>';	
			}else if($minor != "No" && $tripleMajorError == 0){
// 				print("<br> ______ Minor is : $minor");
				$concat = " '%$minor' ";
				$arrayCourses = getCoursesMajor($conn, $arrayCourses, $concat, $arrayOffered, $arrayPreReq);
			}
			
			
		}else if($tripleMajorError == 1){
			print("<br>Error: Specified Triple Majors");
		}

		print("<br><BR>_______ INFORMATION ABOUT THE REQUIRED COURSES YOU HAVE TO TAKE ________");
		echo '<pre>'; print_r($arrayCourses); echo '</pre>';

		
function checkDuplicates($courseName, $finalArray){
	$dupExists = 0;
		foreach($finalArray as $arr){
				$cNumber = $arr-> getCourseNumber();
					if($cNumber == $courseName){
						$dupExists = 1;
					}
		}
		
		return $dupExists;
	}
		
		
//    print_r($arrayOffered);

function getCoursesMajor($conn, $arrayCourses, $concat, $arrayOffered, $arrayPreReq){
		if($concat != " '%$minor' "){
			$newCon = "select corNumb, creditNum, title
				from reqCourses, degree, course
				where reqCourses.maID = degree.majorID and course.courseNum = corNumb
					and majorName LIKE". $concat . ";";
		}else{
			$newCon = "select corNum as corNumb, creditNum, title
				from minorReq, course, (select distinct minorID from minor 
				where minorName LIKE". $concat .") as minorIDT
				where minorIDT.minorID = minorReq.minoID and course.courseNum = corNum;";
		}
//  	print("<br>".$newCon);
	  $queryN = $newCon;
  
	  if ( ! ( $result = mysqli_query($conn, $queryN)) )
	   {
		  printf("Error: %s\n", mysqli_error($conn));
		  exit(1);
	   }
	    



		while ($row = mysqli_fetch_assoc( $result ))
		{ 
		$dubCheck = 0;
		  foreach ($row as $key => $value)
		  {
		  	
// 		  	print ($key . " = " . $value . "\n");
		  	if($key == "corNumb" ){ # 
					
					if(empty($arrayCourses)){
						$x = new CourseInfo();
						$x -> setCourseNumber($value);
						$dubCheck = 0;
					}
					else{
						$dubCheck = checkDuplicates($value, $arrayCourses);
						 if($dubCheck == 0){
							$x = new CourseInfo();
							$x -> setCourseNumber($value);
						  }
					}
			}
			else if($key == "creditNum" && $dubCheck == 0){

				$x -> setCreditNum($value);
			}
			else if($key == "title" && $dubCheck == 0){
				$x ->setTitle($value);
			}
			
		  }
	  		
		 if($dubCheck == 0){
		 	array_push($arrayCourses, $x);
		 }
		  
		  
		}
	
 		
 		
/* -------------- COURSE INFORMATION -------- */
			
			foreach($arrayCourses as $arr){

					foreach($arrayOffered as $key => $value){
						$cNumber = $arr-> getCourseNumber();
						if($key == $cNumber){
							$arr-> setOfferedSem($value);
						}
					}
			}
			
			foreach($arrayCourses as $arr){
				foreach($arrayPreReq as $key => $value){
						$cNumber = $arr-> getCourseNumber();
						if($key == $cNumber){
							$arr-> setPreReqs($value);
						}
					}
			}

		
			return $arrayCourses;
	}	
	
	
	
?>


	<! -------------- Create object ----------- >
<?php

	class CourseInfo{
	
		public $courseNumber = "";
		public $titleCourse = "";
		public $creditNum = "";
		public $offeredSem = array();
		public $preReqs = array();
	
		
		public function setCourseNumber($courseNumber){
			$this->courseNumber = $courseNumber;
		}
		
		function getCourseNumber(){
		 	return $this->courseNumber;
		}
		
		public function setTitle($titleCourse){
			$this->titleCourse = $titleCourse;
		}
		
		public function setCreditNum($creditNum){
			$this-> creditNum = $creditNum;
		}
		
		
		public function setOfferedSem($offeredSem){
			$this -> offeredSem = $offeredSem;
		}
		public function getOfferedSem(){
			return $this -> offeredSem;
		}
		
		public function setPreReqs($preReqs){
			$this  -> preReqs = $preReqs;
		}
		
		public function getPreReqs(){
			return $this -> preReqs;
		}
		
		
		public function addSemester($offeredSem, $obj){
			array_push($offeredSem, $obj);
		}
		
		public function addPreReqs($preReqs, $objP){
			array_push($preReqs, $objP);
		}
		
		
		
		
	}

?>


<?php
 /* -------------- course planner -------- */
 
courseRequirements($left, $currSemester, $semester, $arrayCourses);

function courseRequirements($left, $currSem, $endSem, $arrayCourses){
	
// 	print("$left");
	$schedule = array();
	$satClasses = array();
	$unsatClasses = array();
	
	echo " <br>___________COURSES EVERY SEMESTER UNTIL GRADUATION___________";
	
	if($currSem == "S"){
		$currSem = "F";
	}else{
		$currSem = "S";
		}

	for ($x = 0; $x <= $left; $x++) {
	  	

		$cTemp = new scheduleSem();
		$cTemp -> setSemNum($x);
		$cTemp -> setSemType($currSem);
		array_push($schedule, $cTemp);
		
		if($x % 2 == 1){
			$currSem = "F";
		}else{
			$currSem = "S";
		}
	}
	
	$allReqCourses = array();
	$allReqCourses = $arrayCourses;
	
	
	foreach($schedule as $currSemester){
		$tempSem = $currSemester-> getSemCourses();
		$tempCount = $currSemester -> getCount();
		$tempSemType = $currSemester -> getSemType();
		$currentSemester = $currSemester -> getSemNum();
		
		foreach($allReqCourses  as $arr){
			$cNumber = $arr-> getCourseNumber();
			$semTypeCourse = $arr->getOfferedSem();
			$tempPreReqs = $arr -> getPreReqs();
		
		
			array_push($unsatClasses, $cNumber);
		

		
// 		print_r($tempPreReqs);

			
			$tempBool = crsCheck($satClasses, $tempPreReqs, trim($cNumber));
			
			
			
			$season = comparingManual($semTypeCourse, $tempSemType);
			
			if($tempCount < 4 && !in_array($cNumber, $satClasses) 
				&& $season == $tempSemType && $tempBool){
				
				array_push($tempSem, $cNumber);
				
				
				$currSemester -> setSemCourses($tempSem);
			
				array_push($satClasses, trim($cNumber));

				$allReqCourses = deleteKey($cNumber, $allReqCourses);

				
				$unsatClasses = array_diff($unsatClasses, array($cNumber));
				
				$tempCount++;
				$currSemester -> setCount($tempCount);	
			}else if(in_array($cNumber, $unsatClasses)){
				break;
			}

		}
	}
	
		echo '<pre>'; print_r($schedule); echo '</pre>';
		
		
		
		
		if(!empty($unsatClasses)){
			echo "<br> WARNING: You can't graduate on time. You have following classes
			that prevent you from graduating";
			print_r($unsatClasses);
		}
		

}	

function deleteKey($cNumber, $entireArr){

	foreach($entireArr as $arr){
		foreach($arr as $key => $value){
			if($value == trim($cNumber)){
// 				print("<br> _______HERE");
				$indexD = key($entireArr);
// 				print("<br> $indexD is:");
			}
		}
	}
// 	print("<br> key to remove is: $indexD");
	unset($entireArr[$indexD]);
	
	return $entireArr;
	
}

 function crsCheck($satClasses, $tempPreReqs, $cNumber){
	
	$boolK = true;


	
	foreach($tempPreReqs as $key => $value){
// 		print("<br> value to satisfy is: $value");
		
		if($value == null){
		 	return true;
		}else{
			foreach($satClasses as $satK=> $satV){
// 				print("<br> satV  is: $satV and value is: $value");
					if(trim($satV) == trim($value)){
// 						print($boolK);
						$boolK = true;
						break;
					}else{
// 						print("<br> __________ENTER");
					 	$boolK = false;
					}
			}
			 
			
		}
	}
// 	
// 	print("Currently checking $cNumber and result it: $boolK_");
// 	print("<br> ____");
	return $boolK;
	
	
 }
	
	

	
function comparingManual($semTypeCourse, $tempSemType){
	if(strcmp($semTypeCourse[0], $tempSemType) == 0){
		return $tempSemType;
	}else if(strcmp($semTypeCourse[1], $tempSemType) == 0){
		return $tempSemType;
	}
}


class scheduleSem{
	public $semNum  = 0;
	public $semType = "";
	public $classCount = 0;
	public $semCourses = array();
	
	public function setSemNum($semNum){
			$this->semNum = $semNum;
	}
	
	public function getSemNum(){
		return $this->semNum;
	}
	
	
	
	public function setSemType($semType){
			$this->semType = $semType;
	}
	
	public function getSemType(){
		 return $this->semType;
	}
	
	public function getCount(){
		return $this->classCount;
	}
	
	public function setCount($classCount){
		$this->classCount = $classCount;
	}
	
	
	public function setSemCourses($semCourses){
		$this->semCourses = $semCourses;
	}
	
	public function getSemCourses(){
		return $this->semCourses;
	}
	
	

}	

?>


<?php   
 /* -------------- close connection -------- */
   
  mysqli_free_result($result);
  
  mysqli_close($conn);
?>
	   

	

</body>
</html>