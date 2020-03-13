const path = require('path');
const chromedriver = require('chromedriver');
const { Builder, By } = require('selenium-webdriver');

// Set default timeout
const timeout = 10000;

// Get root directory path
const rootUrl = path.resolve(__dirname, '..', '..');

// Retrieve sections of url
let rootUrlPieces = [];
let breadcrumb = '';

// Define local testing URL
let url = 'http://localhost';

if (rootUrl.includes('htdocs')) {
  // (XAMPP) Extract breadcrumb from after xampp/htdocs/
  rootUrlPieces = rootUrl.split('htdocs');
  breadcrumb = rootUrlPieces[rootUrlPieces.length - 1];
  breadcrumb = breadcrumb.replace(new RegExp('\\' + path.sep, 'g'), '/');

  url += breadcrumb;
}

// Create driver for Chrome browser
let driver = new Builder()
  .forBrowser('chrome')
  .build();

beforeAll(async () => {
  try {
    await driver.get(`${url}/front-end/request-appointment.php`);
  } catch (err) {
    console.error(err);
  }
}, timeout);

afterAll(async () => {
  try {
    await driver.quit();
  } catch (err) {
    console.error(err);
  }
}, timeout);

test('Test that the system rejects an empty password', async () => {
    driver.findElement(By.name('period_choice')).sendKeys('09/03/2020 - 15/03/2020');
    driver.findElement(By.id("confirm")).click();
  });