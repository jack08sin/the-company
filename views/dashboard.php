<?php
    session_start();

    require '../classes/User.php';

    # Create / Instantiate an object
    $user = new User;

    # Call the method (getAllUsers())
    $all_users = $user->getAllUsers();

    // print_r($all_users);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--font awesome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!--bootstrap-->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

     <link rel="stylesheet" href="../assets/css/style.css">

    <title>Dashboard</title>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px;">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">
                <h1 class="h3">The Company</h1>
            </a>

            <div class="navbar-nav">
                <span class="navbar-text"><?=$_SESSION['full_name']?></span>
                <form action="../actions/logout-action.php" class="d-flex ms-2">
                    <button type="submit" class="text-danger bg-transparent border-0">Logout</button>
                </form>
            </div>
        </div>

    </nav>
    <main class="row justify-content-center gx-0">
        <div class="col-6">
            <h2 class="text-center">User List</h2>

            <table class="table table-hover align-middle">
                <thead>
                    <th>Avatar</th>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Edit | Delete</th>
                </thead>

                <tbody>
                    <?php
                        while($user = $all_users->fetch_assoc()){

                    ?>

                        <tr>
                            <td>
                                <?php
                                    if($user['photo']){

                                ?>
                                <img src="../assets/images/<?=$user['photo']?>" alt="<?=$user['photo']?>" 
                                    class="d-block mx-auto dashboard-photo">
                                
                                <?php
                                    } else{
                                        
                                ?>
                                
                                <i class="fa-solid fa-user text-secondary d-block text-center dashboard-icon"></i>

                                <?php
                                    }
                                ?>
                            </td>
                            <td><?=$user['id']?></td>
                            <td><?=$user['first_name']?></td>
                            <td><?=$user['last_name']?></td>
                            <td><?=$user['username']?></td>
                            <td>
                                <?php
                                    if($_SESSION['id'] == $user['id']){ //　ログインしているユーザにのみ操作をさせるため。
                                ?>
                                <a href="../views/edit-user.php" class="btn btn-outline-warning" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="../views/delete-user.php" class="btn btn-outline-danger" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                                
                                <?php
                                    }
                                ?>
                            </td>
                        </tr>

                    <?php
                        }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    
      <!--bootstrap JS link-->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>