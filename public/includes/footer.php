<footer class="page_footer ds top_mask_add s-pb-10 s-pt-70 s-pb-md-40 s-pt-md-85">
    <div class="container">
        <div class="row">
            <div class="divider-20 d-none d-xl-block"></div>

            <div class="col-12 text-center" data-animation="fadeInUp">

                <!-- <div class="d-flex justify-content-center gap-3">
                    <a href="#">Home</a>
                    <a href="#"></a>
                    <a href="#"></a>
                    <a href="#"></a>    
                    <a href="#"></a>
                </div> -->

                <div class="widget widget_social_buttons">
                    <a href="#" class="fa fa-facebook color-bg-icon rounded" title="facebook"></a>
                    <a href="#" class="fa fa-twitter color-bg-icon rounded" title="twitter"></a>
                    <a href="#" class="fa fa-google color-bg-icon rounded" title="google"></a>
                </div>

                <div class="widget logo">
                    <img src="images/escort_logo.png" alt="img">
                </div>

                <div class="widget copyright">
                    <p>&copy; Copyright <span class="copyright_year">2025</span> All Rights Reserved</p>
                </div>
            </div>

        </div>
    </div>
</footer>


</div><!-- eof #box_wrapper -->
</div><!-- eof #canvas -->

<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content p-4">
            <div class="d-flex justify-content-between">
                <h5 class="modal-title">Find Escorts</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="filter-section ">
                <div class="row align-items-end filter-box">


                    <div class="row w-100 mb-3">
                        <div class="col-md-12">
                            <label class="filter-label">Escort type</label>
                            <input type="text" name="" class="form-control " id="" placeholder="Search by city or Province">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Gender</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Data type</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>
                    </div>

                    <div class="row w-100">
                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Sex options</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Ethnicites</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Body Types</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="filter-label">Prices</label>
                            <select class="custom-select">
                                <option>All</option>
                                <option>Independent</option>
                                <option>Agency</option>
                            </select>
                        </div>
                    </div>

                    <div class="row"></div>





                </div>
            </div>
            <div class="toggleButton mx-auto  btn btn-maincolor" data-toggle="modal" data-target="#filterModal">
                Apply filter
            </div>
        </div>


        <script src="js/compressed.js"></script>
        <script src="js/main.js"></script>
        <script src="js/switcher.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>


        <!-- Add this JavaScript -->
        <script>
            const mediaSection = document.querySelector('.media-upload-section');
            const mediaInput = document.getElementById('mediaInput');
            const mediaGrid = document.getElementById('mediaGrid');

            // Handle click on upload section
            mediaSection.addEventListener('click', () => mediaInput.click());

            // Handle drag and drop
            mediaSection.addEventListener('dragover', (e) => {
                e.preventDefault();
                mediaSection.style.borderColor = '#ff4444';
            });

            mediaSection.addEventListener('dragleave', () => {
                mediaSection.style.borderColor = '#ff4444';
            });

            mediaSection.addEventListener('drop', (e) => {
                e.preventDefault();
                mediaSection.style.borderColor = '#ff4444';
                handleFiles(e.dataTransfer.files);
            });

            // Handle file input
            mediaInput.addEventListener('change', (e) => handleFiles(e.target.files));

            function handleFiles(files) {
                for (const file of files) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        createMediaCard(file, e.target.result);
                    };

                    if (file.type.startsWith('image/')) {
                        reader.readAsDataURL(file);
                    } else {
                        createMediaCard(file);
                    }
                }
            }

            function createMediaCard(file, previewUrl) {
                const mediaItem = document.createElement('div');
                mediaItem.className = 'media-item';

                const fileType = file.type.split('/')[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';

                mediaItem.innerHTML = `
        ${previewUrl ? 
            `<img src="${previewUrl}" class="media-preview" alt="${file.name}">` : 
            `<div class="d-flex flex-column align-items-center p-3">
                <i class="${getFileIcon(fileType)} file-icon"></i>
                <span class="text-white">${fileType.toUpperCase()}</span>
            </div>`
        }
        <div class="media-info">
            <h6 class="text-truncate">${file.name}</h6>
            <small>${fileSize}</small>
        </div>
        <button class="delete-btn" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

                mediaGrid.appendChild(mediaItem);
            }

            function getFileIcon(type) {
                const icons = {
                    image: 'fas fa-file-image',
                    video: 'fas fa-file-video',
                    audio: 'fas fa-file-audio',
                    application: 'fas fa-file-pdf',
                    text: 'fas fa-file-alt'
                };
                return icons[type] || 'fas fa-file';
            }


            document.getElementById('mediaUpload').addEventListener('change', function(event) {
                const files = event.target.files;
                const previewContainer = document.getElementById('mediaPreview');
                const saveButtonContainer = document.getElementById('saveMediaContainer');

                previewContainer.innerHTML = ''; // Clear previous previews

                if (files.length > 0) {
                    saveButtonContainer.style.display = 'block';
                } else {
                    saveButtonContainer.style.display = 'none';
                }

                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const col = document.createElement('div');
                            col.className = 'col-md-3 col-sm-4 col-6 preview-tile';
                            col.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid">`;
                            previewContainer.appendChild(col);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>


        



        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <!-- FontAwesome for Stars -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script> -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/10.1.0/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://unpkg.co/gsap@3/dist/gsap.min.js"></script>




    
<script>
    //set video duration
    const videos = document.querySelectorAll(".story__slide video");
    videos.forEach((video) => {
        $(video)
            .parent(".story__slide")
            .attr("data-swiper-autoplay", video.duration * 1000);
    });

    const slider = new Swiper(".story__slider", {
        speed: 1,
        watchSlidesProgress: true,
        loop: true,
        autoplay: {
            delay: 15000,
            disableOnInteraction: false
        },
        slidesPerView: 1,
        navigation: {
            nextEl: ".story__next",
            prevEl: ".story__prev"
        },
        pagination: {
            el: ".story__pagination",
            renderBullet: function(index, className) {
                return (
                    '<div class="' +
                    className +
                    '"> <div class="swiper-pagination-progress"></div> </div>'
                );
            }
        },
        on: {
            autoplayTimeLeft(swiper, time, progress) {
                let currentSlide = document.querySelectorAll(".story__slider .swiper-slide")[
                    swiper.activeIndex
                ];
                let currentBullet = document.querySelectorAll(
                    ".story__slider .swiper-pagination-progress"
                )[swiper.realIndex];
                let fullTime = currentSlide.dataset.swiperAutoplay ?
                    parseInt(currentSlide.dataset.swiperAutoplay) :
                    swiper.params.autoplay.delay;

                let percentage =
                    Math.min(
                        Math.max(parseFloat((((fullTime - time) * 100) / fullTime).toFixed(1)), 0),
                        100
                    ) + "%";

                gsap.set(currentBullet, {
                    width: percentage
                });
            },
            transitionEnd(swiper) {
                let allBullets = $(".story__slider .swiper-pagination-progress");
                let bulletsBefore = allBullets.slice(0, swiper.realIndex);
                let bulletsAfter = allBullets.slice(swiper.realIndex, allBullets.length);
                if (bulletsBefore.length) {
                    gsap.set(bulletsBefore, {
                        width: "100%"
                    });
                }
                if (bulletsAfter.length) {
                    gsap.set(bulletsAfter, {
                        width: "0%"
                    });
                }

                let activeSlide = document.querySelectorAll(".story__slider .swiper-slide")[
                    swiper.realIndex
                ];
                if (activeSlide.querySelector("video")) {
                    activeSlide.querySelector("video").currentTime = 0;
                }
            }
        }
    });
</script>



        <script>
            // Radio-style Button logic
            $('.option-btn').click(function() {
                const group = $(this).data('group');

                // Ensure the correct button gets the 'active' class and others are cleared
                $(`.option-btn[data-group="${group}"]`).removeClass('active');
                $(this).addClass('active');

                calculateScore();
            });

            // Character Count
            $('#experienceText').on('input', function() {
                $('#charCount').text($(this).val().length);
            });

            // Rating Stars manual click
            $('#ratingStars i').click(function() {
                const rating = $(this).data('value');

                // Remove 'selected' class from all stars before adding to the selected ones
                $('#ratingStars i').removeClass('selected');

                $('#ratingStars i').each(function() {
                    if ($(this).data('value') <= rating) {
                        $(this).addClass('selected');
                    }
                });

                calculateScore(); // Optional: Call calculateScore if rating impacts the score calculation
            });

            // Auto Calculate Score
            function calculateScore() {
                let score = 0;

                // Check if 'Yes' is selected in the agreements group
                if ($('.option-btn[data-group="agreements"].active').text() === 'Yes') score += 1;

                // Check if 'Yes' is selected in the photos group
                if ($('.option-btn[data-group="photos"].active').text() === 'Yes') score += 1;

                // Check for ambience and hygiene selections and adjust score
                const ambience = $('.option-btn[data-group="ambience"].active').text();
                const hygiene = $('.option-btn[data-group="hygiene"].active').text();

                if (ambience === "Excellent") score += 2;
                else if (ambience === "Very satisfied") score += 1;

                if (hygiene === "Excellent") score += 2;
                else if (hygiene === "Very satisfied") score += 1;

                // Calculate final score as a rating
                const finalScore = Math.min(Math.round((score / 6) * 5), 5);

                // Update the rating stars based on the final score
                $('#ratingStars i').removeClass('selected');
                $('#ratingStars i').each(function() {
                    if ($(this).data('value') <= finalScore) {
                        $(this).addClass('selected');
                    }
                });
            }
        </script>




        </body>



        </html>