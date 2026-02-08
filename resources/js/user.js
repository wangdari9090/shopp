// $(document).ready(function() {
    
//     // Re-initialize carousels or any other UI components
//     function initializeUI() {
//         const carousels = document.querySelectorAll('.carousel');
//         carousels.forEach(carouselEl => {
//             const existingInstance = bootstrap.Carousel.getInstance(carouselEl);
//             if (existingInstance) existingInstance.dispose();
//             const newCarousel = new bootstrap.Carousel(carouselEl, {
//                 interval: 3000,
//                 ride: 'carousel',
//                 pause: 'hover'
//             });
//             newCarousel.cycle(); 
//         });
//     }

//     // Capture EVERY link click on the site
//     $(document).on('click', 'a', function(event) {
//         const url = $(this).attr('href');

//         // Ignore: Empty links, external links, anchor fragments, or logout routes
//         if (!url || url === '#' || url.startsWith('#') || 
//             url.includes('logout') || 
//             (url.includes('http') && !url.includes(window.location.hostname))) {
//             return;
//         }

//         event.preventDefault(); // Stop the browser from reloading

//         $.ajax({
//             url: url,
//             type: "GET",
//             beforeSend: function() {
//                 // Fade out the main wrapper for a smooth transition
//                 $('#spa-main-wrapper').animate({ opacity: 0.3 }, 150);
//             },
//             success: function(response) {
//                 // 1. Update the Browser URL in the address bar
//                 window.history.pushState({ path: url }, '', url);

//                 // 2. Extract ONLY the #spa-main-wrapper from the full HTML response
//                 // This prevents the "Navbar inside Navbar" issue
//                 const newHtml = $(response).find('#spa-main-wrapper').html() || response;

//                 // 3. Inject the new content and fade back in
//                 $('#spa-main-wrapper').html(newHtml).animate({ opacity: 1 }, 150);

//                 // 4. Update the Page Title
//                 const newTitle = $(response).filter('title').text();
//                 if (newTitle) document.title = newTitle;

//                 // 5. Scroll to top
//                 window.scrollTo({ top: 0, behavior: 'instant' });

//                 // 6. Re-run our UI setup
//                 initializeUI();
//             },
//             error: function() {
//                 // If AJAX fails (e.g., network error), do a hard reload as a backup
//                 window.location.href = url;
//             }
//         });
//     });

//     // Handle Browser "Back" and "Forward" buttons
//     window.onpopstate = function() {
//         // When user goes back, we reload the content of the wrapper based on the new URL
//         $('#spa-main-wrapper').load(location.href + " #spa-main-wrapper > *", function() {
//             initializeUI();
//         });
//     };

//     // Initial run
//     initializeUI();
// });