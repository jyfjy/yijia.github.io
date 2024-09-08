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

<main class="main">
<div class="timeline-container">

    <div class="timeline-list">
      <?php
      // Step 1: Group the works by year
      $worksByYear = [];
      foreach (page('timeline')->children()->listed() as $work) {
          $year = $work->year()->isNotEmpty() ? $work->year()->value() : 'Unknown'; // Get year or default to 'Unknown'
          if (!isset($worksByYear[$year])) {
              $worksByYear[$year] = [];
          }
          $worksByYear[$year][] = $work;
      }

      // Sort the works by year in descending order
      krsort($worksByYear);
      ?>

      <!-- Step 2: HTML structure to display grouped works -->
      <?php foreach ($worksByYear as $year => $works): ?>
        <div class="timeline-year">
            <p><?= $year ?></p> <!-- Display the year -->
        </div>
        <?php foreach ($works as $index => $work): ?>
            <div class="timeline-item" id="<?= $work->slug() ?>">
                <a href="#<?= $work->slug() ?>" class="work-link" data-index="<?= $index ?>">
                    <?= $work->title()->html() ?>
                </a>
            </div>
        <?php endforeach ?>
      <?php endforeach ?>
    </div>
 
    
    <div class="work-display">
    <div class="fade">
    <?php foreach (page('timeline')->children()->listed() as $work): ?>
        <div class="work-content" data-slug="<?= $work->slug() ?>">
            <div class="image-container">
                <?php foreach ($work->images() as $image): ?>
                    <img src="<?= $image->url() ?>" alt="<?= $work->title()->html() ?>" class="work-image">
                <?php endforeach; ?>
            </div>
            <div class="work-title"><?= $work->title()->html() ?></div>
            <div class="details">
                <span><?= $work->material()->html() ?></span>
                <span class="old-style-number"><?= $work->size() ?></span>
            </div>
        </div>
    <?php endforeach ?>
</div>
    </div>
  </div>
  </div>


<style>
    
    .timeline-container {
      margin-left: 0; /* Let JavaScript handle the margin */
      display: flex;
      visibility: hidden;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
      scrollbar-color: transparent transparent; 
    }
    .timeline-list {
      width: 20%;
      padding-right: 30px;
      box-sizing: border-box;
      overflow-y: auto; 
      display: flex;
      flex-direction: column;
      justify-content: flex-start; 
    }
    .timeline-item {
      margin-bottom: 3px;
    }
    .timeline-item a {
      text-decoration: none;
      color: black;
    }
    .timeline-item a:hover, .timeline-item a.active {
      text-decoration: underline;
      text-underline-offset: 3px;
      text-decoration-thickness: 1.5px;
    }
    .work-display {
      width: 75%;
      margin-left: 0;
      box-sizing: border-box;
    }
    .fade {
      width: 100%;
    }
    .work-content {
      text-align: center;
    }
    .image-container {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 81vh;
      flex-wrap: wrap;
      max-height: 100vh;
      overflow-y: scroll;
      overflow-x: hidden;
      scrollbar-width: thin;
      scrollbar-color: black white;
    }

    .work-image {
      max-height: 100%;
      width: auto;
      max-width: 100%;
      object-fit: contain;
    }
  
    .work-title {
      padding-top: 15px;
    }
    .image-pagination {
      font-family: "Standard", sans-serif;
      position: absolute; /* Positions the pagination relative to the title */
      right: 0;
    }
    .fade .slick-prev, .fade .slick-next {
    width: 30%; /* Each arrow covers half of the carousel */
    height: 90vh; /* Full height of the carousel */
    position: absolute;
    bottom: 0; 
    z-index: 1000; /* Ensure arrows are above content */
    align-items: center;
    justify-content: center;
    background: transparent; /* Make background transparent */
    pointer-events: auto;
    cursor: none;
  }

  .fade .slick-prev:before, .fade .slick-next:before {
    display: none; /* Hide default arrows */
  }
  .custom-cursor {
    position: absolute;
    pointer-events: none;
    color: black;
    z-index: 1001;
    display: none; /* Hidden by default */
  }

  .timeline-year {
    font-size: 16px;
  }
  @media (max-width: 1100px) {
    html {
      font-size: 15px;
    }
    .timeline-list {
      width: 0%;
      padding-right: 0;
    }
    .timeline-year {
      display: none;
    }
    .timeline-item {
      display: none;
    }
    .work-display {
      width: 100%;
    }
    .fade .slick-prev, .fade .slick-next {
    width: 35%; 
    height: 85vh;
    }
    .image-container {
    height: 78vh;
    }
    

  }

  </style>

  <!-- Include jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Include Slick Carousel -->
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <script>
    $(document).ready(function(){
      // Initialize Slick carousel
      $('.fade').slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 100,
        fade: true,
        cssEase: 'linear',
        adaptiveHeight: true
      });

      // Map slugs to slide indices
      const slugMap = {};
      $('.fade .work-content').each(function(index){
        const slug = $(this).data('slug');
        slugMap[slug] = index;
      });

      function goToSlide(slug) {
        if (slugMap[slug] !== undefined) {
            $('.fade').slick('slickGoTo', slugMap[slug]);
        }
      }

      function activateLinkByHash() {
        var currentHash = window.location.hash.substring(1);
        if (currentHash) {
            $('.timeline-item a').removeClass('active'); // Remove the active class from all links
            $('.timeline-item a[href="#' + currentHash + '"]').addClass('active'); // Add the active class to the link with matching hash
        }
    }
    var hashRedirects = {
      "#planet-august": "#planet-august-series"
    };

    // Get the current hash
    var currentHash = window.location.hash;

    // Check if the current hash matches one of the keys in the mapping
    if (hashRedirects[currentHash]) {
      // Redirect to the new hash
      window.location.hash = hashRedirects[currentHash];
    }


    // Initial activation on page load
    activateLinkByHash();
      

      // Check if a specific slide needs to be shown first
      const urlHash = window.location.hash.substr(1); // Remove the `#` from the hash
    if (urlHash) {
        goToSlide(urlHash);
    }

      // Link timeline items to the carousel
      $('.work-link').on('click', function(e) {
        e.preventDefault();
        const slug = $(this).attr('href').substring(1);
        goToSlide(slug);
        activateLinkByHash();
    });

    $('.fade').on('afterChange', function(event, slick, currentSlide) {
        var currentSlug = $('.fade .work-content').eq(currentSlide).data('slug');
        window.location.hash = currentSlug;
        activateLinkByHash(); // Update the active class when the slide changes
    });

        // Enable scrolling even when hovering over .slick-prev or .slick-next
        $('.fade .slick-prev, .fade .slick-next').on('mousewheel DOMMouseScroll', function(e) {
        e.stopPropagation(); // Allow the event to propagate to the parent container
        e.preventDefault(); // Prevent the default behavior
        
       // Target the currently active slide
       var activeSlide = $('.work-content.slick-slide.slick-current.slick-active');
        var delta = e.originalEvent.wheelDelta || -e.originalEvent.detail;

        // Adjust scroll based on delta for the active slide
        activeSlide.scrollTop(activeSlide.scrollTop() - delta);

        return false; // Prevent further propagation to avoid blocking
    });

      var $customCursor = $('<div class="custom-cursor"></div>').appendTo('body');

      $('.fade .slick-prev').on('mousemove', function(e) {
        $customCursor.text('prev').css({
        display: 'block',
        left: e.pageX + 10 + 'px',
        top: e.pageY + 10 + 'px'
  });
});
      $('.fade .slick-next').on('mousemove', function(e) {
        $customCursor.text('next').css({
        display: 'block',
        left: e.pageX + 10 + 'px',
        top: e.pageY + 10 + 'px'
  });
});   
   $('.fade').on('mouseleave', '.slick-prev, .slick-next', function() {
    $customCursor.css('display', 'none');
  });
  
    });

    $(window).on('load', function() {
        // Show the timeline content once everything is loaded
        $('.timeline-container').css({
            'visibility': 'visible',
            'opacity': '1'
        });
    });
    
