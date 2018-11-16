"use strict";

let current_page = window.location.href.split(/.public./).pop();

if (current_page.includes("index.php?page=")) {
  current_page = "index.php";
}

if (current_page.includes("admin")) {
  current_page = "admin";
}

let menu_item = "";

switch (current_page) {
  case "index.php":
    menu_item = "home_link";
    break;
  case "cart.php":
    menu_item = "cart_link";
    break;
  case "admin":
    menu_item = "admin_link";
    break;
}

if (menu_item !== "") {
  document.getElementById(menu_item).parentElement.classList.add("active");
}