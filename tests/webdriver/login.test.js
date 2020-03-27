const core = require('./core');

const url = core.url;
const driver = core.driver;
const timeout = core.timeout;
const By = core.By;

beforeEach(async () => {
  try {
    await driver.get(`${url}/front-end/login.php`);
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

test('Logs in using the correct email and password', async () => {
  await driver.findElement(By.name('email')).sendKeys('as1@test.com');
  await driver.findElement(By.name('password')).sendKeys('test123');
  await driver.findElement(By.id("login")).click();

  // Log out
  await driver.get(`${url}/front-end/scripts/logout.php`);
});

test('Fails to log in with an empty email address', async () => {
  await driver.findElement(By.name('password')).sendKeys('test123');
  await driver.findElement(By.id("login")).click();

  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(1);

  // Remove required attribute to test custom validation
  await driver.executeScript("document.querySelector('input[name=email]').removeAttribute('required')");
  await driver.findElement(By.id("login")).click();

  expect(await driver.findElement(By.css('.error-message > p')).getText()).toBe('Sorry, your email address was not found. Please check your input and try again.');

  // Replace required attribute for further tests
  await driver.executeScript("document.querySelector('input[name=email]').required = true");
});

test('Fails to log in with an empty password', async () => {
  await driver.findElement(By.name('email')).sendKeys('as1@test.com');
  await driver.findElement(By.id("login")).click();

  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(1);

  // Remove required attribute to test custom validation
  await driver.executeScript("document.querySelector('input[name=password]').removeAttribute('required')");
  await driver.findElement(By.id("login")).click();

  expect(await driver.findElement(By.css('.error-message > p')).getText()).toBe('Sorry, your email address and password combination was incorrect. Please check your input and try again.');

  // Replace required attribute for further tests
  await driver.executeScript("document.querySelector('input[name=password]').required = true");
});

test('Fails to log in with an invalid email address', async () => {
  driver.findElement(By.name('email')).sendKeys('invalidEmail');
  driver.findElement(By.name('password')).sendKeys('test123');
  driver.findElement(By.id("login")).click();

  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(2);

  // Remove required attribute and email type to test custom validation
  await driver.executeScript("document.querySelector('input[name=email]').setAttribute('type', 'text')");
  await driver.executeScript("document.querySelector('input[name=email]').removeAttribute('required')");
  await driver.findElement(By.id("login")).click();

  await driver.findElements(By.css('.error-message > ul > li')).then(found => expect(found.length).toBe(2));

  // Replace required attribute for further tests
  await driver.executeScript("document.querySelector('input[name=email]').required = true");
});

test('Fails to log in with an incorrect password', async () => {
  await driver.findElement(By.name('email')).sendKeys('as1@test.com');
  await driver.findElement(By.name('password')).sendKeys('Test123');
  await driver.findElement(By.id("login")).click();

  expect(await driver.findElement(By.css('.error-message > p')).getText()).toBe('Sorry, your email address and password combination was incorrect. Please check your input and try again.');
});

test('Opens the registration page when the register link is clicked', async () => {
  await driver.findElement(By.id("register")).click();

  await driver.getTitle().then(title => expect(title).toBe('Appointment Booking System — Register'));
});
