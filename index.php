<?php
       
        include 'connection.php';
        $profile = Database::select("SELECT * FROM profile LIMIT 1");
        $profileImage = ($profile && count($profile) > 0 && $profile[0]['image'])
            ? "images/profile_image/" . $profile[0]['image']
            : "https://ui-avatars.com/api/?name=Profile&background=ccc&color=fff";
        ?>      

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akila Shashimantha</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="<?php echo $profileImage; ?>">
    <style>
        .project-images-scroll {
            scrollbar-width: thin;
            scrollbar-color: #007bff #222;
        }
        .project-images-scroll::-webkit-scrollbar {
            height: 8px;
        }      
       .project-images-scroll::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 4px;
        }
        .project-images-scroll::-webkit-scrollbar-track {
            background: #222;
        }
    </style>
</head>
<body id="home" class=" p-0 m-0 ">
    
<?php 
include 'header.php';
?>
<hr class=" my-0 hr-animation">

<div class=" container-fluid">
<div class=" row">

<div class="col-12 p-0 my-0 m-0 " style=" background-color: black; overflow: hidden;">

<div class=" row">


<div class="col-lg-6 col-12 my-0 mx-0" style="background-image: linear-gradient(to left top, #000000, #140d11, #1e161d, #251e2b, #28283b);">

<div class="col-12 d-flex justify-content-center waviy mt-3 my-5  p-0" >

<span  style="--i:1">C</span>
   <span  style="--i:2">R</span>
   <span style="--i:3">E</span>
   <span style="--i:4">A</span>
   <span style="--i:5">T</span>
   <span style="--i:6">E </span>
   <span style="--i:7">W</span>
   <span style="--i:8">E</span>
   <span style="--i:9">B</span>
   <span style="--i:10">S</span>
   <span style="--i:11">I</span>
   <span style="--i:12">T</span>
   <span style="--i:13">E</span>
</div>

<div class=" col-12 d-flex justify-content-center mt-5">
<div class=" row">
<div class=" col-6 fs-3 d-flex justify-content-center" style=" color: white;">Hi, I'm</div>
<div class=" col-12 d-flex justify-content-center skill"><span style=" color:#F7E10A ;" class=" fs-1 mx-3">Akila Shashimantha</span></div>

<div class=" col-12 d-flex justify-content-center my-0"><p class=" fs-3" style=" color: white;">Web App Developer</p></div>
</div>
</div>

</div>

<div class=" col-lg-6 col-12 d-flex justify-content-center mx-0 mt-lg-0 " style=" background-image: linear-gradient(to right top, #000000, #140d11, #1e161d, #251e2b, #28283b);">

<div class=" col-10 col-lg-7 circle-image" style="background-image: url('<?php echo $profileImage; ?>');">
<!-- My Image -->
</div>

</div>

</div>



</div>

<!-- About Me Part -->

<div class=" col-12 aboutme" style="background-image: radial-gradient(circle, #000000, #030203, #060406, #080709, #09090c);" id="aboutme">

<div class=" row">
<div class=" col-lg-4  d-flex justify-content-center p-4">

<div class=" col-lg-8 image2" style="background-image: url('<?php echo $profileImage; ?>');">
<!-- My Image -->
</div>

</div>

<div class=" col-lg-8 col-12 d-flex justify-content-center">

<div class=" row">

<div class="col-12 d-flex justify-content-center my-0 p-0">
    <h2 class=" my-0 mt-lg-3" style=" color: white; font-family:'Times New Roman', Times, serif;">About Me</h2>
</div>
<div class="col-12 p-2 m-0" style=" color: white;">

<p class="p-0 m-0" style=" color: #B4B4C4;">Enthusiastic and focused Information Technology undergraduate at Horizon
Campus, with a solid background in computer science and a keen interest in
web design and usability. Enjoys using technology to tackle real-world
challenges and is eager to bring creative solutions as part of a team.</p>

</div>

<div class=" col-12 d-flex justify-content-center" style=" color: white;">
<h3>Skills</h3>
</div>

<div class=" col-12 d-flex justify-content-center">
<div class="row">
<!-- Skills -->
<div class=" col-12 d-flex justify-content-center skill" style=" color: #B4B4C4;">HTML & CSS</div>
<div class=" col-12 d-flex justify-content-center skill"  style=" color: #B4B4C4;">JavaScript</div>
<div class=" col-12 d-flex justify-content-center skill"  style=" color: #B4B4C4;">PHP</div>
<div class=" col-12 d-flex justify-content-center skill"  style=" color: #B4B4C4;">MySQL</div>
<div class=" col-12 d-flex justify-content-center skill"  style=" color: #B4B4C4;">Java</div>
<div class=" col-12 d-flex justify-content-center skill"  style=" color: #B4B4C4;">Bootstrap</div>

</div>
</div>

<div class="col-12 d-flex justify-content-center ">
<h3  style=" color: white;">Education</h3>
</div>

<div class=" col-12 d-flex justify-content-center  ">
<p style=" color: #B4B4C4;">I'm currently an undergraduate at Horizon Campus</p>
</div>

</div>

</div>
</div>

<!-- Services -->

