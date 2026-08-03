<?php
/*
 * ErrorDocument 404 handler for /logs/ (see logs/.htaccess).
 *
 * The build log layout changed several times: the directories gained a clang
 * version suffix (logs/2020-05-01 -> logs/2020-05-01-10.0.0), the file names
 * gained one too (_unstable_clang -> _unstable_clang10.0.0), the very first
 * rebuilds used _lsid64* / .buildlog, and everything is now gzip compressed.
 * The pages themselves resolve the current layout with build_log_url(), but
 * URLs published years ago in the BTS or on the mailing lists still point at
 * the old names - see https://github.com/opencollab/clang.debian.net/issues/7
 *
 * So: take whatever /logs/<date>/<package>_<version>_<suffix>.<ext> we are
 * handed, look for that package/version among the rebuilds actually on disk,
 * and redirect to it. Only the package and the version are trusted; the
 * directory, the suffix and the extension are treated as hints.
 */

$logsDir = __DIR__ . "/logs";

/*
 * The rebuild directories, newest first, as (name => date) - "2017-07-06-4.0.1"
 * gives 2017-07-06. Anything not starting with a date is ignored.
 */
function rebuild_dirs($logsDir) {
    $dirs = array();
    foreach ((array) scandir($logsDir) as $name) {
        if (!preg_match('/^(\d{4}-\d{2}-\d{2})/', $name, $m)) {
            continue;
        }
        if (is_dir("{$logsDir}/{$name}")) {
            $dirs[$name] = $m[1];
        }
    }
    arsort($dirs);
    return $dirs;
}

/*
 * Split a log file name into package and version. Debian package names never
 * contain an underscore and versions never do either, so the first two
 * underscore separated fields are what we are after; the rest is the suffix
 * (unstable_clang13.0.0, lsid64c, ...) which we deliberately throw away.
 */
function split_log_name($file) {
    $file = preg_replace('/\.gz$/', '', $file);
    $file = preg_replace('/\.(log|buildlog|txt)$/', '', $file);
    if (!preg_match('/^([^_]+)_([^_]+)_(.+)$/', $file, $m)) {
        return NULL;
    }
    return array($m[1], $m[2]);
}

/* Reject anything that could escape logs/ or reach glob() as a wildcard. */
function sane_package($p) {
    return (bool) preg_match('/^[a-z0-9][a-z0-9.+-]*$/i', $p);
}

function sane_version($v) {
    return (bool) preg_match('/^[a-z0-9][a-z0-9.+:~-]*$/i', $v);
}

/* The file names carry no epoch: 1:2.4-1 is stored as 2.4-1. */
function strip_epoch($version) {
    $pos = strpos($version, ":");
    return ($pos === false) ? $version : substr($version, $pos + 1);
}

function not_found($title, $message, $extra = "") {
    header("HTTP/1.1 404 Not Found");
    $pageTitle = "{$title} - rebuild of the Debian archive with clang";
    $pageSubtitle = $title;
    include(__DIR__ . "/header.php");
    echo "<div id=\"body\">\n<p>{$message}</p>\n{$extra}</div>\n";
    include(__DIR__ . "/footer.php");
    exit;
}

/*
 * REDIRECT_URL is the originally requested path, set by Apache when it hands
 * the request to an ErrorDocument. Without it we have nothing to work with.
 */
$requested = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : "";
$requested = rawurldecode($requested);

/* No NUL bytes, no traversal, and /logs/ only - everything else is a plain 404. */
if (strpos($requested, "\0") !== false || strpos($requested, "..") !== false
    || strpos($requested, "/logs/") !== 0) {
    not_found("Page not found",
              "The page you asked for does not exist. "
              . "Start from the <a href=\"/\">front page</a>?");
}

$rest = substr($requested, strlen("/logs/"));
$parts = explode("/", $rest);

/*
 * A directory: /logs/2014-08-05/ - that rebuild was renamed or dropped, so
 * list what is actually there rather than pretending it is gone.
 */
