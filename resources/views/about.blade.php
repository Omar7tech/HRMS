@include('components.private.header')
@include('components.private.sidebar')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .profile-container {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .profile-container:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 20px;
    }

    .profile-image img {
        width: 100%;
        height: auto;
    }

    .social-icons {
        list-style-type: none;
        padding: 0;
    }

    .social-icons li {
        display: inline;
        margin-right: 10px;
    }

    .social-icons a {
        color: #007bff;
        /* Bootstrap primary color */
        font-size: 24px;
    }
</style>

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Profile</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="profile-container text-center">
                        <div class="profile-image">
                            <img src="data:image/jpeg;base64,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"
                                alt="Profile Image">
                        </div>
                        <h3>Omar Abi Farraj</h3>
                        <p class="text-muted">Backend Engineer | Full Stack Web & Desktop Developer</p>
                        <p>With over seven years of experience, I specialize in developing robust solutions for
                            enterprise systems, enhancing business functionality and operational efficiency.</p>
                        <ul class="social-icons">
                            <li><a href="https://facebook.com" target="_blank"><i class="bi bi-facebook"></i></a></li>
                            <li><a href="https://twitter.com" target="_blank"><i class="bi bi-twitter"></i></a></li>
                            <li><a href="https://linkedin.com" target="_blank"><i class="bi bi-linkedin"></i></a></li>
                            <li><a href="https://github.com" target="_blank"><i class="bi bi-github"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('components.private.footer')
