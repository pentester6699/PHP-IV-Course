<?php
	
	require_once 'dbconfig.php';

	


	if(isset($_POST['btnsave']))
	{
		$name = $_POST['name'];
		$lastName = $_POST['lastName'];
		$mobile = $_POST['mobile'];
		$address = $_POST['address'];
		
		
		
		if(!isset($errMSG))
		{

			$stmt = $DB_con->prepare('INSERT INTO students(name, lastName, mobile, address) 
			VALUES(:name, :lastName, :mobile, :address)');
			$stmt->bindParam(':name',$name);
			$stmt->bindParam(':lastName',$lastName);
			$stmt->bindParam(':mobile',$mobile);
			$stmt->bindParam(':address',$address);

			
			if($stmt->execute())
			{
				$successMSG = "სტუდენტი წარმატებით დაემატა...";
				header("refresh:5; /index.php");
			}
			else
			{
				$errMSG = "დაფიქსირდა შეცდომა სტუდენტის დამატებისას...";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head> 
<title> LUKA - სტუდენტის დამატება </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include ('template/css.php'); ?>
</head>


<body>



<div class="container" style="margin-top: 20px;">

<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>   

<form id="form1" method="post" enctype="multipart/form-data">


		<div class="form-group">
        <input type="text"required autocomplete="off" name="name" class="form-control" id="name" placeholder="სახელი">
        </div>

		<div class="form-group">
        <input type="text"required autocomplete="off" name="lastName" class="form-control" id="lastName" placeholder="გვარი">
        </div>

		<div class="form-group">
        <input type="text"required autocomplete="off" name="mobile" class="form-control" id="mobile" placeholder="ტელეფონის ნომერი">
        </div>

		
		<div class="form-group">
       	<textarea required autocomplete="off" name="address" cols="120" rows="10" class="form-control" placeholder="მისამართი"></textarea>
	   	</div>


             
		   <div class="form-group">
			<button class="btn btn-success" type="submit" name="btnsave" id="submit" value="დამატება"/>დამატება</button> 
             </div>                  

         </form> 





<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">სახელი</th>
      <th scope="col">გვარი</th>
      <th scope="col">ტელეფონი</th>
      <th scope="col">მისამართი</th>
    </tr>
  </thead>
  <tbody>

  <?php
	$stmt2 = $DB_con->prepare('SELECT * FROM students ORDER BY id ASC');
	$stmt2->execute();
	if($stmt2->rowCount() > 0)
		{
		    while($stud=$stmt2->fetch(PDO::FETCH_ASSOC))
		{
		extract($stud);
	?>
    <tr>
      <th scope="row"><?php echo $stud['id']; ?></th>
      <td><?php echo $stud['name']; ?></td>
      <td><?php echo $stud['lastName']; ?></td>
      <td><?php echo $stud['mobile']; ?></td>
      <td><?php echo $stud['address']; ?></td>
    </tr>

	<?php
            }
        }
	?>



  </tbody>
</table>


</div><!-- end container -->

<?php include ('template/javascript.php'); ?>
</body>
</html>                        
