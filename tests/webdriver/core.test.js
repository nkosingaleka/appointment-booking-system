
const path = require('path');
const chromedriver = require('chromedriver');
const { Builder, By } = require('selenium-webdriver');

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

test('This will login in using the correct email and password', async () => {
 let driver = await new Builder().forBrowser("chrome").build();
 await driver.get("http://localhost/setp/front-end/login.php");
 driver.findElement(By.name('email')).sendKeys('as1@test.com');
 driver.findElement(By.name('password')).sendKeys('test123');
 driver.findElement(By.id("login")).click();
})

test('This test will login without the email being entered', async () => {
 let driver = await new Builder().forBrowser("chrome").build();
 await driver.get("http://localhost/setp/front-end/login.php");
 driver.findElement(By.name('email')).sendKeys('');
 driver.findElement(By.name('password')).sendKeys('test123');
 driver.findElement(By.id("login")).click();
})

test('This test will login without the password being entered', async () => {
 let driver = await new Builder().forBrowser("chrome").build();
 await driver.get("http://localhost/setp/front-end/login.php");
 driver.findElement(By.name('email')).sendKeys('as1@test.com');
 driver.findElement(By.name('password')).sendKeys('');
 driver.findElement(By.id("login")).click();
})

test('This test will login without the email or password being entered', async () => {
 let driver = await new Builder().forBrowser("chrome").build();
 await driver.get("http://localhost/setp/front-end/login.php");
 driver.findElement(By.id("login")).click();
})

test('This test will login with an incorrect emaul but correct password', async () => {
 let driver = await new Builder().forBrowser("chrome").build();
 await driver.get("http://localhost/setp/front-end/login.php");
 driver.findElement(By.name('email')).sendKeys('invalidEmail');
 driver.findElement(By.name('password')).sendKeys('test123');
 driver.findElement(By.id("login")).click();
})

test('This test will login with the correct email but incorrect password', async () => {
 let driver = await new Builder().forBrowser("chrome").build();
 await driver.get("http://localhost/setp/front-end/login.php");
 driver.findElement(By.name('email')).sendKeys('as1@test.com');
 driver.findElement(By.name('password')).sendKeys('Test123');
 driver.findElement(By.id("login")).click();
})

test('This test will take the user from the login page to the register page', async () => {
 let driver = await new Builder().forBrowser("chrome").build();
 await driver.get("http://localhost/setp/front-end/login.php");
 driver.findElement(By.id("register")).click();
})