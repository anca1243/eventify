var myImage=document.getElementById("myPhoto");

var imageArray=["http://www.ultralightinghire.co.uk/media/IMG_3397.jpg", "http://www.solidstate-events.com/wp-content/uploads/main-bg.jpg", "http://www.ultralightinghire.co.uk/media/IMG_1629.jpg"];

var imageIndex=0;

function changeImage () {
  myPhoto.setAttribute("src", imageArray [ imageIndex]);
imageIndex++;
if (imageIndex>=imageArray.length) {
  imageIndex=0;
  }
}

var intervalHandle = setInterval(changeImage,2000);

myPhoto.onclick=function() {
  clearInterval(intervalHandle);
}