const core = require('./core');

const url = core.url;
const driver = core.driver;
const timeout = core.timeout;
const By = core.By;

beforeAll(async () => {
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

test('This test will login in and try to book an appointment without any inputs', async () => {
    driver.findElement(By.id('email')).sendKeys('pa1@test.com');
    driver.findElement(By.id('password')).sendKeys('test123');
    driver.findElement(By.id('login')).click();
    driver.get(`${url}/front-end/request-appointment.php`);
    driver.findElement(By.id('confirm')).click();
  });
  //driver.findElement(By.id('')).sendKeys('');
  //driver.findElement(By.id('')).click();