<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Countdown Poster</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body></body>

<?php
/* COMP 220 - PHP Programming
 * Taylor Evans - 4373570
 * File: posterOutput.php
 * Purpose: Handles the form submission for creating the event poster. Collects user
 *          input for event details, validates inputs, generates the event poster,
 *          and displays it to the user.
 */
 
 require_once 'countdown.php';
 
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
     try {
         // Collect and sanitize inputs
         $eventName = htmlspecialchars(trim($_POST['event_name']));
         $eventDate = htmlspecialchars(trim($_POST['event_date']));
         $textColor = htmlspecialchars(trim($_POST['text_color']));
         $backgroundImage = $_FILES['background_image'] ?? null;
 
         // Handle file upload
         if ($backgroundImage && $backgroundImage['error'] === 0) {
             $uploadedPath = 'uploads/' . basename($backgroundImage['name']);
             if (!move_uploaded_file($backgroundImage['tmp_name'], $uploadedPath)) {
                 throw new Exception("Failed to upload background image.");
             }
             $imagePath = __DIR__ . '/' . $uploadedPath; // Absolute path
         } else {
             $imagePath = null; // Use default image
         }
 
         // Create the event
         $event = new CountdownEvent($eventName, $eventDate, $textColor);
 
         // Validate inputs
         $event->validateInputs();
 
         // Generate the poster
         $posterPath = $event->generatePoster($imagePath);
 
         // Display success and the poster
         echo "<div class='poster-container'>";
         echo "<h1 style='color: #FDF0D5;'>" . htmlspecialchars($eventName) . "</h1>"; 
         echo "<p style='color: #FDF0D5;'>" . htmlspecialchars($event->calculateCountdown()) . "</p>"; 
         echo "<img src='" . htmlspecialchars($posterPath) . "' alt='Event Poster' class='poster-image'>";
         echo "</div>";
 
     } catch (Exception $e) {
         echo "<div class='error-message'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
     }
 }
 ?>