<div class="col-12  px-3 m-0" style="background-image: linear-gradient(to bottom, #000000, #13090d, #1d1118, #261622, #2e1b2e); overflow: hidden;" id="services">

<div class=" row">

<div class=" col-12  m-2 d-flex justify-content-center" >
<h2 class="" style=" color: white;">Services</h2>
</div>

<div class=" row justify-content-center">

<?php


$services = Database::select("SELECT * FROM services");

if (!empty($services)) {
  foreach ($services as $row) {
    ?>
    <div class=" col-12 col-lg-4  m-2 service d-flex justify-content-center" style="height: 40vh;">
      <div class="row w-100">
        <div class="col-12 d-flex flex-column align-items-center" >
          <h3 style="color: white; "><?php echo htmlspecialchars($row['title']); ?></h3>
          <div class="col-12 skill" ></div>
        </div>
        <!-- card description -->
        <div class="col-12 d-flex justify-content-center">
          <p class="d-flex justify-content-center " style=" color: #B4B4C4;">
            <?php echo nl2br(htmlspecialchars($row['description'])); ?>
          </p>
        </div>
      </div>
    </div>
    <?php
  }
} else {
  echo '<div class="col-12 d-flex justify-content-center" style="color:#B4B4C4;">No services found.</div>';
}
?>

</div>

</div>
</div>

<!-- My project -->

<div class="col-12" style="background-image: radial-gradient(circle, #000000, #030203, #060406, #080709, #09090c);">
  <div class="row">
    <div class="col-12 d-flex justify-content-center">
      <h2 class="" style="color: white;">My projects</h2>
    </div>

    <!-- Project Cards -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php
      $projects = Database::select("SELECT * FROM projects ORDER BY created_at DESC");
      if (!empty($projects)) {
          foreach ($projects as $proj) {
      ?>
          <div class="col">
              <div class="card h-100 project-card position-relative overflow-hidden">
                  <img src="images/projects/<?php echo htmlspecialchars($proj['featured_image']); ?>" class="card-img-top" alt="Project Image" style="height: 40vh; object-fit:cover;">
                  <div class="card-body d-flex flex-column">
                      <h5 class="card-title"><?php echo htmlspecialchars($proj['name']); ?></h5>
                      <p class="card-text short-desc"><?php echo htmlspecialchars($proj['short_description']); ?></p>
                      <div class="full-desc d-none" style="color:#B4B4C4;">
                          <?php echo nl2br(htmlspecialchars($proj['full_description'])); ?>
                          <div class="mt-3 project-images-scroll" style="max-height:200px; overflow-x:auto; white-space:nowrap;">
                              <?php if (!empty($proj['image1'])): ?>
                                  <img src="images/projects/<?php echo htmlspecialchars($proj['image1']); ?>" class="img-fluid mb-2 me-2 d-inline-block project-thumb" style="max-height:180px; cursor:pointer;">
                              <?php endif; ?>
                              <?php if (!empty($proj['image2'])): ?>
                                  <img src="images/projects/<?php echo htmlspecialchars($proj['image2']); ?>" class="img-fluid mb-2 me-2 d-inline-block project-thumb" style="max-height:180px; cursor:pointer;">
                              <?php endif; ?>
                              <?php if (!empty($proj['image3'])): ?>
                                  <img src="images/projects/<?php echo htmlspecialchars($proj['image3']); ?>" class="img-fluid mb-2 d-inline-block project-thumb" style="max-height:180px; cursor:pointer;">
                              <?php endif; ?>
                          </div>
                      </div>
                      <a href="javascript:void(0);" class="read-more-link mt-auto" style="color:#007bff;">Read More</a>
                      <h6 class="mt-3">GitHub Repository Link</h6>
                      <a href="<?php echo htmlspecialchars($proj['github_link']); ?>" target="_blank"><?php echo htmlspecialchars($proj['github_link']); ?></a>
                  </div>
              </div>
          </div>
      <?php
          }
      } else {
          echo '<div class="col-12 text-center" style="color:#B4B4C4;">No projects found.</div>';
      }
      ?>
    </div>
    <!-- End Project Cards -->
  </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="projectImageModal" tabindex="-1" aria-labelledby="projectImageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark">
      <div class="modal-body p-0">
        <img src="" id="modalProjectImage" class="img-fluid w-100" alt="Project Preview">
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.read-more-link').forEach(function(link) {
    link.addEventListener('click', function() {
        var card = this.closest('.project-card');
        var fullDesc = card.querySelector('.full-desc');
        var shortDesc = card.querySelector('.short-desc');
        var isExpanding = fullDesc.classList.contains('d-none');

        // Collapse all other cards safely
        document.querySelectorAll('.project-card').forEach(function(otherCard) {
            if (otherCard !== card) {
                otherCard.classList.remove('expanded');
                var otherFull = otherCard.querySelector('.full-desc');
                var otherShort = otherCard.querySelector('.short-desc');
                var otherLink = otherCard.querySelector('.read-more-link');
                if (otherFull) otherFull.classList.add('d-none');
                if (otherShort) otherShort.classList.remove('d-none');
                if (otherLink) otherLink.textContent = "Read More";
            }
        });

        // Toggle this card
        if (isExpanding) {
            fullDesc.classList.remove('d-none');
            shortDesc.classList.add('d-none');
            card.classList.add('expanded');
            this.textContent = "Show Less";
            setTimeout(function() {
                var imgScroll = card.querySelector('.project-images-scroll');
                if(imgScroll) imgScroll.scrollLeft = 0;
            }, 300);
        } else {
            fullDesc.classList.add('d-none');
            shortDesc.classList.remove('d-none');
            card.classList.remove('expanded');
            this.textContent = "Read More";
        }
    });
});

