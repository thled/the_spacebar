$(document).ready(function() {
   const $locationSelect = $('.js-article-form-location');
   const $specificLocationTarget = $('.js-specific-location-target');

   $locationSelect.on('change', function(e) {
       $.ajax({
           url: $locationSelect.data('specific-location-url'),
           data: {
               location: $locationSelect.val()
           },
           success: function (html) {
               if (!html) {
                   $specificLocationTarget.find('select').remove();
                   $specificLocationTarget.addClass('d-none');

                   return;
               }

               $specificLocationTarget.html(html).removeClass('d-none');
           }
       });
   });
});
