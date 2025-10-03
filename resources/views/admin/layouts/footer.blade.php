 </div>

 <script src="{{ asset('js/admin.js') }}"></script>

 <!--====== Bootstrap js ======-->
 <script src="{{ asset('website/assets/vendor/popper/popper.min.js') }}"></script>
 <!--====== Jquery js ======-->
 <script src="{{ asset('website/assets/vendor/jquery-3.7.1.min.js') }}"></script>
 <!--====== Bootstrap js ======-->
 <script src="{{ asset('website/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
 <!--====== Slick js ======-->
 <script src="{{ asset('website/assets/vendor/slick/slick.min.js') }}"></script>
 <!--====== Magnific js ======-->
 <script src="{{ asset('website/assets/vendor/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
 <!--====== Nice-select js ======-->
 {{-- <script src="{{ asset('website/assets/vendor/nice-select/js/jquery.nice-select.min.js') }}"></script> --}}
 <!--====== Jquery Ui js ======-->
 <script src="{{ asset('website/assets/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
 <!--====== SimplyCountdown js ======-->
 <script src="{{ asset('website/assets/vendor/simplyCountdown.min.js') }}"></script>
 <!--====== Aos js ======-->
 <script src="{{ asset('website/assets/vendor/aos/aos.js') }}"></script>
 <!--====== Main js ======-->
 <script src="{{ asset('website/assets/js/theme.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js" defer></script>

 <!--====== Summernote JS ======-->
 <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
 <script>
     $(document).ready(function() {
         $('.summernote').summernote({
             height: 200, // Set the height of the editor
             tabsize: 2,
             toolbar: [
                 ['style', ['bold', 'italic', 'underline', 'clear']],
                 ['font', ['strikethrough', 'superscript', 'subscript']],
                 ['fontsize', ['fontsize']],
                 ['color', ['color']],
                 ['para', ['ul', 'ol', 'paragraph']],
                 ['height', ['height']]
             ]
         });
     });
 </script>



 </body>

 </html>
