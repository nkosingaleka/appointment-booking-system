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

test('This test will log the user in and select the verified button which should just display verified user accounts', async () => {
  await driver.findElement(By.id('email')).sendKeys('as1@test.com');
  await driver.findElement(By.id('password')).sendKeys('test123');
  await driver.findElement(By.id('login')).click();
  await driver.get(`${url}/front-end/patient-accounts.php`);
  driver.findElement(By.id("verified-btn")).click();
})

test('This test will be already on the correct page and will select the unverified button displaying unverified user accounts', async () => {
  driver.findElement(By.id("unverified-btn")).click();
})