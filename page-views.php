<?php
//


$servername = "localhost";
$username = "u687264317_dharmicdialog";
$password = "Dharmic^dialogue@267%$";
$dbname = "u687264317_dharmicdialog";

// Create connection
$conndb = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conndb->connect_error) {
    die("Connection failed: " . $conndb->connect_error);
}

// Function to save or update view count
function saveOrUpdateViewCount($conndb) {
    $view_date = date('Y-m-d'); // Current date

    // Check if there's already a record for today
    $sql = "SELECT page_views FROM page_views WHERE view_date = ?";
    $stmt = $conndb->prepare($sql);
    $stmt->bind_param("s", $view_date);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Record exists, update the view count
        $stmt->bind_result($page_views);
        $stmt->fetch();
        $page_views++;
        
        $sql = "UPDATE page_views SET page_views = ? WHERE view_date = ?";
        $stmt = $conndb->prepare($sql);
        $stmt->bind_param("is", $page_views, $view_date);
        $stmt->execute();
    } else {
        // No record exists, insert a new record
        $sql = "INSERT INTO page_views (view_date, page_views) VALUES (?, ?)";
        $stmt = $conndb->prepare($sql);
        $stmt->bind_param("si", $view_date, $page_views);
        $page_views = 1; // Initialize view count
        $stmt->execute();
    }

    $stmt->close();
}

// Call the function to save or update view count
saveOrUpdateViewCount($conndb);

// Close connection



// Collect visitor data
$visitDate = date('Y-m-d H:i:s'); // Current date and time
$ipAddress = $_SERVER['REMOTE_ADDR']; // Visitor's IP address
$userAgent = $_SERVER['HTTP_USER_AGENT']; // User agent string

// Use a geolocation service to get country and state
$locationData = json_decode(file_get_contents("http://ip-api.com/json/{$ipAddress}"), true);

// Debugging: Check the location data
if (!$locationData || $locationData['status'] !== 'success') {
    die("Geolocation API request failed: " . json_encode($locationData));
}

// Extract location data
$country = $locationData['country'] ?? null;
$countryCode = $locationData['countryCode'] ?? null;
$region = $locationData['region'] ?? null;
$regionName = $locationData['regionName'] ?? null;
$city = $locationData['city'] ?? null;
$zip = $locationData['zip'] ?? null;
$latitude = $locationData['lat'] ?? null;
$longitude = $locationData['lon'] ?? null;

// Gender - for demonstration purposes, you might want to collect this via a form
$gender = isset($_GET['gender']) ? $_GET['gender'] : null; // Assuming gender is passed via query string
$localRegion = null; // Define localRegion if needed

// Prepare and bind
$stmt = $conndb->prepare("INSERT INTO visitors (visit_date, ip_address, country, country_code, region, region_name, city, zip, latitude, longitude, gender, local_region, user_agent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssdssss", $visitDate, $ipAddress, $country, $countryCode, $region, $regionName, $city, $zip, $latitude, $longitude, $gender, $localRegion, $userAgent);

// Execute the statement
if ($stmt->execute()) {
   // echo "Visitor data recorded successfully.";
} else {
   // echo "Error inserting data: " . $stmt->error;
}



// Close the statement and connection
$stmt->close();
$conndb->close();
?>
