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
    await driver.get(`${url}/front-end/requests.php`);
  } catch (err) {
    console.error(err);
  }
}, timeout);

afterAll(async () => {
  try {
    await driver.get(`${url}/front-end/scripts/logout.php`);
    await driver.quit();
  } catch (err) {
    console.error(err);
  }
}, timeout);

test('This test will access the patients request page and attempt to cancel an appointment with a reason exceeding 255 characters', async () => {
  await driver.findElement(By.css('a[href="?cancel=re-5e6b94fc6ba585.74287938"]')).click();

  await driver.findElement(By.css('textarea[id="re-5e6b94fc6ba585.74287938-reason"]')).sendKeys('Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. ');
  await driver.findElement(By.css('input[name="re-5e6b94fc6ba585.74287938-reason-submit"]')).click();

  expect(await driver.findElement(By.css('.error-message > p')).getText()).toBe('Please ensure the cancellation reason does not exceed 255 characters.');

});
