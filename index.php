<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fresh HomeStay</title>
    <?php require('inc/link.php') ?>

    <style>
        .availability-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width: 575px) {
            .availability-form {
                margin-top: 25px;
                padding: 0 35px;
            }
        }
    </style>
</head>

<body class="bg-light">

    <!-- navbar -->
    <?php require('inc/header.php') ?>

    <!-- Carousel -->
    <div class="container-fluid px-lg-4 mt-4 ">
        <!-- Swiper -->
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php 
                 $res = selectAll('carousel');

                 while($row = mysqli_fetch_assoc($res))
                 {
                     $path = CAROUSEL_IMG_PATH;
                     echo <<<data
                     <div class="swiper-slide">
                     <img src="$path$row[image]" class=" d-block" height="500px;" width="100%" style="object-fit: cover;"/>
                    </div>
                 data;
                 }
                ?>
            </div>
        </div>
    </div>

    <!-- Check availability form -->
    <!-- <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Booking Availability</h5>
                <form>
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight:500;">Check-in</label>
                            <input type="date" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight:500;">Check-out</label>
                            <input type="date" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight:500;">Adult</label>
                            <select class="form-select shadow-none">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label" style="font-weight:500;">Children</label>
                            <select class="form-select shadow-none">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> -->

    <!-- Our Rooms -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR ROOMS</h2>

    <div class="container">
        <div class="row">
        <?php 
                $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3",[1,0],'ii');
                while($room_data = mysqli_fetch_assoc($room_res))
                {
                    //get feature of room

                    $fea_q = mysqli_query($con,"SELECT f.name FROM  `features` f 
                    INNER JOIN `room_features` rfea ON f.id= rfea.features_id
                    WHERE rfea.room_id = '$room_data[id]'");

                    $features_data = "";
                    while($fea_row = mysqli_fetch_assoc($fea_q)){
                        $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                        $fea_row[name]
                        </span>";
                    }
                    
                    //get facilities of room
                    
                    $fac_q = mysqli_query($con,"SELECT f.name FROM  `facilities` f 
                    INNER JOIN `room_facilities` rfac ON f.id= rfac.facilities_id
                    WHERE rfac.room_id = '$room_data[id]'");

                    $facilities_data = "";
                    while($fac_row = mysqli_fetch_assoc($fac_q)){
                        $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                        $fac_row[name]
                        </span>";
                    }

                    //get thumbnail of image

                    $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
                    $thumb_q = mysqli_query($con,"SELECT * FROM `room_images` 
                    WHERE `room_id`='$room_data[id]' AND `thumb`='1'");

                    if(mysqli_num_rows($thumb_q)>0){
                        $thumb_res = mysqli_fetch_assoc($thumb_q);
                        $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
                    }
                    $book_btn = "";
                    if(!$settings_r['shutdown']){
                        $login=0;
                        if(isset($_SESSION['login']) && $_SESSION['login']==true){
                            $login=1;
                        }
                        $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Book Now</button>";
                    }
                    //print room card
                    echo <<<data
                        <div class="col-lg-4 col-md-6 my-3">
                            <div class="card border-8 shadow-none" style="max-width: 350px; margin: auto;">
                                <img src="$room_thumb" class="card-img-top">
                                <div class="card-body">
                                    <h5>$room_data[name]</h5>
                                    <h6 class="mb-4">$room_data[price] vnd/night</h6>
                                    <div class="features mb-4">
                                        <h6 class="mb-1">Features</h6>
                                        $features_data
                                    </div>
                                    <div class="facilities mb-4">
                                        <h6 class="mb-1">Facilities</h6>
                                        $facilities_data
                                    </div>
                                    <div class="guests mb-4">
                                        <h6 class="mb-1">Guests</h6>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap ">
                                        $room_data[adult] Adult
                                        </span>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap ">
                                        $room_data[children] Children
                                        </span>
                                    </div>
                                    <div class="rating mb-4">
                                        <h6 class="mb-1">Rating</h6>
                                        <span class="badge rounded-pill bg-light">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-evenly mb-2">
                                         $book_btn
                                        <a href="room_details.php?id=$room_data[id]" class="btn btn-outline-dark shadow-none">More details</a>
                                    </div>
                                </div>
                            </div>
                        </div>  
                data;
                }
                ?>
        
            
            <div class="col-lg-12 text-center mt-5">
                <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
            </div>
        </div>
    </div>

    <!-- OUR FACILITIES -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR FACILITIES</h2>

    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
        <?php 
              $res = mysqli_query($con,"SELECT * FROM `facilities` ORDER BY id DESC LIMIT 5");
              $path = FACILITIES_IMG_PATH;
              while($row = mysqli_fetch_assoc($res))
              {
                  echo <<<data
                  <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                      <img src="$path$row[icon]" width="50px">
                      <h5 class="mt-3">$row[name]</h5>
                   </div>
                  data;
              }
              ?>
          
            <div class="col-lg-12 text-center mt-5">
                <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities >>></a>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Member</h2>

    <div class="container mt-5">
        <!-- Swiper -->
        <div class="swiper swiper-testimonials ">
            <div class="swiper-wrapper mb-5">
                <div class="swiper-slide p-4">
                    <div class="profile d-flex align-items-center pb-3">
                        <img src="images/users/same.jpg" width="150px" height="150px">
                        <h6 class="m-0 ms-2">Mr Same</h6>
                    </div>
                    <p>
                        Job: Web developer (PHP & javascript)
                       </br>
                        Study: University of Phu yen 
                       </br>
                        Age: 23 
             
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>

                <div class="swiper-slide p-4">
                    <div class="profile d-flex align-items-center pb-3">
                        <img src="images/users/noy.jpg" width="150px" height="150px">
                        <h6 class="m-0 ms-2">Miss Noy</h6>
                    </div>
                    <p>
                       Job: Font-end developer (Vue & javascript)
                       </br>
                        Study: University of Phu yen 
                       </br>
                        Age: 22 
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>

                <div class="swiper-slide p-4">
                    <div class="profile d-flex align-items-center pb-3">
                        <img src="images/users/khuong.jpg" width="150px" height="150px">
                        <h6 class="m-0 ms-2">Miss Khuong</h6>
                    </div>
                    <p>
                       Job: Tester (Website)
                       </br>
                        Study: University of Phu yen 
                       </br>
                        Age: 22 
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>

            
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="col-lg-12 text-center mt-5">
            <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know more >>></a>
        </div>

    </div>

    <!-- Reach us -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe class="w-100 rounded" height="320px" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15543.843241811737!2d109.3173248!3d13.10166925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1663430775376!5m2!1svi!2s"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white rounded mb-4">
                    <h5>Call us</h5>
                    <a href="tel: +0376657843" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i>+0376657843
                    </a>
                    <br>
                    <a href="tel: +0376653453" class="d-inline-block  text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i>+0376653453
                    </a>
                </div>

                <div class="bg-white rounded mb-4">
                    <h5>Follow us</h5>
                    <a href="#" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-twitter me-1"></i>Twitter</span>
                    </a>
                    <br>
                    <a href="#" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook me-1"></i>Facebook</span>
                    </a>
                    <br>
                    <a href="#" class="d-inline-block ">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram me-1"></i>Instagram</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- footer -->
        <?php require('inc/footer.php') ?>




    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }
        });

        var swiper = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: "3",
            loop: true,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: 0,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    </script>



</body>

</html>