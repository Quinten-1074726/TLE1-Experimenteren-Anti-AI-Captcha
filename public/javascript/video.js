
    document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggleCommentForm");
    const form = document.querySelector(".comment-form");

    toggleBtn.addEventListener("click", function () {
    form.classList.toggle("active");
    if (form.classList.contains("active")) {
    toggleBtn.textContent = "✖ Sluit formulier";
} else {
    toggleBtn.textContent = "+ Voeg een comment toe";
}
});
});
