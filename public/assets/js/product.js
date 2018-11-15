"use strict";

let add_cart = document.querySelector("#add_cart");

add_cart.addEventListener("click", function() {
  let data = new FormData();
  data.set("id", id);

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "product.php", true);
  xhr.send(data);
});
