<?php include 'header.php'; ?>
<?php include 'about.php'; ?>

<!-- Call to Action Section -->
<section id="call-to-action" class="call-to-action section">
  <div class="container">
    <img src="assets/img/cta-bg.jpg" alt="">
    <div class="content row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
      <div class="col-xl-10">
        <div class="text-center">
          <a href="https://www.youtube.com/watch?v=YU7VMFrFUy0" class="glightbox play-btn"></a>
          <h3>Call To Action</h3>
          <p>The effect of climate change that affected the city of Toulouse, France.</p>
          <a class="cta-btn" href="#">Call To Action</a>
        </div>
      </div>
    </div>
  </div>
</section><!-- /Call To Action Section -->

<!-- Contact Section -->
<section id="contact" class="contact section">
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Contact</h2>
    <p>Please write us about the recent crisis</p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gx-lg-0 gy-4">
      <div class="col-lg-4">
        <div class="info-container d-flex flex-column align-items-center justify-content-center">
          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
            <i class="bi bi-geo-alt flex-shrink-0"></i>
            <div>
              <h3>Address</h3>
              <p>17 Rue Sainte Catherine, Toulouse, 31400, France</p>
            </div>
          </div><!-- End Info Item -->

          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-telephone flex-shrink-0"></i>
            <div>
              <h3>Call Us</h3>
              <p>+33 0695 8697 52</p>
            </div>
          </div><!-- End Info Item -->

          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
            <i class="bi bi-envelope flex-shrink-0"></i>
            <div>
              <h3>Email Us</h3>
              <p>info@example.com</p>
            </div>
          </div><!-- End Info Item -->

          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
            <i class="bi bi-clock flex-shrink-0"></i>
            <div>
              <h3>Open Hours:</h3>
              <p>Mon-Sat: 11AM - 11PM</p>
            </div>
          </div><!-- End Info Item -->
        </div>
      </div>

      <div class="col-lg-8">
        <?php
        if (isset($_GET['error'])) {
          echo "<div class='alert alert-danger'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        if (isset($_GET['success'])) {
          echo "<div class='alert alert-success'>" . htmlspecialchars($_GET['success']) . "</div>";
        }
        ?>

        <form id="feedbackForm" action="process_feedback.php" method="post" class="php-email-form" data-aos="fade" data-aos-delay="100">
          <div class="row gy-4">
            <div class="col-md-12">
              <label for="scenarioSelect">Select Current Year Crisis Scenario</label>
              <select class="form-control" id="scenarioSelect" name="selectedScenario" required>
                <option value="">-- Select a Scenario --</option>
                <?php
                // Include config.php to establish database connection
                include 'config.php';

                // Get the current year
                $current_year = date('Y');

                // Query to fetch crisis scenarios occurring in the current year
                $query = "SELECT * FROM CrisisScenario WHERE YEAR(StartingTimeC) = '$current_year'";
                $result = $mysqli->query($query);

                // Check if there are any errors with the query
                if (!$result) {
                  echo "<option value=''>Error fetching CrisisScenarios: " . $mysqli->error . "</option>";
                }

                // Check if there are any crisis scenarios for the current year
                if ($result->num_rows > 0) {
                  // Loop through each scenario and create dropdown items
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['ID_ScenarioC']) . "'>" . htmlspecialchars($row['CrisisName']) . "</option>";
                  }
                } else {
                  // No crisis scenarios found for the current year
                  echo "<option value=''>No crisis scenarios found for $current_year</option>";
                }

                // Close database connection
                $mysqli->close();
                ?>
              </select>
            </div>
            <div class="col-md-6">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
              <!-- Add a unique id for each form field -->
            </div>

            <div class="col-md-6">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
              <!-- Add a unique id for each form field -->
            </div>

            <div class="col-md-12">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              <!-- Add a unique id for each form field -->
            </div>

            <div class="col-md-12">
              <textarea class="form-control" name="message" id="message" rows="8" placeholder="Message" required></textarea>
              <!-- Add a unique id for each form field -->
            </div>

            <div class="col-md-12 text-center">
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>

              <button type="submit">Send Message</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section><!-- /Contact Section -->

<?php include 'footer.php'; ?>

<!-- Include necessary JavaScript files <script src="validate1.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>


</main>
