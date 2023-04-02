<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Personal Website</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/about.php">About</a></li>
            <li><a href="/blog.php">Blog</a></li>
            <li><a href="/contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<main>
    <section>
        <h1>Welcome to My Personal Website</h1>
        <p>Thank you for visiting my website. Here, you can learn more about me and my interests.</p>
    </section>

    <section>
        <h2>About Me</h2>
        <p>My name is John Doe and I am a web developer. I have been working in this field for over 10 years and have experience with HTML, CSS, JavaScript, and PHP.</p>
    </section>

    <section>
        <h2>My Blog</h2>
        <?php
        // Connect to the database
        $db_host = 'localhost';
        $db_name = 'my_blog';
        $db_user = 'username';
        $db_pass = 'password';

        try {
            $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        // Retrieve the blog posts
        $stmt = $db->query('SELECT * FROM posts ORDER BY date DESC');

        // Display the blog posts
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<article>';
            echo '<h3>' . $row['title'] . '</h3>';
            echo '<p>' . $row['content'] . '</p>';
            echo '<p>Posted on ' . $row['date'] . '</p>';
            echo '</article>';
        }
        ?>
    </section>

    <section>
        <h2>Contact Me</h2>
<?php
// Handle the form submission
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate the form data
    $errors = array();
    if(empty($name)) {
        $errors[] = 'Name is required';
    }
    if(empty($email)) {
        $errors[] = 'Email is required';
    }
    if(empty($message)) {
        $errors[] = 'Message is required';
    }

    // Send the email
    if(empty($errors)) {
        $to = 'youremail@example.com';
        $subject = 'New message from your website';
        $message = "Name: $name\nEmail: $email\nMessage: $message";
        $headers = "From: $email\r\n" .
            "Reply-To: $email\r\n" .
            "X-Mailer: PHP/" . phpversion();

        if(mail($to, $subject, $message)) {
            echo '<p>Your message has been sent. Thank you!</p>';
        } else {
            echo '<p>There was an error sending your message. Please try again later.</p>';
        }
    } else {
        echo '<ul>';
        foreach($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
    }
}
?>
        <form method="post">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <div>
                <button type="submit" name="submit">Send</button>
            </div>
        </form>
    </section>
</main>
<footer>
    <p>&copy; 2023 My Personal Website</p>
</footer>
</body>
</html>