const slider = document.querySelector(".carousel-slider");

console.log(slider);

document.addEventListener("DOMContentLoaded", function () {
    let isOnEndSide = false;

    window.setInterval(() => {
        if (isOnEndSide) {
            slider.scroll({ left: 0, behavior: "smooth" });
        } else {
            slider.scroll({ left: slider.scrollWidth, behavior: "smooth" });
        }
        isOnEndSide = !isOnEndSide;
    }, [5000]);
});
