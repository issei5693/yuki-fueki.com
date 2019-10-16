$(document).ready(function(){
/////////////////////////////////////////////////////////
//ページ遷移エフェクト
/////////////////////////////////////////////////////////

$('body').fadeMover();
$('main').fadeMover({
  'effectType': 1,
  'inSpeed': 3000,
  'outSpeed': 3000
  });

/////////////////////////////////////////////////////////
//Magnific Popup
/////////////////////////////////////////////////////////

$('.popup-gallery').magnificPopup({
  delegate: 'a',
  type: 'image',
  tLoading: 'Loading image #%curr%...',
  mainClass: 'mfp-img-mobile',
  gallery: {
    enabled: true,
    navigateByImgClick: true,
    preload: [0,1] // Will preload 0 - before current, and 1 after the current image
  },
  image: {
    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
    titleSrc: function(item) {
      var title = '<p class="imges-title">' + item.el.attr('title') + '</p>';
      var img_content = item.el.next('p').text();
      return title + img_content;
      //return title + '<small>by Marsel Van Oosten</small>';
    }
  }
});

/////////////////////////////////////////////////////////
//スマホメニューの開閉
/////////////////////////////////////////////////////////

$("#sp-menu").hide();
$("#sp-menu-btn").on('click' ,function(){
  $(this).toggleClass("sp-menu-btn-open");
  $("#sp-menu").slideToggle();
});

})//jQuery終了
