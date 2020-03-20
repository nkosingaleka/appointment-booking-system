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

test('This test will log the user in and test the add button on the availability page to test for absent input error message', async () => {
    await driver.findElement(By.id('email')).sendKeys('ms1@test.com');
    await driver.findElement(By.id('password')).sendKeys('test123');
    await driver.findElement(By.id('login')).click();
    await driver.get(`${url}/front-end/add-availability.php`);
    await driver.findElement(By.id("add")).click();
  })

test('This test will log the user in and test the add button on the availability page to test for absent input error message', async () => {
    await driver.findElement(By.id('start_time')).sendKeys('03/15/2020 07:00 AM');
    await driver.findElement(By.id("add")).click();
})

test('This test will log the user in and test the add button on the availability page to test for absent input error message', async () => {
    await driver.findElement(By.id('start_time')).sendKeys('03/15/2020 07:00 AM');
    await driver.findElement(By.id('end_time')).sendKeys('03/15/2020 08:00 PM');
    await driver.findElement(By.id("add")).click();
})
  //await driver.findElement(By.id('')).sendKeys('');