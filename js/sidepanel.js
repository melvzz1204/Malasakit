const slidePanel = document.querySelectorAll(".li-slidepanel");
slidePanel.forEach((element) => {
  element.addEventListener("click", () => {
    slidePanel.forEach((btn) => btn.classList.remove("active"));
    element.classList.add("active");
  });
});
