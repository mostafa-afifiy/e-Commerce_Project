<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="logo">
            <a href="dashboard.php" class="logo">e-Commerce</a>
        </div>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="nav navbar-nav">
                <li><a href="<?= $title == "Dashboard" ? '#' : "dashboard.php"; ?>">Home</a></li>
                <li><a href="<?= $title == "Items" ? '#' : "items.php"; ?>">Items</a></li>
                <li><a href="<?= $title == "Categories" ? '#' : "categories.php?do=Manage"; ?>">Categories</a></li>
                <!-- <li><a href="<?= $title == "Members" ? '#' : "members.php"; ?>">Members</a></li> -->
                <li><a href="<?= $title == "Comments" ? '#' : "comments.php"; ?>">Comments</a></li>
               <?= $title == "Dashboard" ? "<li><a href='logout.php'>Logout</a></li>" : ''; ?>
            </ul>
        </div>
    </div>
    </nav>