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

test('Test that the system rejects an empty password', async () => {
    driver.findElement(By.name('period_choice')).sendKeys('09/03/2020 - 15/03/2020');
    driver.findElement(By.id("confirm")).click();
  });