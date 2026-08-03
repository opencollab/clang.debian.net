<?php
/*
 * Shared page head + banner.
 *
 * Before including this file, a page may set:
 *  - $pageTitle      : contents of <title>
 *  - $pageSubtitle   : the banner subtitle
 *  - $pageHighlight  : true to load highlight.js (syntax colouring of <pre>)
 */
if (!isset($pageTitle)) {
    $pageTitle = "Rebuild of the Debian archive with clang";
}
if (!isset($pageSubtitle)) {
    $pageSubtitle = "Rebuild of the Debian archive with clang";
}
if (!isset($pageHighlight)) {
    $pageHighlight = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?=htmlspecialchars($pageTitle)?></title>
<link rel="stylesheet" href="/style.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chartist@0.11.4/dist/chartist.min.css" />
<script defer src="https://cdn.jsdelivr.net/npm/chartist@0.11.4/dist/chartist.min.js"></script>
<?php if ($pageHighlight) { ?>
<link rel="stylesheet" href="/styles/highlight-github.css" media="(prefers-color-scheme: light)" />
<link rel="stylesheet" href="/styles/highlight-github-dark.css" media="(prefers-color-scheme: dark)" />
<script defer src="/js/highlight.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("pre").forEach(function (e) { hljs.highlightElement(e); });
    var pkg = document.getElementById("pkg_field");
    if (pkg) { pkg.focus(); }
});
</script>
<?php } ?>
</head>
<body>
<header class="site-header">
<a href="/"><img class="logo" src="/debian.png" alt="Debian" /></a>
<div class="titles">
<h1 id="title"><a href="/">Debian Package rebuild</a></h1>
<h2 id="subtitle"><?=htmlspecialchars($pageSubtitle)?></h2>
</div>
<a href="https://www.irill.org/"><img class="logo" src="/irill.png" alt="IRILL" /></a>
</header>
