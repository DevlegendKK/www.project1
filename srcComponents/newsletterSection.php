<?php
include "../../config/database.php"; // Ensure this is the correct path
// Only include the necessary database connection file
include "../config/database.php"; // Commented out if not needed
include "config/database.php"; // Commented out if not needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Check if name and email are not empty
    if (empty($name) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Both name and email are required.']);
        exit();
    }

    try {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT id FROM iv_newsletter WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            echo json_encode(['status' => 'error', 'message' => 'This email is already subscribed.']);
            exit();
        }

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO iv_newsletter (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);

        echo json_encode(['status' => 'success', 'message' => 'You have successfully subscribed!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
}
?>

<style>
    /* Newsletter Banner Container */
    .newsletter-banner {
        position: relative;
        background: linear-gradient(135deg, #3b5998, #8b9dc3);
        color: white;
        padding: 10px 20px;
        text-align: center;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        max-width: 800px;
        margin: 40px auto;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
    }

    .newsletter-banner h2 {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .newsletter-banner p {
        font-size: 18px;
        max-width: 600px;
        margin-bottom: 20px;
    }

    /* Form Container */
    .newsletter-form {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 600px;
        background: white;
        border-radius: 50px;
        padding: 5px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .newsletter-form input {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        outline: none;
    }

    .newsletter-form input:focus {
        box-shadow: 0 0 5px rgba(255, 206, 84, 0.8);
    }

    .cta-button {
        background: #FFCE54;
        color: black;
        font-size: 16px;
        padding: 12px 20px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        margin-left: 10px;
        transition: all 0.3s ease;
    }

    .cta-button:hover {
        background: #E5B846;
    }

    /* Success/Error Message */
    #newsletter-message {
        margin-top: 15px;
        font-weight: bold;
    }

    /* Responsive Design */
    @media (max-width: 600px) {
        .newsletter-form {
            flex-direction: column;
            border-radius: 10px;
            padding: 10px;
        }

        .newsletter-form input {
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .cta-button {
            width: 100%;
            border-radius: 10px;
        }
    }
    .newsletter-form label {display: none;}
</style>

<div class="newsletter-banner" id="newsletter">
    <h2>📢 Stay Informed. Stay Inspired.</h2>
    <p>Subscribe to <strong>The Indic Voice</strong> and receive exclusive insights into India's intellectual heritage, history, and global influence.</p>

    <!-- Signup Form -->
    <form id="form_newsletter-signup" class="newsletter-form" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your Name" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
        <button type="submit" class="cta-button">Subscribe Now</button>
    </form>

    <!-- Success/Error Message -->
    <div id="newsletter-message"></div>
</div>

<!-- AJAX Script for Form Submission -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is included -->
<script>
        jQuery(document).ready(function() {
    jQuery('#form_newsletter-signup').on('submit', function(e) {
        e.preventDefault();
        var formData = jQuery(this).serialize();

        jQuery.ajax({
            type: "POST",
            url: "/srcComponents/newsletterSection.php",
            data: formData,
            dataType: "json",
            success: function(response) {
                jQuery("#newsletter-message").text(response.message)
                    .css("color", response.status === "success" ? "green" : "red");

                if (response.status === "success") {
                    jQuery('#form_newsletter-signup')[0].reset(); // Clear form after success
                }
            },
            error: function() {
                jQuery("#newsletter-message").text("An error occurred. Please try again.").css("color", "red");
            }
        });
    });
});

    </script>