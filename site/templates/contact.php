<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page->title() ?></title>
    <style>
        body { margin: 0; }
        canvas { display: block; }
    </style>
    <!-- Kirby's CSS assets can be included here -->
    <?= css('assets/css/styles.css') ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

</head>
<body>
<div class="container">
    <header class="header">
    <?php 
$recentWork = page('timeline')->children()->first();
$recentWorkSlug = $recentWork ? $recentWork->slug() : '';
?>

        
    <nav class="menu">
        <ul>
            <li><a class="name" href="<?= $site->url() ?>"><?=$site->title() ?></a></li>
        <li>
        <a href="<?= url('timeline') . '#' . $recentWorkSlug ?>">Works</a></li>
        <?php foreach ($site->children()->listed() as $item): ?> 
            <?php if ($item->title()->value() !== 'Works'): // Exclude the seonc "Works" page ?>   
            <li>
                <a href="<?= $item->url() ?>"><?= $item->title() ?></a></li>
                <?php endif; ?>
            <?php endforeach ?>
        </ul>
    </nav>    
</header>
<div class="contact">
<p><?= $page->contact()->kti() ?></p>
</div>
<style>
.contact {
    display: flex;
    justify-content: center; /* Horizontally center the content */
    align-items: center; /* Vertically center the content */
    height: 80vh;
}
@media (max-width: 1100px) {
        html {
            font-size: 15px;
        }
    }</style>
</body>