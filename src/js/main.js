var md = new MobileDetect(window.navigator.userAgent);

var site = {
	rate : 500,
    timeout : 5000
};

Object.size = function(obj) {
	var size = 0, key;
	for (key in obj) {
		if (obj.hasOwnProperty(key)){
			size++;
		}
	}
	return size;
};

(function($) {

    /*
    *
    * Banner module
    *****************************************************************************
    *
    * Preloading banner module with 'src-set' support and object-fit
    *
    *****************************************************************************/

    if( $('.banner').length ){
        $wrapper = $('.banner-wrap');
        $slider = $('.banner');
        $preloader = $('.hero-preloader');

        $wrapper.append('<div class="slideshow-loader"></div>');
        $wrapper.find('.slideshow-loader').hide().fadeIn();

        $preloader.imagesLoaded(function(){

            $wrapper.find('.slideshow-loader').fadeOut(site.rate);

            $slider.cycle({
                speed : site.rate,
                timeout : site.timeout,
                swipe : true,
                slides : "> .banner-slide",
                fx : 'fadeout',
                swipeFx :  'scrollHorz'
            });
            $slider.delay(site.rate).fadeIn('slow');

        });

    }

    

    /*
    *
    * Google map module
    *****************************************************************************
    *
    * Needs key adding to functions.php
    *
    *
    *****************************************************************************/

    var mapStyle = [{"featureType":"all","elementType":"all","stylers":[{"saturation":-100},{"lightness":24}]}];

    function initializeMap(location,mapStyle,id) {

        console.log(mapStyle);

      var venue = new google.maps.LatLng(location.latitude, location.longitude);
      var mapOptions = {
        center: venue,
        scrollwheel: false,
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
        streetViewControl: false,
        zoomControl: true,
        zoomControlOptions: {
          style: google.maps.ZoomControlStyle.DEFAULT
        },
        styles : mapStyle
      };

      var map = new google.maps.Map(document.getElementById(id),mapOptions),
      icon,
      prefix = '';

      var marker = new google.maps.Marker({
        position: venue,
        map: map,
        // icon: icon,
        animation: google.maps.Animation.DROP,
        title:location.title
      });

    }

    if( $('.gmap').length ){
        $('.gmap').each(function(){
            var $this = $(this).attr('id');
            var ms = $(this).data('map-style');
            initializeMap({ longitude: $( "#"+$this ).data('lng'), latitude: $( "#"+$this ).data('lat') },ms,$this);
        });
    }

    /*
    *
    * Accordion module
    *****************************************************************************
    *
    * 
    *
    *****************************************************************************/

    $('.accordion-item .header').click(function(){
        $(this).parent().toggleClass('active');
        $(this).next().slideToggle();
    });
    
})(jQuery);