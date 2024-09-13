<?php
// Set CORS headers to allow cross-origin access
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Hardcoded username and password
$valid_username = 'demo1';
$valid_password = 'demo2';

// Get the username and password from URL parameters
$username = isset($_GET['username']) ? $_GET['username'] : null;
$password = isset($_GET['password']) ? $_GET['password'] : null;

// Validate the username and password
if ($username === $valid_username && $password === $valid_password) {
    // GitHub URL for the JSON file
    $json_url = 'https://raw.githubusercontent.com/DiwaliCracker/vtt1/main/movies.json';

    // Fetch the JSON file content from GitHub
    $json_data = file_get_contents($json_url);
    $data = json_decode($json_data, true); // Decode JSON into an associative array

    // Check if the JSON data is valid
    if ($data) {
        // Set headers for M3U file download
        header('Content-Type: application/x-mpegurl');
        header('Content-Disposition: attachment; filename="playlist.m3u"');

        // Start generating the M3U file content
        echo "#EXTM3U\n";

        // Loop through movies in the JSON data and add them to the playlist
        if (isset($data['movies'])) {
            foreach ($data['movies'] as $movie) {
                echo "#EXTINF:-1,{$movie['title']}\n";
                echo "{$movie['url']}\n";
            }
        }

        // Loop through TV shows in the JSON data and add them to the playlist
        if (isset($data['tvShows'])) {
            foreach ($data['tvShows'] as $show) {
                echo "#EXTINF:-1,{$show['title']}\n";
                echo "{$show['url']}\n";
            }
        }

    } else {
        // If JSON data is not valid, return an error
        echo "Error: Unable to retrieve the playlist data.";
    }
} else {
    // If the username or password is incorrect, return a 403 Forbidden status
    header('HTTP/1.1 403 Forbidden');
    echo "Invalid username or password.";
}
?>