// Image click preview
document.querySelectorAll('.project-thumb').forEach(function(img) {
    img.addEventListener('click', function() {
        var modalImg = document.getElementById('modalProjectImage');
        modalImg.src = this.src;
        var modal = new bootstrap.Modal(document.getElementById('projectImageModal'));
        modal.show();
    });
});

// Auto-scroll images horizontally every 2 seconds when expanded
document.querySelectorAll('.project-card').forEach(function(card) {
    let scrollInterval;
    card.addEventListener('mouseenter', function() {
        var imgScroll = card.querySelector('.project-images-scroll');
        if(imgScroll && card.classList.contains('expanded')) {
            let maxScroll = imgScroll.scrollWidth - imgScroll.clientWidth;
            scrollInterval = setInterval(function() {
                if (imgScroll.scrollLeft < maxScroll) {
                    imgScroll.scrollLeft += 180;
                } else {
                    imgScroll.scrollLeft = 0;
                }
            }, 2000);
        }
    });
    card.addEventListener('mouseleave', function() {
        var imgScroll = card.querySelector('.project-images-scroll');
        if(imgScroll) clearInterval(scrollInterval);
    });
});
</script>

<!-- Contact Me -->

<div class=" col-12 d-flex justify-content-center " style=" background-color: black;" id="contactme">
<div class=" row ">

<div class="col-12 d-flex justify-content-center"><h2 style=" color: white;">Contact Me</h2></div>

<div class=" col-12  my-5" style=" background-color:#251e2b; border-radius: 20px;">
    
<div class=" row">

<form action="contactProcess.php" method="post">


    <div class=" col-12 "><label for="" class=" form-label text-white">Enter Your Email</label></div>
   <div class=" col-12"> <input type="email" name="email" id="email" class=" form-control text-center" placeholder="youremail@gmail.com" required></div>

<div class=" col-12 d-flex justify-content-center ">
<div class=" col-12"><Label class=" form-label text-white">Enter Your Message</Label></div>
</div>
<div class=" col-12">
<textarea name="message" id="message" class=" form-control message-area col-12 my-3" placeholder="Enter your message here" rows="8" required></textarea>
</div>
 <div class=" col-12 d-flex justify-content-center my-5"><button class=" btn btn-outline-primary col-8 col-lg-8" type="submit" name="send">Send</button></div>

</form>
</div>
  
</div>

</div>
</div>



<?php
$contact = Database::select("SELECT * FROM contact_details LIMIT 1");
$contact = $contact && count($contact) > 0 ? $contact[0] : null;
?>

<?php if ($contact): ?>
<div class="container-fluid px-0 mx-0" style="background-image: linear-gradient(to bottom, #000000, #13090d, #1d1118, #261622, #2e1b2e); overflow: hidden; width:100%;">
    <div class="row justify-content-center gx-0 mx-0">
        <div class="col-12 px-0 mx-0">
            <div class="bg-dark text-white p-3 rounded-0 text-center m-0">
                <h4 class="mb-3">Contact & Social Links</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3 m-0">
                    <?php if ($contact['email']): ?>
                        <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="text-white fs-4" title="Email">
                            <i class="bi bi-envelope-fill"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($contact['whatsapp']): ?>
                        <a href="https://wa.me/<?php echo htmlspecialchars($contact['whatsapp']); ?>" class="text-success fs-4" title="WhatsApp" target="_blank">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($contact['instagram']): ?>
                        <a href="<?php echo htmlspecialchars($contact['instagram']); ?>" class="text-danger fs-4" title="Instagram" target="_blank">
                            <i class="bi bi-instagram"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($contact['linkedin']): ?>
                        <a href="<?php echo htmlspecialchars($contact['linkedin']); ?>" class="text-primary fs-4" title="LinkedIn" target="_blank">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($contact['facebook']): ?>
                        <a href="<?php echo htmlspecialchars($contact['facebook']); ?>" class="text-primary fs-4" title="Facebook" target="_blank">
                            <i class="bi bi-facebook"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($contact['threads']): ?>
                        <a href="<?php echo htmlspecialchars($contact['threads']); ?>" class="text-dark fs-4" title="Threads" target="_blank">
                            <i class="bi bi-threads"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($contact['github']): ?>
                        <a href="<?php echo htmlspecialchars($contact['github']); ?>" class="text-light fs-4" title="GitHub" target="_blank">
                            <i class="bi bi-github"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
<?php endif; ?>

<!-- Add Bootstrap Icons CDN in your <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Bootstrap JS (if not already included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="script.js"></script>
</body>
</html>