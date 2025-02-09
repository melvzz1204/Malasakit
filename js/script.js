document.addEventListener("DOMContentLoaded", function () {
  const contents = document.querySelectorAll(".content");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");
  let currentIndex = 0;

  function showContent(index) {
    contents.forEach((content, i) => {
      if (i === index) {
        content.classList.add("contentActive");
      } else {
        content.classList.remove("contentActive");
      }
    });
  }

  prevBtn.addEventListener("click", function () {
    if (currentIndex > 0) {
      currentIndex--;
      showContent(currentIndex);
    }
  });

  nextBtn.addEventListener("click", function () {
    if (currentIndex < contents.length - 1) {
      currentIndex++;
      showContent(currentIndex);
    }
  });


  showContent(currentIndex);
});
