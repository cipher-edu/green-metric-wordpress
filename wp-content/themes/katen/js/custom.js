(function($){
  $(window).on('load', function(){
      "use strict";
      /*=========================================================================
              Preloader
      =========================================================================*/
      $("#preloader").delay(750).fadeOut('slow');

      /*=========================================================================
              Social share toggle
      =========================================================================*/
      $(document).on("click", "button.toggle-button", function(e) {
        $(this).next('.social-share .icons').toggleClass("visible");
        $(this).toggleClass('icon-close').toggleClass('icon-share');
      });

      /*=========================================================================
      Infinite Scroll
      =========================================================================*/
      var curPage = 1;
      var pagesNum = $(".pagination").find("li:last-child a").text();   // Number of pages

      var $container = $('.infinite-wrapper');
      $container.infinitescroll({
          itemSelector: '.post-item',
          nextSelector: '.pagination li a',
          navSelector: '.pagination',
          extraScrollPx: 0,
          bufferPx: 0,
          maxPage: 999,
          loading: {
              finishedMsg: "You have reached the end!",
              msgText: '',
              speed: 'fast',
              selector: '.load-more',
          }
      },
      // trigger Masonry as a callback
      function( newElements ) {

        // Check last page
        curPage++;
        if(curPage == pagesNum) {
          $( '.load-more' ).remove();
        }
      });

      $container.infinitescroll( 'unbind' );

      $( '.load-more .btn' ).on('click', function() {
        $container.infinitescroll( 'retrieve' );
        // display loading icon
        $( '.load-more .btn i' ).css('display', 'inline-block');
        $( '.load-more .btn i' ).addClass('fa-sharp fa-solid fa-spinner-third fa-spin');

        $(document).ajaxStop(function () {
          setTimeout(function(){
                // hide loading icon
            $( '.load-more .btn i' ).hide();
          }, 1000);
        });
        return false;
      });

  });

  $(document).ready(function() {
      "use strict";

      $(window).scroll(() => {

          //get total height
          let docHeight = $(".site-wrapper").height();

          //get window height
          let winHeight = $(window).height();

          //calculate the view port
          let viewport = docHeight - winHeight;

          //get current scroll position
          let scrollPos = $(window).scrollTop();

          //get current scroll percent
          let scrollPercent = (scrollPos / viewport) * 100;

          //add the percent to the top progress bar
          $(".reading-bar").css("width", scrollPercent + "%");
      });

      /*=========================================================================
              Slick sliders
      =========================================================================*/
      $('.post-carousel-lg').slick({
        dots: true,
        arrows: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        cssEase: 'linear',
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              dots: true,
              arrows: false,
            }
          }
        ]
      });

      $('.post-gallery').slick({
        dots: false,
        arrows: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        cssEase: 'linear',
        adaptiveHeight: false,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              dots: false,
              arrows: true,
            }
          }
        ]
      });

      $('.post-carousel-featured').slick({
        dots: true,
        arrows: false,
        slidesToShow: 5,
        slidesToScroll: 2,
        responsive: [
          {
            breakpoint: 1440,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 4,
              dots: true,
              arrows: false,
            }
          },
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              dots: true,
              arrows: false,
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
              dots: true,
              arrows: false,
            }
          }
          ,
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              dots: true,
              arrows: false,
            }
          }
        ]
      });

      $('.post-carousel-twoCol').slick({
        dots: false,
        arrows: false,
        slidesToShow: 2,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
              dots: false,
              arrows: false,
            }
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              dots: false,
              arrows: false,
            }
          }
        ]
      });
      // Custom carousel nav
      $('.carousel-topNav-prev').click(function(){ 
        $('.post-carousel-twoCol').slick('slickPrev');
      } );
      $('.carousel-topNav-next').click(function(){ 
        $('.post-carousel-twoCol').slick('slickNext');
      } );


      $('.post-carousel-widget').slick({
        dots: false,
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 991,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
            }
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
              centerMode: true,
              slidesToScroll: 1,
            }
          }
        ]
      });
      // Custom carousel nav
      $('.carousel-botNav-prev').click(function(){ 
        $('.post-carousel-widget').slick('slickPrev');
      } );
      $('.carousel-botNav-next').click(function(){ 
        $('.post-carousel-widget').slick('slickNext');
      } );

      /*=========================================================================
              Sticky header
      =========================================================================*/
      var $header = $(".header-default, .header-personal nav, .header-classic .header-bottom"),
        $clone = $header.before($header.clone().addClass("clone"));

      $(window).on("scroll", function() {
        var fromTop = $(window).scrollTop();
        $('body').toggleClass("down", (fromTop > 300));
      });

  });

  $(function(){
      "use strict";

      //Create the cookie object
        var cookieStorage = {
          setCookie: function setCookie(key, value, time, path) {
              var expires = new Date();
              expires.setTime(expires.getTime() + time);
              var pathValue = '';
              if (typeof path !== 'undefined') {
                  pathValue = 'path=' + path + ';';
              }
              document.cookie = key + '=' + value + ';' + pathValue + 'expires=' + expires.toUTCString();
          },
          getCookie: function getCookie(key) {
              var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
              return keyValue ? keyValue[2] : null;
          },
          removeCookie: function removeCookie(key) {
              document.cookie = key + '=; Max-Age=0; path=/';
          }
      };

      //Click on dark mode icon. Add dark mode classes and wrappers. Store user preference through sessions
      $('.switcher-button').click(function() {
          //Show either moon or sun
          $('.switcher-button').toggleClass('active');
          //If dark mode is selected
          if ($('.switcher-button').hasClass('active')) {
              //Add dark mode class to the body
              $('body, header, .canvas-menu .logo').addClass('dark');
              cookieStorage.setCookie('yonkovNightMode', 'true', 2628000000, '/');
          } else {
              $('body, header, .canvas-menu .logo').removeClass('dark');
              setTimeout(function() {
                  cookieStorage.removeCookie('yonkovNightMode');
              }, 100);
          }
      })

      //Check Storage. Display user preference 
      if (cookieStorage.getCookie('yonkovNightMode')) {
          $('body, header, .canvas-menu .logo').addClass('dark');
          $('.switcher-button').addClass('active');
      }

      /*=========================================================================
              Vertical Menu
      =========================================================================*/
      $( ".vertical-menu .sub-menu" ).before( '<i class="icon-arrow-down switch"></i>' );

      $(".vertical-menu li i.switch").on( 'click', function() {
          var $submenu = $(this).next(".vertical-menu .sub-menu");
          $submenu.slideToggle(300);
          $submenu.parent().toggleClass("openmenu");
          $(this).toggleClass("rotated");
      });

      /*=========================================================================
              Canvas Menu
      =========================================================================*/
      $("button.burger-menu").on( 'click', function() {
        $(".canvas-menu").toggleClass("open");
        $(".main-overlay").toggleClass("active");
      });

      $(".canvas-menu .btn-close, .main-overlay").on( 'click', function() {
        $(".canvas-menu").removeClass("open");
        $(".main-overlay").removeClass("active");
      });

      /*=========================================================================
              Popups
      =========================================================================*/
      $("button.search").on( 'click', function() {
        $(".search-popup").addClass("visible");
      });

      $(".search-popup .btn-close").on( 'click', function() {
        $(".search-popup").removeClass("visible");
      });

      $(document).keyup(function(e) {
            if (e.key === "Escape") { // escape key maps to keycode `27`
              $(".search-popup").removeClass("visible");
          }
      });

      /*=========================================================================
              Tabs loader
      =========================================================================*/
      $('button[data-bs-toggle="tab"]').on( 'click', function() {
        $(".tab-pane").addClass("loading");
        $('.lds-dual-ring').addClass("loading");
        setTimeout(function () {
            $(".tab-pane").removeClass("loading");
            $('.lds-dual-ring').removeClass("loading");
        }, 500);
      });

      /*=========================================================================
      Spacer with Data Attribute
      =========================================================================*/
      var list = document.getElementsByClassName('spacer');

      for (var i = 0; i < list.length; i++) {
        var size = list[i].getAttribute('data-height');
        list[i].style.height = "" + size + "px";
      }

      /*=========================================================================
      Background Image with Data Attribute
      =========================================================================*/
      var list = document.getElementsByClassName('data-bg-image');

      for (var i = 0; i < list.length; i++) {
        var bgimage = list[i].getAttribute('data-bg-image');
        list[i].style.backgroundImage  = "url('" + bgimage + "')";
      }

      /*=========================================================================
            Responsive Videos
    =========================================================================*/
    $(function() {
      // Find all YouTube and Vimeo videos
      var $allVideos = $("iframe[src*='www.youtube.com'], iframe[src*='player.vimeo.com']");

      // Figure out and save aspect ratio for each video
      $allVideos.each(function() {
        $(this)
          .data('aspectRatio', this.height / this.width)
          // and remove the hard coded width/height
          .removeAttr('height')
          .removeAttr('width');
      });

      // When the window is resized
      $(window).resize(function() {
        // Resize all videos according to their own aspect ratio
        $allVideos.each(function() {
          var $el = $(this);
          // Get parent width of this video
          var newWidth = $el.parent().width();
          $el
            .width(newWidth)
            .height(newWidth * $el.data('aspectRatio'));
        });

      // Kick off one resize to fix all videos on page load
      }).resize();
    });

    document.addEventListener("DOMContentLoaded", function(){
      // make it as accordion for smaller screens
      if (window.innerWidth < 992) {
      
        // close all inner dropdowns when parent is closed
        document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
          everydropdown.addEventListener('hidden.bs.dropdown', function () {
            // after dropdown is hidden, then find all submenus
              this.querySelectorAll('.sub-menu').forEach(function(everysubmenu){
                // hide every submenu as well
                everysubmenu.style.display = 'none';
              });
          })
        });
      
        document.querySelectorAll('.dropdown-menu a').forEach(function(element){
          element.addEventListener('click', function (e) {
              let nextEl = this.nextElementSibling;
              if(nextEl && nextEl.classList.contains('sub-menu')) {	
                // prevent opening link if link needs to open dropdown
                e.preventDefault();
                if(nextEl.style.display == 'block'){
                  nextEl.style.display = 'none';
                } else {
                  nextEl.style.display = 'block';
                }
      
              }
          });
        })
      }
      // end if innerWidth
      }); 
      // DOMContentLoaded  end

  });
})(jQuery);

jQuery.event.special.touchstart = {
  setup: function( _, ns, handle ) {
      this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
  }
};
jQuery.event.special.touchmove = {
  setup: function( _, ns, handle ) {
      this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
  }
};
jQuery.event.special.wheel = {
  setup: function( _, ns, handle ){
      this.addEventListener("wheel", handle, { passive: true });
  }
};
jQuery.event.special.mousewheel = {
  setup: function( _, ns, handle ){
      this.addEventListener("mousewheel", handle, { passive: true });
  }
};