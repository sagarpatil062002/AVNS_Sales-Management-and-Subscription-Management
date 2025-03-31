<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Super_Admin Dashboard Panel</title>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
               <img src="images/logo.png" alt="">
            </div>
            <span class="logo_name">AVNS</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="#">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <li><a href="#">
                <i class="uil uil-user"></i>
                    <span class="link-name">User Management</span>
                </a></li>
                <li><a href="add_product.php">
                <i class="uil uil-box"></i>
                    <span class="link-name">Product Management</span>
                </a></li>
                <li><a href="#">
                <i class="uil uil-ticket"></i>
                    <span class="link-name">Ticket Management</span>
                </a></li>
                <li><a href="#">
                <i class="uil uil-receipt"></i>
                    <span class="link-name">Subscription Management</span>
                </a></li>
                <li><a href="#">
                <i class="uil uil-clipboard"></i>
                    <span class="link-name">Order Management</span>
                </a></li>
                <li><a href="#">
                <i class="uil uil-laptop"></i>
                    <span class="link-name">Freelancer Management</span>
                </a></li>
            </ul>

            <ul class="logout-mode">
                <li><a href="logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>
                <li>
                  <div class="mode-toggle">
                    <span class="switch"></span>
                  </div>
                </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>
                <div class="boxes">
                    <!-- New boxes for User and Product counts -->
                    <div class="box box4">
                        <i class="uil uil-users-alt"></i>
                        <span class="text">Total Users</span>
                        <span class="number" id="total-users">Loading...</span>
                    </div>
                    <div class="box box5">
                        <i class="uil uil-box"></i>
                        <span class="text">Total Products</span>
                        <span class="number" id="total-products">Loading...</span>
                    </div>
                </div>
            </div>
            <!-- Removed Recent Activity section -->
        </div>
    </section>

    <!-- Include script.js -->
    <script src="script.js"></script>

    <!-- Alternatively, include the JavaScript directly in the HTML -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('get_counts.php') // This URL should return the counts in JSON format
            .then(response => response.json())
            .then(data => {
                document.getElementById('total-users').innerText = data.totalUsers;
                document.getElementById('total-products').innerText = data.totalProducts;
            })
            .catch(error => console.error('Error fetching counts:', error));
    });
    </script>
    
</body>
</html>
