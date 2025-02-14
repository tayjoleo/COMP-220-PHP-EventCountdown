<?php
/* COMP 220 - PHP Programming
 * Taylor Evans - 4373570
 * File: CountdownEvent.php
 * Purpose: Class for generating an event poster with a countdown and user inputs
 */

class CountdownEvent {
    public $eventName;
    public $eventDate;
    public $textColor;

    public function __construct($name, $date, $color) {
        $this->eventName = $name;
        $this->eventDate = $date;
        $this->textColor = $color ?: '#000000'; 
    }

    public function calculateCountdown() {
        $currentDate = new DateTime();
        $eventDate = new DateTime($this->eventDate);

        if ($eventDate < $currentDate) {
            return "This event has already passed.";
        }

        $interval = $currentDate->diff($eventDate);
        return $interval->days . " days remaining";
    }

    public function validateInputs() {
        if (empty($this->eventName) || empty($this->eventDate)) {
            throw new Exception("Event name and date are required.");
        }

        if (!DateTime::createFromFormat('Y-m-d', $this->eventDate)) {
            throw new Exception("Invalid date format. Please use YYYY-MM-DD.");
        }
    }

    public function generatePoster($backgroundImage = null) {
        $outputDir = __DIR__ . '/generated_posters';
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0777, true); // Create the output directory if it doesn't exist
        }
    
        $posterPath = $outputDir . '/event_poster.png';
    
        try {
            // Resolve the image path
            if ($backgroundImage) {
                $backgroundImage = realpath($backgroundImage);
                if (!$backgroundImage) {
                    throw new Exception("Background image not found: $backgroundImage");
                }
            } else {
                // Use default background image if none uploaded
                $backgroundImage = __DIR__ . '/uploads/default_background.png'; // Ensure this file exists
            }
    
            // Get font choice from the form submission 
            $fontChoice = isset($_POST['font_choice']) ? $_POST['font_choice'] : 'Lexend';  // Default to 'Lexend'
            $fontPath = __DIR__ . "/fonts/{$fontChoice}.ttf";  // Ensure font files are available
    
            // If the font file does not exist, use a default font (e.g., Lexend)
            if (!file_exists($fontPath)) {
                $fontPath = __DIR__ . '/fonts/Lexend.ttf'; // Default to Lexend font if the user font is not available
            }
    
            // Load the image with Imagick
            $imagick = new Imagick($backgroundImage);
            $imageWidth = $imagick->getImageWidth();
            $imageHeight = $imagick->getImageHeight();
    
            // Calculate the font size dynamically as a percentage of the image height
            $fontSize = intval($imageHeight * 0.1); // 10% of image height
            $draw = new ImagickDraw();
            $draw->setFontSize($fontSize); // Set the dynamically calculated font size
            $draw->setFillColor($this->textColor ?: '#000000'); // Default to black if no color selected
    
            // Set the font from user selection or default to Lexend if the selected font is unavailable
            $draw->setFont($fontPath);
    
            // Add event name and center it horizontally and vertically (top third)
            $eventText = $this->eventName;
            $countdownText = $this->calculateCountdown();
    
            // Calculate the size of the event text
            $textMetrics = $imagick->queryFontMetrics($draw, $eventText);
            // Ensure the text width fits within the image, with some margin
            $maxWidth = $imageWidth * 0.75; // Set max width to 80% of the image width
            if ($textMetrics['textWidth'] > $maxWidth) {
                // Scale font size down to fit within the max width
                $fontSize = intval($fontSize * ($maxWidth / $textMetrics['textWidth']));
                $draw->setFontSize($fontSize);
                $textMetrics = $imagick->queryFontMetrics($draw, $eventText); // Recalculate text metrics
            }
    
            // Center text horizontally with margin
            $x = max(10, ($imageWidth - $textMetrics['textWidth']) / 2); // Center horizontally with a 10px margin
            $y = $imageHeight / 4; // Place it in the top third
    
            // Draw the event name
            $draw->annotation($x, $y, $eventText);
    
            // Add more space before the countdown text (adjust the $y position for spacing)
            $y += $fontSize * 1.5; // Adjust vertical space dynamically based on font size
    
            // Calculate the position for the countdown text
            $textMetrics = $imagick->queryFontMetrics($draw, $countdownText);
            // Recalculate x position for countdown text
            $x = max(10, ($imageWidth - $textMetrics['textWidth']) / 2); // Center horizontally with margin
    
            // Draw the countdown text
            $draw->annotation($x, $y, $countdownText);
    
            // Apply the drawing on the image
            $imagick->drawImage($draw);
    
            // Save the image
            $imagick->writeImage($posterPath);
    
            // Return the path to the generated image
            return 'generated_posters/event_poster.png';
        } catch (Exception $e) {
            throw new Exception("Error generating poster: " . $e->getMessage());
        }
    }
}
?>

