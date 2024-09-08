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
<div class="about-container">
    
    <div class="statement-section">
        <?= $page->text()->kti() ?>
    </div>
    
    <div class="cv-section">
        <?= $page->cv()->kti() ?>
    </div>
</div>


<style>
.about-container {  
    display: flex;
    overflow-y: auto;
    height: 100vh;
    visibility: hidden;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    scrollbar-color: transparent transparent;
    font-size: 15px;
    letter-spacing: 0.03em;
    line-height: 1.5em;
    flex-direction: row; /* By default, sections are side by side */
}
    .statement-section {
    width: 40%; /* Split the container into two equal halves */
    height: 100vh;
    margin-right: 90px;
    box-sizing: border-box; /* Ensure padding is included in width calculation */
    text-wrap: pretty;
    }
    .cv-section {
    width: 60%;
    height: 100vh;
    overflow-y: auto;
    box-sizing: border-box; 
    }
    @media (max-width: 600px) {
        html {
            font-size: 15px;
        }
    .about-container {
        flex-direction: column; /* Stack sections vertically */
        height: auto;
        overflow-x: hidden;
        padding: 4%;


    }
    .statement-section,
    .cv-section {
        width: 100%; /* Take full width of the screen */
        height: auto; /* Allow height to be dynamic */

    }
    }
    @media (min-width: 601px) and (max-width: 1100px) {
        html {
            font-size: 15px;
        }
    .about-container {
        flex-direction: column; /* Stack sections vertically */
        height: auto;
    }
    .statement-section,
    .cv-section {
        width: 100%; /* Take full width of the screen */
        height: auto; /* Allow height to be dynamic */
        margin-right: 0; /* Remove margin when stacked */
    }
    }

  
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(window).on('load', function() {
        // Show the timeline content once everything is loaded
        $('.about-container').css({
            'visibility': 'visible',
            'opacity': '1'
        });
    });
    $(document).ready(function() {
    // Calculate and set margin-left for .timeline-container
    var menuOffset = $('.header .menu ul').offset().left;
    var pagePadding = parseFloat($('html').css('padding-left')) || 0;
    $('.about-container').css('margin-left', (menuOffset - pagePadding) + 'px');

    $(window).resize(function() {
        var menuOffset = $('.header .menu ul').offset().left;
        var pagePadding = parseFloat($('html').css('padding-left')) || 0;
        $('.about-container').css('margin-left', (menuOffset - pagePadding) + 'px');
    });
});
</script>
</main>
