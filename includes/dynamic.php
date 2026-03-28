<?php

$CONN = DBConnect(DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD);

/**
 * Simple file-based cache for CMS One API responses.
 * Pass $value to write, omit $value (null) to read.
 * Returns null on cache miss.
 */
function _cmsCache($key, $value = null, $ttl = 7200)
{
    if (!CMS_CACHE_ENABLED) {
        return null;
    }

    $dir = rtrim(BASE_URL, '/\\') . DIRECTORY_SEPARATOR . '.cache';

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        // Block direct HTTP access
        @file_put_contents($dir . DIRECTORY_SEPARATOR . '.htaccess', "Deny from all\n");
    }

    $file = $dir . DIRECTORY_SEPARATOR . 'cms_' . $key . '.json';

    // Write
    if ($value !== null) {
        @file_put_contents($file, json_encode(['e' => time() + $ttl, 'v' => $value]), LOCK_EX);
        return $value;
    }

    // Read
    if (!file_exists($file)) return null;
    $raw = @file_get_contents($file);
    if ($raw === false) return null;
    $data = json_decode($raw, true);
    if (!$data || $data['e'] < time()) {
        @unlink($file);
        return null;
    }
    return $data['v'];
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

function cmsoneArticleList($category = null, $tag = null, $limit = 20, $page = 1)
{
    $cacheKey = 'articles_list_' . md5($category . $tag . $limit . $page);
    $cached   = _cmsCache($cacheKey);
    if ($cached !== null) return $cached;

    $api = new API(CMS_ONE_API_URL);
    $api->setBearerToken(CMS_ONE_API_KEY);

    $params = ['page' => $page, 'limit' => $limit];
    if ($category) {
        $params['category'] = $category;
    }
    if ($tag) {
        $params['tag'] = $tag;
    }

    $response = $api->get('articles', $params);

    if (!$response || empty($response['success']) || empty($response['data'])) {
        return [];
    }

    _cmsCache($cacheKey, $response['data']);
    return $response['data'];
}

function cmsoneArticleGet($slug)
{
    $cacheKey = 'article_' . md5($slug);
    $cached   = _cmsCache($cacheKey);
    if ($cached !== null) return $cached;

    $api = new API(CMS_ONE_API_URL);
    $api->setBearerToken(CMS_ONE_API_KEY);

    $response = $api->get('articles/' . rawurlencode($slug));

    if (!$response || empty($response['success']) || empty($response['data'])) {
        return null;
    }

    _cmsCache($cacheKey, $response['data']);
    return $response['data'];
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