<!DOCTYPE html>
<?php snippet('header') ?>

<main class="main">
  <ul class="works">
    <?php foreach ($page->children()->listed() as $work): ?>
      <li>
        <a href="#" class="open-gallery" data-index="<?= $work->num() - 1 ?>">
          <figure>
            <img src="<?= $work->image()->url() ?>" alt="<?= $work->title() ?>">
            <figcaption><a href="<?= $site->find('timeline')->url() ?>#<?= $work->slug() ?>">
            <p class="italic"><?= $work->title() ?></p>
            <div class="details">
                <span><?= $work->material() ?></span>
                <span class="old-style-number"><?= $work->size() ?></span></div></a></figcaption></p>
          </figure>
        </a>
      </li>
    <?php endforeach ?>
  </ul>

  <!-- Modal for large image display -->
  <div id="imageModal" class="modal">
    <div class="modal-content">
    <span class="close-modal">close</span>
      <div class="fade">
        <?php foreach ($page->children()->listed() as $work): ?>
          <div>
            <img src="<?= $work->image()->url() ?>" alt="<?= $work->title() ?>">
            <div class="carousel-caption">
            <div class="carousel-counter"></div>
                    <p class="carousel-title"><?= $work->title() ?></p>
                    <div class="carousel-details">
                    <span class="carousel-material"><?= $work->material() ?></span>
                    <span class="old-style-number"><?= $work->size() ?></span></div>
                </div>
          </div>
        <?php endforeach ?>
        
      </div>
    </div>
  </div>


  <style>
    
    /* Basic modal styling */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100vw;
      height: 100vh;
      overflow: hidden;
      background-color: white;
    }

    .modal-content {
      position: relative;
      width: 100%;
      height: 100vh; 
    }

    .fade .slick-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: white;
  }

  .fade .slick-slide img {
    max-width: calc(100vw - 210px); /* Adjust the width to fit within the viewport */
    max-height: calc(100vh - 210px); /* Adjust the height to fit within the viewport */
    object-fit: contain; /* Maintain aspect ratio without distortion */
    margin: auto; /* Ensure the image is centered */
  }

  .fade .slick-prev, .slick-next {
    width: 50%; /* Each arrow covers half of the carousel */
    height: 100vh; /* Full height of the carousel */
    position: absolute;
    bottom: 0; 
    z-index: 1000; /* Ensure arrows are above content */
    align-items: center;
    justify-content: center;
    cursor: none;
    background: transparent; /* Make background transparent */
  }
  
  .fade .slick-prev:before, .fade .slick-next:before {
    display: none; /* Hide default arrows */
  }

  .close-modal {
    font-size: 16px;
    color: black; 
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    z-index: 1001;
    padding: 20px;
    background: transparent;
}

.close-modal:hover {
    color: grey; /* Optional: Change color on hover for better visibility */
}

  .custom-cursor {
    font-size: 16px;
    position: absolute;
    pointer-events: none;
    color: black;
    z-index: 1001;
    display: none; /* Hidden by default */
  }
  .fade .slick-slide .carousel-caption {
    position: absolute;
    bottom: 20px;
    text-align: center;
    width: 100vw;
    left: 50%;
    transform: translateX(-50%);
  }
  .carousel-title {
    font-size: 16px;
    margin: 0;
  }
  .carousel-counter {
  position: absolute;
  bottom: 20px;
  text-align: left;
  left: 5%; /* Center horizontally */ 
}
@media (max-width: 1000px) {
  html {
    font-size: 15px;
  }
  .fade .slick-slide img {
    max-width: calc(100vw - 80px ); /* Adjust the width to fit within the viewport */
    max-height: calc(100vh - 80px ); /* Adjust the height to fit within the viewport */
    object-fit: contain; /* Maintain aspect ratio without distortion */
    margin: auto; /* Ensure the image is centered */
  }
}
  
  </style>

    <!-- Include jQuery first -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Include Slick Carousel -->
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    // Initialize Slick carousel inside the modal
    $('.fade').slick({
      dots: true,
      infinite: true,
      speed: 300,
      fade: true,
      cssEase: 'linear'
    });

    var totalSlides = $('.fade').slick('getSlick').slideCount;
    updateCounter(0, totalSlides);

    // Update the counter on slide change
    $('.fade').on('afterChange', function(event, slick, currentSlide){
      updateCounter(currentSlide, totalSlides);
    });

    function updateCounter(currentSlide, totalSlides) {
      var currentIndex = currentSlide + 1; // +1 because currentSlide is 0-based
      $('.carousel-counter').text(currentIndex + '/' + totalSlides);
    }

    $('.carousel-caption').each(function() {
        var parentWidth = $(this).closest('.body').width();
        $(this).css('width', parentWidth + 'px');
    });

    // Open the modal with the Slick slider on image click
    $('.open-gallery').on('click', function(e) {
      e.preventDefault();
      const index = $(this).data('index');
      $('#imageModal').fadeIn();
      $('.fade').slick('slickGoTo', index);
    });

    $('.close-modal').on('click', function() {
      $('#imageModal').fadeOut();
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

$('.fade .slick-prev, .fade .slick-next').on('mouseleave', function() {
$customCursor.hide();
});

    // Close the modal when clicking outside the image
    $('#imageModal').on('click', function(e) {
      if ($(e.target).closest('.modal-content').length === 0) {
        $(this).fadeOut();
      }
    });
  });
  
  window.addEventListener('resize', function() {
  const menuUl = document.querySelector('header .menu ul');
  const computedStyle = window.getComputedStyle(menuUl);
  console.log("The width of header .menu ul is:", computedStyle.width);
});



</script>
</main>




