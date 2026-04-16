class MotorsHeroSlider extends elementorModules.frontend.handlers.Base{getDefaultSettings(){return{selectors:{hero_slider_wrap:'.stm-hero-slider-wrap',carousel:'.stm-hero-slider-carousel'},};}
getDefaultElements(){const selectors=this.getSettings('selectors');return{$hero_slider_wrap:this.$element.find(selectors.hero_slider_wrap),$carousel:this.$element.find(selectors.carousel),};}
onInit(){super.onInit()
const heroWrap=this.elements.$hero_slider_wrap;jQuery(heroWrap).addClass('loaded');let data=this.elements.$carousel.data();let options=data.options;let uniqid=this.elements.$carousel.data('widget-id');let slider_options={slidesPerView:1,spaceBetween:0,speed:500,}
if(options.hasOwnProperty('loop')&&options.loop)
slider_options.loop=true
if(options.hasOwnProperty('autoplay')&&options.autoplay){slider_options.autoplay={delay:1000,}
if(options.hasOwnProperty('delay')&&options.delay){slider_options.autoplay.delay=options.delay}}
if(options.hasOwnProperty('transition_speed')&&options.transition_speed)
slider_options.speed=options.transition_speed
if(options.hasOwnProperty('navigation')&&options.navigation){slider_options.navigation={nextEl:'.stm-hero-slider-carousel-'+uniqid+' .stm-hero-slider-nav-next',prevEl:'.stm-hero-slider-carousel-'+uniqid+' .stm-hero-slider-nav-prev',}}
let swiper=new Swiper('.stm-hero-slider-carousel-'+uniqid,slider_options);if(options.hasOwnProperty('pause_on_mouseover')&&options.pause_on_mouseover){$(swiper.$el[0]).hover(swiper.autoplay.stop,swiper.autoplay.start)}}}
jQuery(window).on('elementor/frontend/init',()=>{const addHandler=($element)=>{elementorFrontend.elementsHandler.addHandler(MotorsHeroSlider,{$element})}
elementorFrontend.hooks.addAction('frontend/element_ready/motors-hero-slider.default',addHandler);})