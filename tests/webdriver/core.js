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

module.exports = {
  path,
  By,
  timeout,
  url,
  driver,
};
