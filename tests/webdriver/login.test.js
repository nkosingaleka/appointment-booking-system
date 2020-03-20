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

test('This will login in using the correct email and password', async () => {
  driver.findElement(By.name('email')).sendKeys('as1@test.com');
  driver.findElement(By.name('password')).sendKeys('test123');
  driver.findElement(By.id("login")).click();
});

test('This test will login without the email being entered', async () => {
  driver.findElement(By.name('email')).sendKeys('');
  driver.findElement(By.name('password')).sendKeys('test123');
  driver.findElement(By.id("login")).click();
});

test('This test will login without the password being entered', async () => {
  driver.findElement(By.name('email')).sendKeys('as1@test.com');
  driver.findElement(By.name('password')).sendKeys('');
  driver.findElement(By.id("login")).click();
});

test('This test will login without the email or password being entered', async () => {
  driver.findElement(By.id("login")).click();
});

test('This test will login with an incorrect emaul but correct password', async () => {
  driver.findElement(By.name('email')).sendKeys('invalidEmail');
  driver.findElement(By.name('password')).sendKeys('test123');
  driver.findElement(By.id("login")).click();
});

test('This test will login with the correct email but incorrect password', async () => {
  driver.findElement(By.name('email')).sendKeys('as1@test.com');
  driver.findElement(By.name('password')).sendKeys('Test123');
  driver.findElement(By.id("login")).click();
});

test('This test will take the user from the login page to the register page', async () => {
  driver.findElement(By.id("register")).click();
});
