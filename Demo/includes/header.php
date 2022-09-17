<?php

echo '
<!-- Put the heading and the introductory message in a div container to keep them together -->
<header>
    <div class="jumbotron text-center container">
        <h1>Car Management System</h1>
        <br><br>
        <p>Welcome to the Car Management System.
            This is where you can register or add your car,
            search for your car, update your details and export or delete your car.</p>
    </div>

    <nav class="container">
        <h3>What would you like to do?</h3>
        <br>
        <div class="nav-links">
            <div class="col-sm-3">
                <a class="btn btn-primary buttons" href="../../Demo/index.php">Add Car</a>
            </div>
            <div class="col-sm-3">
                <a class="btn btn-primary buttons" href="../../Demo/search.php">Search Car</a>
            </div>
            <div class="col-sm-3">
                <a class="btn btn-primary buttons" href="../../Demo/update.php">Update Car</a>
            </div>
            <div class="col-sm-3">
                <a class="btn btn-primary buttons" href="../../Demo/delete.php">Delete Car</a>
            </div>
        </div>
    </nav>

</header>
';
