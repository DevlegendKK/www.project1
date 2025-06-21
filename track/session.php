<?php
require_once __DIR__ . '/../config/database.php';

session_start();
header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!is_array($data)) {
        throw new Exception("Invalid or missing JSON payload.");
    }

    if (empty($data['session_id'])) {
        throw new Exception("Missing session_id.");
    }

    $session_id = $data['session_id'];
    $user_id = $_SESSION['user_id'] ?? null;
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $user_agent = $data['user_agent'] ?? '';

    function parseUserAgent($ua) {
        $device = stripos($ua, 'mobile') !== false ? 'Mobile' : 'Desktop';
        $os = stripos($ua, 'Windows') ? 'Windows' :
              (stripos($ua, 'Mac') ? 'macOS' :
              (stripos($ua, 'Linux') ? 'Linux' : 'Other'));
        $browser = stripos($ua, 'Chrome') ? 'Chrome' :
                   (stripos($ua, 'Firefox') ? 'Firefox' :
                   (stripos($ua, 'Safari') ? 'Safari' : 'Other'));
        return [$device, $os, $browser];
    }

    [$device, $os, $browser] = parseUserAgent($user_agent);

    $start_time = $data['start_time'] ?? null;
    $end_time = $data['end_time'] ?? null;
    $duration = ($start_time && $end_time) ? strtotime($end_time) - strtotime($start_time) : 0;

    $stmt = $conn->prepare("SELECT visited_urls FROM user_sessions WHERE session_id = :sid");
    $stmt->execute(['sid' => $session_id]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    $new_urls = $data['visited_urls'] ?? '';
    $new_urls_array = array_map(function($url) {
        return explode('|', $url)[0]; // strip duration
    }, array_filter(array_map('trim', explode(',', $new_urls))));

    if ($existing) {
        $existing_urls = array_filter(array_map('trim', explode(',', $existing['visited_urls'] ?? '')));
        $combined_urls = array_unique(array_merge($existing_urls, $new_urls_array));
        $combined_urls_str = implode(',', $combined_urls);

        $stmt = $conn->prepare("UPDATE user_sessions SET 
            exit_page = :exit,
            visited_urls = :visited,
            latitude = :lat,
            longitude = :lon,
            city = :city,
            region = :region,
            country = :country,
            gender = :gender,
            end_time = :end,
            session_duration = TIMESTAMPDIFF(SECOND, start_time, :end)
            WHERE session_id = :sid");
        $stmt->execute([
            'exit' => $data['exit_page'] ?? '',
            'visited' => $combined_urls_str,
            'lat' => $data['latitude'] ?? null,
            'lon' => $data['longitude'] ?? null,
            'city' => $data['city'] ?? '',
            'region' => $data['region'] ?? '',
            'country' => $data['country'] ?? '',
            'gender' => $data['gender'] ?? '',
            'end' => $end_time,
            'sid' => $session_id
        ]);
        echo json_encode(['status' => 'session updated']);
    } else {
        $stmt = $conn->prepare("INSERT INTO user_sessions (
            session_id, user_id, user_type, ip_address,
            latitude, longitude, city, region, country, gender,
            device_type, os, browser,
            entry_page, exit_page, referrer, query_string, visited_urls,
            start_time, end_time, session_duration
        ) VALUES (
            :sid, :uid, :utype, :ip,
            :lat, :lon, :city, :region, :country, :gender,
            :device, :os, :browser,
            :entry, :exit, :ref, :query, :visited,
            :start, :end, :duration
        )");
        $stmt->execute([
            'sid' => $session_id,
            'uid' => $user_id,
            'utype' => $data['user_type'] ?? 'guest',
            'ip' => $ip,
            'lat' => $data['latitude'] ?? null,
            'lon' => $data['longitude'] ?? null,
            'city' => $data['city'] ?? '',
            'region' => $data['region'] ?? '',
            'country' => $data['country'] ?? '',
            'gender' => $data['gender'] ?? '',
            'device' => $device,
            'os' => $os,
            'browser' => $browser,
            'entry' => $data['entry_page'] ?? '',
            'exit' => $data['exit_page'] ?? '',
            'ref' => $data['referrer'] ?? '',
            'query' => $data['query_string'] ?? '',
            'visited' => implode(',', $new_urls_array),
            'start' => $start_time,
            'end' => $end_time,
            'duration' => $duration
        ]);
        echo json_encode(['status' => 'new session inserted']);
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}