const core = require('./core');

const url = core.url;
const driver = core.driver;
const timeout = core.timeout;
const By = core.By;

beforeEach(async () => {
  try {
    await driver.get(`${url}/front-end/login.php`);
    await driver.findElement(By.id('email')).sendKeys('pa1@test.com');
    await driver.findElement(By.id('password')).sendKeys('test123');
    await driver.findElement(By.id('login')).click();
    await driver.get(`${url}/front-end/requests.php`);
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

test('This test will access the patients request page and attempt to cancel an appointment with a reason exceeding 255 characters', async () => {
  
})