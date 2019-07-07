<?php
// Init:
require_once '../paths.php';
require_once '../functions.php';
$conn = unserialize(PROJECTS);
$output = null;
$today = date('Y-m-d');

function robots($host, $file) {
    $robots = 'User-Agent: *

Disallow: /imprint/
Disallow: /privacy/
Disallow: /admin/
Disallow: /termsofservice/
Allow: /*

Sitemap: '.$host.$file.'
    ';

    return $robots;
}

// Project Loop:
if (!empty($conn) && is_array($conn)) {
    foreach ($conn as $k => $project) {
        if ($k == 'winfluencer') break;
        // Init:
        $sites = null;
        $key = $k;
        $host = $project['host'];
        $host_en = null;
        $root = 'https://'.$host.'/';

        $dir = '/www/htdocs/'.ROOT_USERNAME;
        if (LOCALHOST)
            $root_abs = 'C://xampp/htdocs/'.$k.'/';
        else if (DIR_CMS == $key)
            $root_abs = $dir.'/';
        else
            $root_abs = $dir.'/'.$k.'/';
        // English Host Check:
        if ($conn[$key]['host_en'])
            $host_en = 'https://'.$conn[$key]['host_en'].'/';
        // Database Connection:
        $db = DBConnect($key);

        # SignUp
        $sites['signup'] = ['lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '1.0'];
        $sites['signup/2'] = ['lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.6'];
        $sites['signup/3'] = ['lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.3'];
        # News
        $topics = $db->get('topics', null, 'id, title');
        if (is_array($topics) && !empty($topics)) {
            $sites['news'] = ['lastmod' => $today, 'changefreq' => 'daily', 'priority' => '1.0'];

            foreach ($topics as $x) {
                $id = $x['id'];
                $title = str_replace([' ', ':'], ['-'], $x['title']);
                $sites['news/' . $title . '/' . $id] =
                    ['lastmod' => $today, 'changefreq' => 'hourly', 'priority' => '1.0'];
            }
        }
        $topics = null;
        # Help
        $sites['Docs'] = ['lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '1.0'];

        $sitemap = '
            <url>
                <loc>'.$root.'</loc>
                <lastmod>'.$today.'</lastmod>
                <changefreq>weekly</changefreq>
                <priority>1.0</priority>
            </url>';

        foreach ($sites as $loc => $x) {
            $uri = $loc;
            $lastmod = $x['lastmod'];
            $changefreq = $x['changefreq'];
            $priority = $x['priority'];

            $sitemap .= '
            <url>
                <loc>' . $root . $loc . '/</loc>
                <lastmod>'.$today.'</lastmod>
                <changefreq>'.$changefreq.'</changefreq>
                <priority>'.$priority.'</priority>        
            </url>';
        }

        $print = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$sitemap.'
        </urlset>';

        // Create sitemap XML file:
        $file = 'sitemap.xml';
        file_put_contents($root_abs . $file, $print);
        // Create "robots.txt" file:
        $sitemap_extra = null;
        $robots_extra = null;
        $host_robots = str_replace('www.', '', $host);
        file_put_contents($root_abs . 'robots/'.$host_robots.'.txt', robots($root, $file));
        if ($host_en) {
            $file_en = 'sitemap_en.xml';
            // Create "sitemap_en.xml":
            $sitemap_extra = '<p>Sitemap <a href="'.$root.$file_en.'">'.$root.$file_en.'</a> created.</p>';
            file_put_contents($root_abs . $file_en, $print);
            // Create RobotsTXT for english domain:
            $host_robots_en = str_replace('www.', '', $conn[$key]['host_en']);
            $robots_extra = '<p>RobotsTXT <a href="'.$root.'robots/'.$host_robots_en.'.txt">'.$root.'robots/'.$host_robots_en.'.txt</a> created.</p>';
            file_put_contents($root_abs . 'robots/'.$host_robots_en.'.txt', robots($host_en, $file_en));
        }

        // HTML Output:
        echo '
        <div class="mb20">
            <legend>'.$host.'</legend>
            <p>Sitemap <a href="'.$root.$file.'">'.$root.$file.'</a> created.</p>
            '.$sitemap_extra.'
            <p>RobotsTXT <a href="'.$root.'robots/'.$host_robots.'.txt">'.$root.'robots/'.$host_robots.'.txt</a> created.</p>
            '.$robots_extra.'
        </div>
        ';
    }
}
?>