function myFunction(imgs) {
    document.getElementById("demoimg").style.display = "none"
    document.getElementById("expandedImg").style.display = "block"
    // Get the expanded image
    var expandImg = document.getElementById("expandedImg");
    // Get the image text
    var imgText = document.getElementById("imgtext");
    // Use the same src in the expanded image as the image being clicked on from the grid
    expandImg.src = imgs.src;
    // Use the value of the alt attribute of the clickable image as text inside the expanded image
    imgText.innerHTML = imgs.alt;
    // Show the container element (hidden with CSS)
    // expandImg.parentElement.style.display = "block";
  }


  
 
function openSearch(){
  let searcBtn = document.querySelector('#btnSearch')
  searcBtn.classList.add('product-search-active')
  // if(searcBtn.classList.contains('product-search-active')){
  //   searcBtn.classList.remove('product-search-active')
  // }else{
  //   searcBtn.classList.add('product-search-active')
  // }
}
function openSearch2(){
  let searcBtn = document.querySelector('#btnSearch2')
  searcBtn.classList.add('product-search-active')
  // if(searcBtn.classList.contains('product-search-active')){
  //   searcBtn.classList.remove('product-search-active')
  // }else{
  //   searcBtn.classList.add('product-search-active')
  // }
}
function profileDrop(){
  let profileDrop = document.querySelector('#profileDrop')
  
  if(profileDrop.classList.contains('drop-block')){
    profileDrop.classList.remove('drop-block')
  }else{
    profileDrop.classList.add('drop-block')
  }
}



  var button = document.getElementById('tbScrollNext');
        button.onclick = function () {
            var container = document.getElementById('scrollTB');
            sideScroll(container, 'right', 25, 100, 10);
        };

        var back = document.getElementById('tbScrollBack');
        back.onclick = function () {
            var container = document.getElementById('scrollTB');
            sideScroll(container, 'left', 25, 100, 10);
        };

        function sideScroll(element, direction, speed, distance, step) {
            scrollAmount = 0;
            var slideTimer = setInterval(function () {
                if (direction == 'left') {
                    element.scrollLeft -= step;
                } else {
                    element.scrollLeft += step;
                }
                scrollAmount += step;
                if (scrollAmount >= distance) {
                    window.clearInterval(slideTimer);
                }
            }, speed);
        }



function openNav(){
  let filterBar = document.querySelector('#myFilterSidebar')
  if(filterBar.classList.contains('filtersidenavclose')){
    filterBar.classList.remove('filtersidenavclose')
  }else{
    filterBar.classList.add('filtersidenavclose')
  }
}















