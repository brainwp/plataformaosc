window.addEvent('domready', function(){
    /* thumbnails example , div containers */
    new SlideItMoo({
        overallContainer: 'main-comite',
        elementScrolled: 'SlideItMoo_inner',
        thumbsContainer: 'SlideItMoo_items',
        itemsVisible:1,
        elemsSlide:1,
        duration:100,
        itemsSelector: '.SlideItMoo_element',
//        itemWidth: 65,
        showControls:1,
        startIndex:1
//		,
//        autoSlide: 5000
    });
});