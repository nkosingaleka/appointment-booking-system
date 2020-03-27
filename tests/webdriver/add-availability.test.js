const core = require('./core');

const url = core.url;
const driver = core.driver;
const timeout = core.timeout;
const By = core.By;

beforeAll(async () => {
  try {
    await driver.get(`${url}/front-end/login.php`);
    await driver.findElement(By.id('email')).sendKeys('ms1@test.com');
    await driver.findElement(By.id('password')).sendKeys('test123');
    await driver.findElement(By.id('login')).click();
  } catch (err) {
    console.error(err);
  }
}, timeout);

beforeEach(async () => {
  try {
    await driver.get(`${url}/front-end/add-availability.php`);
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

test('this test will successfully select a time period and book an availible time slot', async () => {
  await driver.executeScript("document.querySelector('#start_time').setAttribute('value', '2020-06-02T16:00')");
  await driver.executeScript("document.querySelector('#end_time').setAttribute('value', '2020-06-02T17:00')");
  await driver.findElement(By.id("add")).click();

  expect(await driver.findElement(By.css('.success-message > ul')).getText()).toBe('New slots have been successfully added.\nYour availability has been successfully added.');
});

test('this test will try to select time slots for which the staff member has already specified their availability', async () => {
  await driver.executeScript("document.querySelector('#start_time').setAttribute('value', '2020-06-02T16:00')");
  await driver.executeScript("document.querySelector('#end_time').setAttribute('value', '2020-06-02T17:00')");
  await driver.findElement(By.id("add")).click();

  expect(await driver.findElement(By.css('.error-message > p')).getText()).toBe('Sorry, you have already added your availability for the specified times.');
});

test('this test will try to book an invalid time where the end date occurs before the start date', async () => {
  await driver.executeScript("document.querySelector('#start_time').setAttribute('value', '2001-06-02T16:00')");
  await driver.executeScript("document.querySelector('#end_time').setAttribute('value', '2000-06-02T17:00')");
  await driver.findElement(By.id("add")).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter an end time after the start time.\nSorry, your times were in an incorrect format. Please check your input and try again.');
});
