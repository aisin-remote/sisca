// Scroll To Top
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        document.getElementById("scrollToTopBtn").style.display = "block";
    } else {
        document.getElementById("scrollToTopBtn").style.display = "none";
    }
}

document
    .getElementById("scrollToTopBtn")
    .addEventListener("click", function () {
        document.body.scrollTop = 0; // Untuk Safari
        document.documentElement.scrollTop = 0; // Untuk Chrome, Firefox, IE, Opera
    });
