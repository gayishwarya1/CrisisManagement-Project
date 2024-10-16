const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();

  // Set viewport size to ensure the entire map is visible
  await page.setViewport({ width: 800, height: 600 });

  // Load your HTML file containing the map with markers
  await page.goto('http://localhost/CrisisManagement/Crisis/map.php'); // Replace with the URL to your HTML file

  // Wait for map to load (you might need to adjust the timing based on your map loading time)
  await page.waitForSelector('#map');

  // Capture a screenshot of the map with markers
  await page.screenshot({ path: 'map_with_markers.png' });

  await browser.close();
})();
