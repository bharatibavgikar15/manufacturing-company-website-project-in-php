<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$username = "bharati1"; // Replace with your database username
$password = "arti"; // Replace with your database password
$dbname = "axesglow"; // Replace with your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];
    
    // Insert data into database using prepared statements
    $sql = "INSERT INTO enquiries (name, email, phone, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $message);
    
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $stmt->close();
    $conn->close();

    // Displaying the submitted data (you can replace this with your desired action)
    echo "Name: " . $name . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Phone: " . $phone . "<br>";
    echo "Message: " . $message . "<br>";

    // Check if the name is "login" (you can modify this condition as per your requirements)
    if ($name == "login") {
        header("Location: login.html"); // Redirect to login.html
        exit; // Stop further execution
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- cdn fonawsam  -->
    <script src="https://kit.fontawesome.com/3477ae541c.js" crossorigin="anonymous"></script>
    <!-- swipper cdn  -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/style.css">
    <title> Axesglow</title>
</head>
<body>
    <!-- header  -->
    <header class="header">
        <a href="#home" class="logo">Axesglow</a>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#services">services</a>
            <a href="#portfolio">careers</a>
            <a href="#contact">contact</a>
        </nav>
        <i class="fa-solid fa-bars"></i>
    </header>
    <!-- /header  -->
    <!-- home  -->
    <div class="home" id="home">
        <div class="swiper home-slid">
            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <div class="image">
                        <img src="img/hero-carousel/1.png" alt="image">
                    </div>
                    <div class="content">
                        <h3>Axes Glow</h3>
                        <p>To provide reliable & cost effective manufacturing solution for global market </p>
                        <a href="login.php" class="btn">get start</a>
                    </div>
                </div>

                

                
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
    </div>
    <!-- /home  -->
    <!-- about  -->
    <section class="about" id="about">
        <div class="heading">
            <h2>about Business</h2>
            <div></div>
        </div>

        <div class="box">
            <div class="image">
                <img src="img/about/1.jpg" alt="image">
            </div>
            <div class="content">
                <h3>PROJECT MAINTENANCE</h3>
                <p>We specialize in Design and machining vmc components like --
                    
                  </p>
                <div>--aluminum   components</div>
                <div>--prototype  component machining</div>
                <div>--packaging  machines parts design and machining</div>
                <div>--die and mould machining and jigs fixture parts machining </div>
            </div>
        </div>
    </section>
    <!-- /about  -->
    <!-- services  -->
    <section class="services" id="services">
        <div class="heading">
            <h2>our services </h2>
            <div></div>
        </div>

        <div class="row">
            <div class="box">
                <i class="fa-solid fa-briefcase"></i>
                <h3>
                    Custom Manufacturing
                </h3>
                <p>From Concept Design To Final Production, We Collaborate Closely With You To Develop Products That Resonate With Your Brand And Exceed Customer Expectations.</p>
            </div>

            <div class="box">
                <i class="fa-solid fa-clipboard-check"></i>
                <h3>
                    Prototyping
                </h3>
                <p>Validate your product ideas quickly and cost-effectively with our rapid prototyping services.</p>
            </div>

            <div class="box">
                <i class="fa-solid fa-chart-column"></i>
                <h3>
                    Production Sourcing
                </h3>
                <p> We partner with trusted suppliers and manufacturers to source high-quality materials and components at competitive prices, ensuring timely delivery and consistent quality.</p>
            </div>

            <div class="box">
                <i class="fa-solid fa-binoculars"></i>
                <h3>
                    Quality Assurance
                </h3>
                <p>Our dedicated team conducts rigorous inspections and tests throughout the manufacturing process to ensure that every product meets or exceeds industry standards.</p>
            </div>

            <div class="box">
                <div class="content">
                    <i class="fa-solid fa-sun"></i>
                    <h3>
                        Logistics and Distribution
                    </h3>
                </div>
                <p>From warehousing and inventory management to shipping and fulfillment, we handle all aspects of logistics to ensure seamless delivery of your products to customers worldwide.</p>
            </div>

            <div class="box">
                <div class="content">
                    <i class="fa-solid fa-calendar"></i>
                    <h3>
                        Consulting and Support
                    </h3>
                </div>
                <p>Whether you need guidance on product development, manufacturing strategies, or market trends, our team is here to assist you every step of the way.</p>
            </div>
        </div>
    </section>
    <!-- /services  -->
    <!-- portfolio  -->
    <div class="portfolio" id="portfolio">
        <div class="heading">
            <h2>Careers</h2>
            <div></div>
        </div>
        <div class="row">

            <div class="box">
                <img src="img/portfolio/1.jpeg" alt="image">
                <div class="content">
                    <h3>
                       Vmc Operator
                    </h3>
                    <p> Operate and maintain Vertical Machining Centers (VMC)</p>
                    <a href="login.php" class="btn">Apply now</a>
                </div>
            </div>

            <div class="box">
                <img src="img/portfolio/2.png" alt="image">
                <div class="content">
                    <h3>
                        Design Engineer 
                    </h3>
                    <p>Utilize solidworks application.</p>
                    <a href="login.php" class="btn">Apply now</a>
                </div>
            </div>

            <div class="box">
                <img src="img/portfolio/3.jpeg" alt="image">
                <div class="content">
                    <h3>
                        Manufacturing engineer
                    </h3>
                    <p>manufacture processess</p>
                    <a href="login.php" class="btn">Apply now</a>
                </div>
            </div>

            <div class="box">
                <img src="img/portfolio/4.jpeg" alt="image">
                <div class="content">
                    <h3>
                        Quality Assurance Inspector
                    </h3>
                    <p>Conduct  inspections, tests, and evaluations.</p>
                    <a href="login.php" class="btn">Apply now</a>
                </div>
            </div>

            <div class="box">
                <img src="img/portfolio/5.jpg" alt="image">
                <div class="content">
                    <h3>
                        Customer Service and Support Specialist
                    </h3>
                    <p>Provide responsive and professional customer service.</p>
                    <a href="login.php" class="btn">Apply now</a>
                </div>
            </div>

            <div class="box">
                <img src="img/portfolio/6.jpeg" alt="image">
                <div class="content">
                    <h3>
                        Accounting 
                    </h3>
                    <p>Allocating and tracking direct costs.</p>
                    <a href="login.php" class="btn">Apply now</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /portfolio  -->
    <!-- team  -->
    
    <!-- blog  -->
    <div class="welcam">
    <span>welcome to our company <a href="login.php" class="btn">start now</a></span>
    </div>
    <!-- .contact  -->
    <section class="contact" id="contact">
        <div class="heading">
            <h2>contact us</h2>
            <div></div>
        </div>
        <div class="box">
            <div class="content">
                <i class="fa-solid fa-mobile-screen"></i>
                <div>call: +91 9763906329</div>
                <div>monday-sunday (9am-spm) </div>
                <div>Thursday (Holiday)</div>
            </div>
            <div class="content">
                <i class="fa-solid fa-envelope"></i>
                <div>email: axesglow@gmail.com</div>
                <div>web: www.axesglow.com</div>
            </div>
            <div class="content">
                <i class="fa-solid fa-location-dot"></i>
                <div>location: India, Maharashtra</div>
                <div>pune</div>
            </div>
        </div>

        <div class="row">
            <div class="ifarm">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3780.4599802138932!2d73.83133657504095!3d18.64334378247417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2b96a5eae1f93%3A0x16c30a456b0e5990!2sAxes%20glow!5e0!3m2!1sen!2sin!4v1711822382194!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>" width="550" height="430" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="form-c">
            <form action="" method="post">
    <input type="text" name="name" placeholder="name">
    <input type="email" name="email" placeholder="email">
    <input type="number" name="phone" placeholder="phone">
    <textarea name="message" id="" cols="30" rows="10"></textarea>
    <input type="submit" value="send message">
</form>
            </div>
        </div>
    </section>
    <!-- /contact  -->
    <!-- footer  -->
    <footer class="footer">
        <div class="content">
            <h3>Business</h3>
            <p>To Provide Reliable & Cost Effective Manufacturing Solution For Global Market</p>
            <div class="shar">
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-youtube"></i>
                <i class="fa-brands fa-twitter"></i>
            </div>
        </div>

        <div class="link">
            <h3>links</h3>
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#services">services</a>
            <a href="#portfolio">portfolio</a>
            <a href="#contact">contact</a>
        </div>

        <div class="our-services">
            <h3>services</h3>
            <a href="#">Precision Milling</a>
            <a href="#">Drilling and Tapping</a>
            <a href="#">Surface Contouring and Profiling</a>
            <a href="#">Fixture and Jig Machining</a>
            <a href="#">Stainless Steel Machining</a>
            <a href="#">Consulting and Process Improvement</a>
        </div>

        <div class="Contact ">
            <h3>Contact</h3>
            <p>+91 9763906329, axesglow@gmail.com</p>
    </footer>
    <!-- /footer  -->
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

