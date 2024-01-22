<?php
// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data using the $_POST superglobal
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $message = isset($_POST["message"]) ? $_POST["message"] : "";
    $package = isset($_POST["package"]) ? $_POST["package"] : "";




    // Validate reCAPTCHA
    $recaptchaSecretKey = "6LfpeFYpAAAAAKgywQTtRS2-_YiUTPgIuxUgxJtl"; // Replace with your Secret Key
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";
    $recaptchaData = [
        'secret' => $recaptchaSecretKey,
        'response' => $recaptchaResponse
    ];

    $recaptchaOptions = [
        'http' => [
            'method' => 'POST',
            'content' => http_build_query($recaptchaData)
        ]
    ];

    $recaptchaContext = stream_context_create($recaptchaOptions);
    $recaptchaResult = file_get_contents($recaptchaUrl, false, $recaptchaContext);
    $recaptchaResult = json_decode($recaptchaResult, true);

    if ($recaptchaResult['success']) {
        // Now you can process the data as needed
        // For example, you can echo the values or perform further actions

        // // Example: Echoing the values
        // echo "Email: " . $email . "<br>";
        // echo "Name: " . $name . "<br>";
        // echo "Message: " . $message . "<br>";
        // echo "Package: " . $package . "<br>";





        // Create the email content
        $subject = "New Form Submission";
        $body = "Name: $name\nEmail: $email\nPackage: $package\n\nMessage:\n$message";

        // Replace these variables with your actual email and sender name
        $to = "jeziornaula@wp.pl";
        $headers = "From: $name <$email>";

        // Send the email
        $mailSuccess = mail($to, $subject, $body, $headers);

        // // Check if the email was sent successfully
        // if ($mailSuccess) {
        //     echo "Email sent successfully!<br>";
        // } else {
        //     echo "Error sending email.<br>";
        // }


        // echo "Form submitted successfully!";


        // Prepare response data
        $responseData = [
            'success' => true,
            'message' => 'Form submitted successfully',
            'data' => [
                'email' => $email,
                'name' => $name,
                'message' => $message,
                'package' => $package
            ]
        ];

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($responseData);
        exit;
    } else {
        // reCAPTCHA verification failed
        // echo "reCAPTCHA verification failed. Please try again.";

        $responseData = [
            'success' => false,
            'message' => 'reCAPTCHA verification failed. Please try again.'
        ];

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($responseData);
        exit;
    }


    // Example: Saving the data to a database (Note: You need to handle database connections securely)
    /*
    $servername = "your_database_server";
    $username = "your_database_username";
    $password = "your_database_password";
    $dbname = "your_database_name";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database (Note: Use prepared statements for security)
    $sql = "INSERT INTO your_table_name (email, name, message, package) VALUES ('$email', '$name', '$message', '$package')";
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
    */
}
?>