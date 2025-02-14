# COMP-220: Server-Side Web Development with PHP

## Project Overview
This repository contains my **Event Countdown Poster Generator**, a PHP-based web application developed as part of COMP 220 (PHP Server-Side Web Development) at St. Lawrence College. The project allows users to generate customized event posters by entering event details such as name, date, text color, font, and background image.

## Learning Objectives
This project applies:
- **PHP Server-Side Programming**: Handling form submissions and dynamically generating event posters.
- **HTML & CSS for Front-End UI**: Creating a user-friendly interface with responsive styling.
- **File Upload Handling in PHP**: Processing background images uploaded by users.
- **Form Validation & Data Processing**: Ensuring input validation and proper data handling.
- **Dynamic Image Rendering**: Generating custom event posters based on user selections.

## Project Features
- **User Input Form**: Users enter event details including name, date, text color, font, and background image.
- **Poster Generation with PHP**: Dynamically creates a poster using the provided information.
- **Custom Font Selection**: Allows users to choose from different fonts for poster text.
- **File Upload Support**: Users can upload a background image for their poster.
- **Styled UI with CSS**: Clean, modern layout with validation for better user experience.

## Repository Structure
```
COMP-220-PHP-EventCountdown/
│── README.md                  # Project Overview
│── index.html                  # Front-end HTML form for user input
│── styles.css                  # CSS for styling the form and generated posters
│── countdown.php                # PHP script for countdown logic (if applicable)
│── posterOutput.php             # PHP script for generating the event poster
│── fonts/                       # Folder for custom fonts
│── generated_posters/           # Folder where generated posters are stored
│── uploads/                     # Folder for user-uploaded images
│── LICENSE                      # Open-source license (optional)
```

## How to Install & Run
### **1. Clone the Repository**
```bash
git clone https://github.com/tayjoleo/COMP-220-PHP-EventCountdown.git
cd COMP-220-PHP-EventCountdown
```

### **2. Setup a Local PHP Environment**
- Use **XAMPP, MAMP, or WAMP** to run a local PHP server.
- Ensure PHP and MySQL are installed and configured.

### **3. Start the PHP Server**
```bash
php -S localhost:8000
```

### **4. Open the Application**
- Navigate to `http://localhost:8000/index.html` in your browser.

## Future Improvements
- Integrate **database storage** to save event poster details.
- Implement **authentication & user sessions**.
- Enhance **poster customization options** with more design elements.

## Author
Taylor Evans | Contact: **taylor.evans@student.sl.on.ca**
