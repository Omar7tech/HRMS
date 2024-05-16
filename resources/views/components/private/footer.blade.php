<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });
</script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<!-- Button to scroll to top -->
<button id="scrollToTopBtn" class="btn btn-primary rounded-circle"
    style="position: fixed; bottom: 20px; right: 20px; display: none;">
    <i class="bi bi-arrow-up"></i>
</button>
<style>
    #scrollProgress {
        position: fixed;
        bottom: 20px;
        right: 50px;
        width: 10px;
        height: 10px;
        border: 2px solid #000;
        border-radius: 50%;
        background-color: transparent;
        z-index: 9999;
        transition: transform 0.3s ease-in-out;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var scrollToTopBtn = document.getElementById("scrollToTopBtn");
        var scrollProgress = document.getElementById("scrollProgress");

        window.addEventListener("scroll", function() {
            if (window.pageYOffset > 100) {
                scrollToTopBtn.style.display = "block";
            } else {
                scrollToTopBtn.style.display = "none";
            }

            var windowHeight = window.innerHeight;
            var documentHeight = document.documentElement.scrollHeight;
            var scrollTop = window.pageYOffset;
            var progress = (scrollTop / (documentHeight - windowHeight)) * 100;
            scrollProgress.style.transform = "translateY(calc(-50% + " + progress + "%))";
        });

        scrollToTopBtn.addEventListener("click", function() {
            scrollToTop(350);
        });

        function scrollToTop(duration) {
            var start = window.pageYOffset;
            var startTime = performance.now();

            function scrollStep(timestamp) {
                var elapsed = timestamp - startTime;
                var progress = Math.min(elapsed / duration, 1);
                window.scrollTo(0, start * (1 - progress));

                if (progress < 1) {
                    requestAnimationFrame(scrollStep);
                }
            }

            requestAnimationFrame(scrollStep);
        }
    });
</script>

</body>

</html
