let details = document.querySelectorAll("details");

details.forEach((detail) => {
  detail.addEventListener("toggle", () => {
    if (detail.open) {
      details.forEach((d) => {
        if (d !== detail) d.open = false;
      });
    }
  });
});