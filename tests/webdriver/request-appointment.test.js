const core = require('./core');

const url = core.url;
const driver = core.driver;
const timeout = core.timeout;
const By = core.By;

beforeAll(async () => {
  try {
    await driver.get(`${url}/front-end/login.php`);
    await driver.findElement(By.id('email')).sendKeys('pa1@test.com');
    await driver.findElement(By.id('password')).sendKeys('test123');
    await driver.findElement(By.id('login')).click();
  } catch (err) {
    console.error(err);
  }
}, timeout);

beforeEach(async () => {
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

test('This test will try to book an appointment without any inputs', async () => {
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('select:invalid'))).toHaveLength(1);

  // Remove required attribute to test custom validation
  await driver.executeScript("document.querySelector('select[name=staff_choice]').removeAttribute('required')");

  await driver.findElement(By.id('confirm')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a preferred staff.\nPlease select at least one slot.');

  // Replace required attribute for further tests
  await driver.executeScript("document.querySelector('select[name=staff_choice]').required = true");
});
