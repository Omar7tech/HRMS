@include('components.private.header')
@include('components.private.sidebar')
<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Online Jobs</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            <div class="container mt-5">
                <h1>Jobs in the market</h1>
                <!-- Dropdown menu for job categories -->
                <select id="categorySelect" class="form-control mb-3">
                    <option value="">All Fields</option>
                    <option value="business">Business Development</option>
                    <option value="copywriting">Copywriting &amp; Content</option>
                    <option value="supporting">Customer Success</option>
                    <option value="data-science">Data Science</option>
                    <option value="design-multimedia">Design &amp; Creative</option>
                    <option value="admin">DevOps &amp; SysAdmin</option>
                    <option value="engineering">Engineering</option>
                    <option value="accounting-finance">Finance &amp; Legal</option>
                    <option value="hr">HR &amp; Recruiting</option>
                    <option value="marketing">Marketing &amp; Sales</option>
                    <option value="management">Product &amp; Operations</option>
                    <option value="dev">Programming</option>
                </select>
                <div id="jobListingsAccordion"></div>
                <button id="showMoreBtn" class="btn btn-primary mt-3">Show More</button>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
            // Define the base API URL
            const baseUrl = 'https://jobicy.com/api/v2/remote-jobs';

            // Function to fetch jobs based on selected category
            async function fetchJobs(category) {
                let apiUrl = baseUrl + '?count=20';
                if (category) {
                    apiUrl += `&industry=${category}`;
                }
                try {
                    const response = await fetch(apiUrl);
                    const data = await response.json();
                    return data.jobs;
                } catch (error) {
                    console.error('Error fetching jobs:', error);
                }
            }

            // Function to render job listings as Bootstrap accordion
            function renderJobsAccordion(jobs) {
                const jobListingsAccordion = document.getElementById('jobListingsAccordion');
                jobs.forEach(job => {
                    const jobCard = `
                        <div class="card">
                            <div class="card-header" id="heading${job.id}">
                                <h2 class="mb-0">
                                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapse${job.id}" aria-expanded="true" aria-controls="collapse${job.id}">
                                        ${job.jobTitle} - ${job.companyName}
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse${job.id}" class="collapse" aria-labelledby="heading${job.id}" data-parent="#jobListingsAccordion">
                                <div class="card-body">
                                    <p>${job.jobDescription}</p>
                                    <a href="${job.url}" class="card-link">View Details</a>
                                </div>
                            </div>
                        </div>
                    `;
                    jobListingsAccordion.innerHTML += jobCard;
                });
            }

            let page = 1;
            let jobsPerPage = 10;

            // Function to load more jobs
            async function loadMoreJobs() {
                const category = document.getElementById('categorySelect').value;
                const jobs = await fetchJobs(category);
                renderJobsAccordion(jobs);
                page++;
            }

            // Event listener for "Show More" button
            document.getElementById('showMoreBtn').addEventListener('click', loadMoreJobs);

            // Event listener for category selection
            document.getElementById('categorySelect').addEventListener('change', () => {
                page = 1; // Reset page number when category changes
                loadMoreJobs();
            });
            document.getElementById('categorySelect').addEventListener('change', async () => {
    page = 1; // Reset page number when category changes
    const category = document.getElementById('categorySelect').value;
    const jobs = await fetchJobs(category);
    const jobListingsAccordion = document.getElementById('jobListingsAccordion');
    jobListingsAccordion.innerHTML = ''; // Clear existing job listings
    renderJobsAccordion(jobs);
    page++;
});

            // Initial load
            loadMoreJobs();
        </script>
    </div>
</section>
@include('components.private.footer')
