const menuBtn = document.querySelector(
  ".user-header .ui.menu .icons #menu-btn"
);

// Dropdown
const dropdown = document.querySelectorAll(
  ".quick-view .box .row .content .ui.accordion .title "
);

const dropdownContent = document.querySelectorAll(
  ".quick-view .box .row .content .ui.accordion > .title + .content"
);

for (let i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function () {
    dropdown[i].classList.toggle("active");
    dropdownContent[i].classList.toggle("active");
  });
}

// User button dropdown
const profileBtn = document.querySelector(" .ui.menu .icons #user-btn");
const profileBtnContent = document.querySelector(
  ".ui.menu .icons #user-btn > div"
);
profileBtn.addEventListener("click", function () {
  profileBtnContent.classList.toggle("active-visible");
});

// Toggle menu
const sidebarMenu = document.querySelector(".ui.sidebar");
menuBtn.addEventListener("click", function () {
  sidebarMenu.classList.toggle("visible");
});

//toggle filter
const filterDropdown = document.querySelector(
  ".category-header .filter-box > #filter"
);
const filterContent = document.querySelector(
  ".category-header .filter-box > #filter > .menu"
);

filterDropdown.addEventListener("click", function () {
  filterContent.classList.add("active-visible");
});
