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
function profileDrop(){
  let profileDrop = document.querySelector('#profileDrop')
  
  if(profileDrop.classList.contains('drop-block')){
    profileDrop.classList.remove('drop-block')
  }else{
    profileDrop.classList.add('drop-block')
  }
}