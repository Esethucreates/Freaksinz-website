// Toggle menu
const menuBtn = document.querySelector(".right.menu .icons #menu-btn");
const sidebarMenu = document.querySelector(".ui.sidebar");
menuBtn.addEventListener("click", function () {
  sidebarMenu.classList.toggle("visible");
});

// Toggle profile manager
const profileBtn = document.querySelector(" .ui.menu .icons #user-btn");
const profileBtnContent = document.querySelector(
  ".ui.menu .icons #user-btn > div"
);
profileBtn.addEventListener("click", function () {
  profileBtnContent.classList.toggle("active-visible");
});
