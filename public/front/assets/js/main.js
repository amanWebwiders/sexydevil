

(function ($) {
  "use strict";

  $(document).ready(function () {
    /*-----------------------------------
    01. Mobile Menu  
    -----------------------------------*/
    $("#mobile-menu").meanmenu({
      meanMenuContainer: ".mobile-menu",
      meanScreenWidth: "1199",
      meanExpand: ['<i class="far fa-plus"></i>'],
    });

    /*-----------------------------------
    02. Sidebar Toggle  
    -----------------------------------*/
    $(".offcanvas__close,.offcanvas__overlay").on("click", function () {
      $(".offcanvas__info").removeClass("info-open");
      $(".offcanvas__overlay").removeClass("overlay-open");
    });
    $(".sidebar__toggle").on("click", function () {
      $(".offcanvas__info").addClass("info-open");
      $(".offcanvas__overlay").addClass("overlay-open");
    });


    /*-----------------------------------
    03. Jquery Header Search
    -----------------------------------*/
    $('.search-btn').on('click', function (e) {
      e.preventDefault();
      $('body').css('overflow', 'hidden');

      $('.search-form-wrapper').addClass('active');
    });
    $('.search-close').on('click', function (e) {
      e.preventDefault();
      $('body').css('overflow', 'auto');
      $('.search-form-wrapper').removeClass('active');
    });

    window.onclick = function (e) {
      if (e.target.matches(".search-form-wrapper")) {
        $('.search-form-wrapper').removeClass('active');
      }
    }


    /*-----------------------------------
    04. Body Overlay 
    -----------------------------------*/
    $(".body-overlay").on("click", function () {
      $(".offcanvas__area").removeClass("offcanvas-opened");
      $(".df-search-area").removeClass("opened");
      $(".body-overlay").removeClass("opened");
    });


    /*-----------------------------------
      05. Sticky Header 
    -----------------------------------*/
    $(document).on('scroll', function () {
      if ($(this).scrollTop() > 250) {
        $("#header-sticky").addClass("sticky");
      } else {
        $("#header-sticky").removeClass("sticky");
      }
    });

    /*-----------------------------------
    06. Counterup 
    -----------------------------------*/
    $('.counters-item').counterUp({
      delay: 10,
      time: 1000
    });


    /*-----------------------------------
    07. Wow Animation 
    -----------------------------------*/
    new WOW().init();


    /*-----------------------------------
    08. Set Background Image & Mask   
    -----------------------------------*/
    if ($("[data-bg-src]").length > 0) {
      $("[data-bg-src]").each(function () {
        var src = $(this).attr("data-bg-src");
        $(this).css("background-image", "url(" + src + ")");
        $(this).removeAttr("data-bg-src").addClass("background-image");
      });
    }


    /*-----------------------------------
    09. // faq section  
    -----------------------------------*/

    $(document).on('click', '.faq-question', function () {
      const question = $(this);
      const parent = question.parent();
      const accordion = parent.parent();

      // Close all open items
      accordion.find('.faq-item').each(function () {
        const item = $(this);
        if (item[0] !== parent[0]) { // Strict equality comparison
          item.removeClass('active');
          item.find('.faq-question').attr('aria-expanded', 'false');
          item.find('.faq-answer').css('max-height', '');
          item.find('.icon').html('&#x2b;');
        }
      });

      // Toggle the clicked item
      const isExpanded = question.attr('aria-expanded') === 'true'; // Strict equality comparison
      question.attr('aria-expanded', !isExpanded);
      const answer = parent.find('.faq-answer');

      if (isExpanded) {
        parent.removeClass('active');
        answer.css('max-height', '');
        question.find('.icon').html('&#x2b;');
      } else {
        parent.addClass('active');
        answer.css('max-height', answer[0].scrollHeight + 'px');
        question.find('.icon').html('&#x2212;');
      }
    });


    $(document).on('click', '.proj-accordion-header', function () {
      const currentItem = $(this).parent();
      const accordionItems = $('.proj-accordion-item');

      accordionItems.each(function () {
        const item = $(this);
        if (item[0] !== currentItem[0]) { // strict equality comparison
          item.removeClass('proj-active');
          item.find('.proj-accordion-body').css('height', '0');
        }
      });

      const body = currentItem.find('.proj-accordion-body');
      if (currentItem.hasClass('proj-active')) {
        body.css('height', '0');
      } else {
        body.css('height', body[0].scrollHeight + 'px');
      }

      currentItem.toggleClass('proj-active');
    });


    /*-----------------------------------
    10. // Isotope
    -----------------------------------*/
    var $grid = $('.project-active').isotope({
      itemSelector: '.project-item',
      percentPosition: true,
      masonry: {
        columnWidth: 2,
        stagger: 30,
        transitionDuration: '0.8s',
      }
    });
    $('.filter-buttons button').on('click', function () {
      var filterValue = $(this).attr('data-filter');
      $grid.isotope({ filter: filterValue });

      $('.filter-buttons button').removeClass('active');
      $(this).addClass('active');
    });


    /*-----------------------------------
    11.Global Slider
    -----------------------------------*/
    function applyAnimationProperties() {
      $("[data-ani]").each(function () {
        var animationClass = $(this).data("ani");
        $(this).addClass(animationClass);
      });

      $("[data-ani-delay]").each(function () {
        var delay = $(this).data("ani-delay");
        $(this).css("animation-delay", delay);
      });
    }

    applyAnimationProperties();

    function initializeSwiper(sliderContainer) {
      var sliderOptions = sliderContainer.data("slider-options");

      console.log("Slider options: ", sliderOptions);

      var previousArrow = sliderContainer.find(".slider-prev");
      var nextArrow = sliderContainer.find(".slider-next");
      var paginationElement = sliderContainer.find(".slider-pagination");
      var numberedPagination = sliderContainer.find(
        ".slider-pagination.pagi-number"
      );

      var paginationStyle = sliderOptions["paginationType"] || "bullets";
      var autoplaySettings = sliderOptions["autoplay"] || {
        delay: 6000,
        disableOnInteraction: false,
      };

      var defaultSwiperConfig = {
        slidesPerView: 1,
        spaceBetween: sliderOptions["spaceBetween"] || 24,
        loop: sliderOptions["loop"] !== false,
        speed: sliderOptions["speed"] || 1000,
        initialSlide: sliderOptions["initialSlide"] || 0,
        centeredSlides: !!sliderOptions["centeredSlides"],
        effect: sliderOptions["effect"] || "slide",
        fadeEffect: {
          crossFade: true,
        },
        autoplay: autoplaySettings,
        navigation: {
          nextEl: nextArrow.length ? nextArrow.get(0) : null,
          prevEl: previousArrow.length ? previousArrow.get(0) : null,
        },
        pagination: {
          el: paginationElement.length ? paginationElement.get(0) : null,
          type: paginationStyle,
          clickable: true,
          renderBullet: function (index, className) {
            var bulletNumber = index + 1;
            var formattedNumber =
              bulletNumber < 10 ? "0" + bulletNumber : bulletNumber;
            if (numberedPagination.length) {
              return (
                '<span class="' +
                className +
                ' number">' +
                formattedNumber +
                "</span>"
              );
            } else {
              return (
                '<span class="' +
                className +
                '" aria-label="Go to Slide ' +
                formattedNumber +
                '"></span>'
              );
            }
          },
        },
        on: {
          slideChange: function () {
            setTimeout(
              function () {
                this.params.mousewheel.releaseOnEdges = false;
              }.bind(this),
              500
            );
          },
          reachEnd: function () {
            setTimeout(
              function () {
                this.params.mousewheel.releaseOnEdges = true;
              }.bind(this),
              750
            );
          },
        },
      };

      var finalConfig = $.extend({}, defaultSwiperConfig, sliderOptions);
      console.log("Complete Swiper options: ", finalConfig);

      // Initialize the Swiper instance
      return new Swiper(sliderContainer.get(0), finalConfig);
    }

    // Initialize Swiper on page load
    var swiperInstances = [];
    $(".pf-slider").each(function () {
      var sliderContainer = $(this);
      var swiperInstance = initializeSwiper(sliderContainer);
      swiperInstances.push(swiperInstance);
    });

    // Bootstrap tab show event
    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
      var targetTab = $(e.target).attr("href");
      $(targetTab)
        .find(".et-slider")
        .each(function () {
          var sliderContainer = $(this);
          if (!sliderContainer[0].swiper) {
            initializeSwiper(sliderContainer);
          } else {
            sliderContainer[0].swiper.update();
          }
        });
    });

    // Add click event handlers for external slider arrows based on data attributes
    $("[data-slider-prev], [data-slider-next]").on("click", function () {
      var targetSliderSelector =
        $(this).data("slider-prev") || $(this).data("slider-next");
      var targetSlider = $(targetSliderSelector);

      if (targetSlider.length) {
        var swiper = targetSlider[0].swiper;

        if (swiper) {
          if ($(this).data("slider-prev")) {
            swiper.slidePrev();
          } else {
            swiper.slideNext();
          }
        }
      }
    });


    /*-----------------------------------
    12. Back to top    
    -----------------------------------*/
    $(window).on('scroll', function () {
      if ($(this).scrollTop() > 20) {
        $("#back-top").addClass("show");
      } else {
        $("#back-top").removeClass("show");
      }
    });

    $("#back-top").on('click', function () {
      $("html, body").animate({ scrollTop: 0 }, 800);
      return false;
    });


    /*-----------------------------------
    13. NiceSelect     
    -----------------------------------*/
    if ($(".single-select").length > 0) {
      $(".single-select").niceSelect();
    }


    /*----------------------------------- 
    14. Mouse Cursor    
    -----------------------------------*/
    function mousecursor() {
      if ($("body").length > 0) {  // Strict Equality Comparison applied
        const e = document.querySelector(".cursor-inner"),
          t = document.querySelector(".cursor-outer");
        let n,
          i = 0,
          o = false;

        window.addEventListener("mousemove", function (s) {
          if (!o) {
            t.style.transform = `translate(${s.clientX}px, ${s.clientY}px)`;
          }
          e.style.transform = `translate(${s.clientX}px, ${s.clientY}px)`;
          n = s.clientY;
          i = s.clientX;
        });

        $("body").on("mouseenter", "a, .cursor-pointer", function () {
          e.classList.add("cursor-hover");
          t.classList.add("cursor-hover");
        });

        $("body").on("mouseleave", "a, .cursor-pointer", function () {
          if (!$(this).is("a") || $(this).closest(".cursor-pointer").length === 0) {
            e.classList.remove("cursor-hover");
            t.classList.remove("cursor-hover");
          }
        });

        e.style.visibility = "visible";
        t.style.visibility = "visible";
      }
    }

    $(function () {
      mousecursor();
    });


    /*--------------------------------------------------
    15. Search Popup
    ---------------------------------------------------*/
    const $searchWrap = $(".search-wrap");
    const $navSearch = $(".nav-search");
    const $searchClose = $("#search-close");

    $(".search-trigger").on("click", function (e) {
      e.preventDefault();
      $searchWrap.animate({ opacity: "toggle" }, 500);
      $navSearch.add($searchClose).addClass("open");
    });

    $(".search-close").on("click", function (e) {
      e.preventDefault();
      $searchWrap.animate({ opacity: "toggle" }, 500);
      $navSearch.add($searchClose).removeClass("open");
    });

    function closeSearch() {
      $searchWrap.fadeOut(200);
      $navSearch.add($searchClose).removeClass("open");
    }

    $(document.body).on("click", function (e) {
      closeSearch();
    });

    $(".search-trigger, .main-search-input").on("click", function (e) {
      e.stopPropagation();
    });


    /*--------------------------------------------------
    16. accordion-items
     ---------------------------------------------------*/
    $(document).on("click", ".accordion-header", function () {
      const target = $(this).data("target");

      // Collapse all other contents
      $(".accordion-content").not(target).slideUp();
      $(".accordion-item").removeClass("active");

      // Expand the selected content
      $(target).slideToggle();
      $(this).closest(".accordion-item").toggleClass("active");
    });


    /*-----------------------------------
    17. Smooth Wrapper
    -----------------------------------*/
    if ($("#smooth-wrapper").length && $("#smooth-content").length) {
      gsap.registerPlugin(ScrollTrigger, ScrollSmoother, TweenMax, ScrollToPlugin);

      gsap.config({
        nullTargetWarn: false,
      });

      const smoother = ScrollSmoother.create({
        smooth: 2,
        effects: true,
        smoothTouch: true,
        normalizeScroll: false,
        ignoreMobileResize: true,
      });
    }

    // Animation gsap /text spile
    if (quote.animation) {
      quote.animation.progress(1).kill();
      quote.split.revert();
    }

    const getClass = quote.closest('.sec-title-animation').className;
    const animation = getClass.split('animation-')[1];

    if (animation === "style4") return;

    quote.split = new SplitText(quote, {
      type: "lines,words,chars",
      linesClass: "split-line"
    });

    gsap.set(quote, { perspective: 400 });

    switch (animation) {
      case "style1":
        gsap.set(quote.split.chars, {
          opacity: 0,
          y: "90%",
          rotateX: "-40deg"
        });
        break;
      case "style2":
        gsap.set(quote.split.chars, {
          opacity: 0,
          x: "50"
        });
        break;
      case "style3":
        gsap.set(quote.split.chars, { opacity: 0 });
        break;
    }

    quote.animation = gsap.to(quote.split.chars, {
      scrollTrigger: {
        trigger: quote,
        start: "top 90%",
      },
      x: "0",
      y: "0",
      rotateX: "0",
      opacity: 1,
      duration: 1,
      ease: Back.easeOut,
      stagger: 0.02
    });

    ScrollTrigger.addEventListener("refresh", title_animation);


    /*-----------------------------------
    18. Reveal Animation
    -----------------------------------*/
    if ($('.reveal').length) {
      gsap.registerPlugin(ScrollTrigger);

      // Select all elements with the class .reveal
      const revealContainers = document.querySelectorAll(".reveal");

      revealContainers.forEach((container) => {
        const image = container.querySelector("img");

        // Create a new GSAP timeline for each container
        const tl = gsap.timeline({
          scrollTrigger: {
            trigger: container,
            toggleActions: "play none none none"
          }
        });

        // Set initial state of container to visible (autoAlpha)
        tl.set(container, { autoAlpha: 1 });

        // Animate container from left to right
        tl.from(container, {
          duration: 1.5,
          xPercent: -100,
          ease: Power2.out
        });

        // Animate image from right to left with scaling
        tl.from(image, {
          duration: 1.5,
          xPercent: 100,
          scale: 1.3,
          delay: -1.5,
          ease: Power2.out
        });
      });
    }


    /*-----------------------------------
    19. MagnificPopup  view    
    -----------------------------------*/
    $(".popup-video").magnificPopup({
      type: "iframe",
      removalDelay: 260,
      mainClass: "mfp-zoom-in",
    });

    $(".img-popup").magnificPopup({
      type: "image",
      gallery: {
        enabled: true,
      },
    });


    /*--------------------------------------------------
    20. countdown 
    ---------------------------------------------------*/
    function countdown() {
      var countDate = new Date("Oct 27, 2024 2:59:40").getTime();

      var now = new Date().getTime();

      var gap = countDate - now;

      var second = 1000;
      var minute = second * 60;
      var hour = minute * 60;
      var day = hour * 24;

      var days = Math.floor(gap / day);
      var hours = Math.floor((gap % day) / hour);
      var minutes = Math.floor((gap % hour) / minute);
      var seconds = Math.floor((gap % minute) / second);

      $('#days').text(days);
      $('#hours').text(hours);
      $('#minutes').text(minutes);
      $('#seconds').text(seconds);
    }

    setInterval(countdown, 1000);


    /*--------------------------------------------------
    21. Quantity Plus Minus
    ---------------------------------------------------*/
    $(".quantity-plus").each(function () {
      $(this).on("click", function (e) {
        e.preventDefault();
        var $qty = $(this).siblings(".qty-input");
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal)) {
          $qty.val(currentVal + 1);
        }
      });
    });

    $(".quantity-minus").each(function () {
      $(this).on("click", function (e) {
        e.preventDefault();
        var $qty = $(this).siblings(".qty-input");
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal) && currentVal > 1) {
          $qty.val(currentVal - 1);
        }
      });
    });
  });


  /*-----------------------------------
    22. Preloader   
  -----------------------------------*/

  function loader() {
    $(window).on("load", function () {
      // Animate loader off screen
      $(".preloader").addClass("loaded");
      $(".preloader").delay(600).fadeOut();
    });
  }

  loader();


})(jQuery);

// End jQuery


