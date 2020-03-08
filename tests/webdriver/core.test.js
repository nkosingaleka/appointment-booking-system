const path = require('path');
const chromedriver = require('chromedriver');
const { Builder } = require('selenium-webdriver');

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
const driver = new Builder()
  .forBrowser('chrome')
  .build();

test('waits for the page to open', async () => {
  await driver.get(url);
});

module.exports = {
  url,
  driver,
  chromedriver,
};