if (count($parts) < 2 || $parts[1] === "") {
    $list = "<ul>";
    foreach (rebuild_dirs($logsDir) as $name => $date) {
        $list .= "<li><a href=\"/logs/" . htmlspecialchars($name) . "/\">"
              . htmlspecialchars($name) . "</a></li>";
    }
    $list .= "</ul>";
    not_found("No such rebuild",
              "There is no rebuild under <code>"
              . htmlspecialchars($requested) . "</code>. The rebuilds "
              . "currently available are:", $list);
}

$askedDir = $parts[0];
$askedFile = $parts[1];

$split = split_log_name($askedFile);
if ($split === NULL) {
    not_found("Not a build log",
              "<code>" . htmlspecialchars($askedFile) . "</code> does not look "
              . "like a build log name.");
}
list($package, $version) = $split;
$version = strip_epoch($version);

if (!sane_package($package) || !sane_version($version)) {
    not_found("Not a build log",
              "<code>" . htmlspecialchars($askedFile) . "</code> does not look "
              . "like a build log name.");
}

/* Every rebuild holding that exact package/version, whatever the layout. */
$candidates = array();
foreach (rebuild_dirs($logsDir) as $name => $date) {
    $found = glob("{$logsDir}/{$name}/{$package}_{$version}_*");
    if ($found) {
        sort($found);
        $candidates[$name] = array($date, basename($found[0]));
    }
}

if (!$candidates) {
    /* Maybe the package was rebuilt, but never in that version. */
    $others = array();
    foreach (rebuild_dirs($logsDir) as $name => $date) {
        foreach ((array) glob("{$logsDir}/{$name}/{$package}_*") as $f) {
            $s = split_log_name(basename($f));
            if ($s !== NULL) {
                $others[$s[1]] = "/logs/{$name}/" . basename($f);
            }
        }
    }
    $extra = "";
    if ($others) {
        uksort($others, 'version_compare');
        $extra = "<p>Other versions of <code>" . htmlspecialchars($package)
               . "</code> that were rebuilt:</p><ul>";
        foreach ($others as $v => $url) {
            $extra .= "<li><a href=\"" . htmlspecialchars($url) . "\">"
                   . htmlspecialchars($v) . "</a></li>";
        }
        $extra .= "</ul>";
    }
    not_found("Build log not found",
              "No build log for <code>" . htmlspecialchars($package) . "</code> "
              . "version <code>" . htmlspecialchars($version) . "</code>.",
              $extra);
}

/*
 * Prefer the rebuild the URL asked for; the directory may just have gained a
 * version suffix since. Otherwise take the closest one in time - that date was
 * meaningful when the link was published, the logs simply moved.
 */
$target = NULL;
$exact = true;
$askedDate = preg_match('/^(\d{4}-\d{2}-\d{2})/', $askedDir, $m) ? $m[1] : NULL;

if (isset($candidates[$askedDir])) {
    $target = $askedDir;
} else {
    $exact = false;
    $best = NULL;
    foreach ($candidates as $name => $info) {
        list($date, $file) = $info;
        if ($askedDate === NULL) {
            $target = $name; /* rebuild_dirs() is newest first */
            break;
        }
        $delta = abs(strtotime($date) - strtotime($askedDate));
        /* On a tie the loop keeps the first, i.e. the most recent rebuild. */
        if ($best === NULL || $delta < $best) {
            $best = $delta;
            $target = $name;
        }
    }
    if ($askedDate !== NULL && $target !== NULL
        && strpos($target, $askedDate) === 0) {
        /* Same day, only the directory name gained the clang version. */
        $exact = true;
    }
}

$location = "/logs/{$target}/" . $candidates[$target][1];

/* Never bounce a request back onto itself. */
if ($location === $requested) {
    not_found("Build log not found",
              "<code>" . htmlspecialchars($requested) . "</code> could not be "
              . "served.");
}

/*
 * 301 when we are sure it is the same log under its current name, 302 when we
 * had to fall back to a neighbouring rebuild - that one is a best effort and
 * should not be cached forever.
 */
header("Location: {$location}", true, $exact ? 301 : 302);
exit;
