<?php
include 'header.php';
include 'config.php';

// Fetch all scenarios in ascending order by ID
$query = "SELECT * FROM CrisisScenario ORDER BY CAST(SUBSTRING(ID_ScenarioC, 2) AS UNSIGNED)";
$result = $mysqli->query($query);

// Check if the query was successful
if (!$result) {
    die('Query Error (' . $mysqli->errno . ') ' . $mysqli->error);
}

// Fetch scenarios into an array
$scenarios = [];
while ($scenario = $result->fetch_assoc()) {
    $scenarios[] = $scenario;
}
?>

<main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Crisis Scenario</h1>
                        <p class="mb-0">In the face of an unexpected disaster, every second counts. Stay informed and prepared with real-time updates and actionable solutions to ensure your safety and resilience.</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li class="current">Crisis Scenario</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Blog Posts Section -->
    <section id="blog-posts" class="blog-posts section">
        <div class="container">
            <?php if (count($scenarios) > 0): ?>
                <?php foreach (array_chunk($scenarios, 4) as $scenario_chunk): ?>
                    <div class="row gy-4">
                        <?php foreach ($scenario_chunk as $scenario): ?>
                            <div class="col-lg-3">
                                <article>
                                    <div class="post-img">
                                        <img src="data:image/jpeg;base64,<?= base64_encode($scenario['ImageC']) ?>" alt="<?= htmlspecialchars($scenario['CrisisName']) ?>" class="img-fluid">
                                    </div>
                                    <p class="post-category"><?= htmlspecialchars($scenario['CrisisName']) ?></p>
                                    <h2 class="title">
                                        <a href="CrisisScenarioDetails.php?id=<?= htmlspecialchars($scenario['ID_ScenarioC']) ?>">
                                            <?= htmlspecialchars($scenario['CrisisType']) ?> in <?= htmlspecialchars($scenario['CityNameC']) ?>, <?= htmlspecialchars($scenario['CountryNameC']) ?>
                                        </a>
                                    </h2>
                                    <div class="d-flex align-items-center">
                                        <div class="post-meta">
                                            <p class="post-author"><?= htmlspecialchars($scenario['AreaC']) ?></p>
                                            <p class="post-date">
                                                <time datetime="<?= htmlspecialchars($scenario['StartingTimeC']) ?>"><?= date('M d, Y', strtotime($scenario['StartingTimeC'])) ?></time>
                                            </p>
                                        </div>
                                    </div>
                                </article>
                            </div><!-- End post list item -->
                        <?php endforeach; ?>
                    </div><!-- End row -->
                    <hr class="my-5"> <!-- Add horizontal rule between rows -->
                <?php endforeach; ?>
            <?php else: ?>
                <p>No crisis scenarios found.</p>
            <?php endif; ?>
        </div>
    </section><!-- /Blog Posts Section -->

</main>
<?php include 'footer.php'; ?>

</body>
</html>
