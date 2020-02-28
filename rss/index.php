<?php
    header("Content-Type: application/rss+xml; charset=UTF-8");
	include('../config.php');
 
    $rssfeed = '<?xml version="1.0" encoding="UTF-8"?>';
    $rssfeed .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
    $rssfeed .= '<channel>';
    $rssfeed .= '<title>Výpisky RSS</title>';
    $rssfeed .= '<link>https://jaroska.us.to</link>';
    $rssfeed .= '<description>RSS feed Výpisků obsahující novinky v rámci Výpisků</description>';
    $rssfeed .= '<language>cs</language>';
 
    $query = "SELECT * FROM rss ORDER BY date DESC";
    $result = mysqli_query($link, $query) or die ("Could not execute query");
 
    while($row = mysqli_fetch_array($result)) {
        extract($row);
 
        $rssfeed .= '<item>';
        $rssfeed .= '<title>' . $title . '</title>';
        $rssfeed .= '<description>' . $description . '</description>';
        $rssfeed .= '<link>https://jaroska.us.to</link>';
        $rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($date)) . '</pubDate>';
        $rssfeed .= '</item>';
    }
 
    $rssfeed .= '</channel>';
    $rssfeed .= '</rss>';
 
    echo $rssfeed;
?>