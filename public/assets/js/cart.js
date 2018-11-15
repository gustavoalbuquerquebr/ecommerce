"use strict";

let table = document.querySelector("table");

if (table !== null) {
  table.addEventListener("click", function(e) {
    if (e.target.classList.contains("delete_cart")) {
      let target_row = e.target.parentElement.parentElement;
      let id = e.target.id;

      let data = new FormData();
      data.set("cart", "delete");
      data.set("id", id);

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "cart.php", true);

      xhr.onload = function() {
        window.location.reload();
      };

      xhr.send(data);

      target_row.parentElement.removeChild(target_row);
    }
  });
}
