"use strict";

let images = document.querySelector("#images");
let deleteInput = document.querySelector("#delete");

images.addEventListener("click", function(e) {
  if (e.target.tagName.toLowerCase() === "img") {
    let image = e.target;

    if (deleteInput.value === "") {
      deleteInput.value = image.src;
    } else {
      deleteInput.value += "," + image.src;
    }

    image.parentElement.removeChild(image);
  }
});
