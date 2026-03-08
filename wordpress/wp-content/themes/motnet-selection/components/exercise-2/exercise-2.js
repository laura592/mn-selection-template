document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".exercise-2__play").forEach(btn => {
        btn.addEventListener("click", () => {
            const wrapper = btn.closest(".exercise-2__video");
            const url = wrapper.dataset.videoUrl;
            if (!url) return;

            const iframe = document.createElement("iframe");
            iframe.src = url;
            iframe.setAttribute("frameborder", "0");
            iframe.setAttribute("allow", "autoplay; fullscreen; picture-in-picture");
            iframe.setAttribute("allowfullscreen", "");
            wrapper.appendChild(iframe);
            wrapper.classList.add("is-playing");
        });
    });
});
