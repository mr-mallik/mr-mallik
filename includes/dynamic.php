<?php

$CONN = DBConnect(DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD);

function siteMenu()
{
    $menu = [
        '' => 'Home',
        'about' => 'About',
        'projects' => 'Work',
        'blogs' => 'Stories',
        'contact' => 'Contact',
    ];

    return $menu;
}

function blogList($cond="", $limit=null)
{
    global $CONN;

    $sql = "SELECT * FROM blog WHERE 1 $cond order by published_date desc";

    if($limit) {
        $sql .= " limit $limit";
    }

    $result = DBQuery($CONN, $sql);

    return DBFetchAll($result);
}

// caluclate years, months, days
function dateDiff($date1, $date2)
{
    $diff = abs(strtotime($date2) - strtotime($date1));

    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));

    return [
        'years' => $years,
        'months' => $months,
        'days' => $days,
    ];
}

// get skills
function getSkills($type=[])
{
    global $CONN;

    $sql = "SELECT * FROM skills";

    if($type) {
        $sql .= " where type in ('" . implode("','", $type) . "')";
    }

    $sql .= "ORDER BY rank";

    $result = DBQuery($CONN, $sql);

    return DBFetchAll($result);
}

function getMediumRssFeed($limit = 4)
{
    $rss = simplexml_load_file('https://medium.com/feed/@mrmallik');
    if (!$rss) {
        return [];
    }

    // convert to array
    $feed = json_decode(json_encode($rss), true);
    
    $articles = [];
    if (isset($feed['channel']['item'])) {
        foreach ($feed['channel']['item'] as $item) {
            // Clean CDATA from title
            $title = preg_replace('/^\<\!\[CDATA\[(.*)\]\]\>$/', '$1', $item['title']);
            
            // Extract image from content:encoded
            preg_match('/<img[^>]+src="([^">]+)"/', $item['content:encoded'], $matches);
            $image = $matches[1] ?? '';
            
            // Get categories as array
            $categories = isset($item['category']) ? (array)$item['category'] : [];
            
            // Clean CDATA from author
            $author = preg_replace('/^\<\!\[CDATA\[(.*)\]\]\>$/', '$1', $item['dc:creator']);

            $articles[] = [
                'title' => is_array($title) ? trim(implode(' ', $title)) : trim($title),
                'url' => $item['link'],
                'image' => $image,
                'date' => date('Y-m-d', strtotime($item['pubDate'])),
                'categories' => $categories,
                'author' => is_array($author) ? trim(implode(' ', $author)) : trim($author),
                'content' => $item['content:encoded']
            ];

            if (count($articles) >= $limit) {
                break;
            }
        }
    }

    // Sort by date descending
    usort($articles, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return $articles;
}

function getResume($cond= '', $order=null, $limit=null)
{
    global $CONN;

    $sql = "SELECT * FROM resume WHERE 1 $cond";

    if($order) {
        $sql .= " ORDER BY $order";
    }

    if($limit) {
        $sql .= " LIMIT $limit";
    }

    $result = DBQuery($CONN, $sql);

    return DBFetchAll($result);
}

function blogGet($type, $slug)
{
    global $CONN;

    $sql = "SELECT * FROM blog WHERE type = ? AND urlname = ? LIMIT 1";
    $stmt = $CONN->prepare($sql);
    $stmt->execute([$type, $slug]);

    if ($stmt->rowCount() == 0) {
        return null; // No article found
    }

    // Fetch the article
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // fetch other details from blog_det
    $sqlDetails = "SELECT * FROM blog_det WHERE blog_id = ?";
    $stmtDetails = $CONN->prepare($sqlDetails);
    $stmtDetails->execute([$article['blog_id']]);

    $article['details'] = $stmtDetails->fetchAll(PDO::FETCH_ASSOC);

    return $article;
}