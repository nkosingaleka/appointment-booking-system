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

test('This test will log the user as a patient, access the request page and attempt to cancel without a reason', async () => {
  await driver.findElement(By.id('email')).sendKeys('pa1@test.com');
  await driver.findElement(By.id('password')).sendKeys('test123');
  await driver.findElement(By.id('login')).click();
  await driver.get(`${url}/front-end/request.php`);
  await driver.get(`${url}/front-end/requests.php?cancel=5e6b94fc6ba585.74287938`);
  await driver.findElement(By.id("5e6b94fc6ba585\.74287938-reason")).sendKeys('Turns out, I am just fine');
  //driver.findElement(By.xpath("//*[contains(text(),'Cancel')]")).click();
  //driver.findElement(By.linkText("Cancel")).click();
  //await driver.findElement(By.className('cancel-btn')).click();
})