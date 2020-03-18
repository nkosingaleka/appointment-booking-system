const core = require('./core');

const url = core.url;
const driver = core.driver;
const timeout = core.timeout;
const By = core.By;

beforeAll(async () => {
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

test('This test will log the user as a patient, access the request page and attempt to cancel with a reason over 255 characters', async () => {
  await driver.findElement(By.id('email')).sendKeys('pa1@test.com');
  await driver.findElement(By.id('password')).sendKeys('test123');
  await driver.findElement(By.id('login')).click();
  await driver.get(`${url}/front-end/requests.php`);
  await driver.findElement(By.css('a[href="?cancel=re-5e6b94fc6ba585.74287938"]')).click();
  await driver.findElement(By.css('textarea[id="re-5e6b94fc6ba585.74287938-reason"]')).sendKeys('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris at risus volutpat, accumsan orci id, pellentesque nisi. Vivamus ligula justo, tincidunt vel pulvinar ac, efficitur in ipsum. Cras ac ipsum arcu. Mauris quis sem justo. Nunc iaculis nisl nec scelerisque. ');
  await driver.findElement(By.css('input[name="re-5e6b94fc6ba585.74287938-reason-submit"]')).click();

  expect(await driver.findElement(By.css('.error-message > ul > li')).getText()).toBe('Please ensure the cancellation reason does not exceed 255 characters.');
});