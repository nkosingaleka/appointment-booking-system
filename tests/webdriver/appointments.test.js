const core = require('./core');

const url = core.url;
const driver = core.driver;
const timeout = core.timeout;
const By = core.By;

beforeAll(async () => {
  try {
    await driver.get(`${url}/front-end/login.php`);
    await driver.findElement(By.id('email')).sendKeys('as1@test.com');
    await driver.findElement(By.id('password')).sendKeys('test123');
    await driver.findElement(By.id('login')).click();
  } catch (err) {
    console.error(err);
  }
}, timeout);

beforeEach(async () => {
  try {
    await driver.get(`${url}/front-end/appointments.php`);
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
  await driver.findElement(By.css('a[href="?cancel=ap-5e777c661e2a32.34520912"]')).click();
  await driver.findElement(By.css('textarea[id="ap-5e777c661e2a32.34520912-reason"]'))
    .sendKeys('Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. Everything is fine. ');
  await driver.findElement(By.css('input[name="ap-5e777c661e2a32.34520912-reason-submit"]')).click();

  expect(await driver.findElement(By.css('.error-message > p')).getText()).toBe('Please ensure the cancellation reason does not exceed 255 characters.');
});

test('This test will access the patients request page and attempt to cancel an appointment with no error', async () => {
  await driver.findElement(By.css('a[href="?cancel=ap-5e777c661e2a32.23234569"]')).click();
  await driver.findElement(By.css('textarea[id="ap-5e777c661e2a32.23234569-reason"]')).sendKeys('Everything is fine.');
  await driver.findElement(By.css('input[name="ap-5e777c661e2a32.23234569-reason-submit"]')).click();

  expect(await driver.findElement(By.css('.success-message > p')).getText()).toBe('Your appointment has been successfully cancelled.');
});
