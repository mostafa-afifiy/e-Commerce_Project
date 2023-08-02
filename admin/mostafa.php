 <?php 
 $stringNumber = "123";
 var_dump($stringNumber) . "<BR>";
 $integerNumber = (int)$stringNumber;
 var_dump($integerNumber);
 echo $integerNumber; // Output: 123
 
 ?>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="logo">
            <a href="dashboard.php" class="logo">e-Commerce</a>
        </div>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="nav navbar-nav">
                <li><a <?= $title == "Dashboard" ? "class='active'" : ""; ?> href="<?= $title == "Dashboard" ? '' : "dashboard.php"; ?>">Home</a></li>
                <li><a <?= $title == "Categories" ? "class='active'" : ""; ?> href="<?= $title == "Categories" ? '' : "categories.php"; ?>">Categories</a></li>
                <li><a <?= $title == "Members" ? "class='active'" : ""; ?> href="<?= $title == "Members" ? '' : "members.php"; ?>">Members</a></li>
                <li><a <?= $title == "Comments" ? "class='active'" : ""; ?> href="<?= $title == "Comments" ? '' : "comments.php"; ?>">Comments</a></li>
            </ul>
        </div>
    </div>
    </nav>

    $theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>
						<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>