$(document).ready(function() {
    // Calculate and set margin-left for .timeline-container
    var menuOffset = $('.header .menu ul').offset().left;
    var pagePadding = parseFloat($('html').css('padding-left')) || 0;
    $('.timeline-container').css('margin-left', (menuOffset - pagePadding) + 'px');

    $(window).resize(function() {
        var menuOffset = $('.header .menu ul').offset().left;
        var pagePadding = parseFloat($('html').css('padding-left')) || 0;
        $('.timeline-container').css('margin-left', (menuOffset - pagePadding) + 'px');
    });

    var workTitlePosition = $('.work-title').offset().top;
    // Get the top position of the .timeline-container
    var timelineContainerTop = $('.timeline-container').offset().top;
    // Calculate the height for .timeline-list
    var timelineListHeight = workTitlePosition - timelineContainerTop;

    // Set the height of .timeline-list
    $('.timeline-list').css({
        'max-height': timelineListHeight + 'px',
        'display': 'flex',
        'flex-direction': 'column',
        'overflow-y': 'auto'
    });

    // Apply margin-bottom to image series
    $('.work-content').each(function() {
        var $imageContainer = $(this).find('.image-container');
        var imageCount = $imageContainer.find('img').length;
        var $workTitle = $(this).find('.work-title');

        console.log('Selected title:', $workTitle.text());
        // If there is more than one image, apply margin-bottom to all images
        if (imageCount > 1) {
            
            $imageContainer.find('img').not(':last-child').css('margin-bottom', '60px');
            console.log(imageCount);
            var $paginationContainer = $('<span class="image-pagination"></span>');
            $workTitle.prepend($paginationContainer);

            // Set up initial pagination (1/5, etc.)
            $paginationContainer.text('1/' + imageCount);

            $imageContainer.on('scroll', function() {
                var currentScrollTop = $imageContainer.scrollTop();
                var totalScrollHeight = $imageContainer[0].scrollHeight - $imageContainer.height();
                var currentIndex = Math.round((currentScrollTop / totalScrollHeight) * (imageCount - 1)) + 1;
                // Display the current image index and total number of images
                $paginationContainer.text(currentIndex + '/' + imageCount);
            });
        

        }
    });
    
});
    
</script>

</main>


