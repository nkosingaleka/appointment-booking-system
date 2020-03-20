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

test('This test will login in and try to book an appointment without any inputs', async () => {
  await driver.findElement(By.id('email')).sendKeys('pa1@test.com');
  await driver.findElement(By.id('password')).sendKeys('test123');
  await driver.findElement(By.id('login')).click();
  await driver.get(`${url}/front-end/request-appointment.php`);
  await driver.findElement(By.id('confirm')).click();
  });
  
test('This test will login and check that the appointment error message occurs', async () => {
  await driver.findElement(By.id('period_choice')).sendKeys('30/03/2000 - 05/04/2020');
  await driver.findElement(By.id('confirm')).click();
  });

test('This test will login and check if the translation choice error occurs ', async () => {
  await driver.findElement(By.id('period_choice')).sendKeys('30/03/2000 - 05/04/2020');
  await driver.findElement(By.id('appointment_reason')).sendKeys('Im a very very ill person');
  await driver.findElement(By.id('confirm')).click();
  });

test('This test will login and check if the preferred staff error occurs ', async () => {
  await driver.findElement(By.id('period_choice')).sendKeys('30/03/2000 - 05/04/2020');
  await driver.findElement(By.id('appointment_reason')).sendKeys('Im a very very ill person');
  await driver.findElement(By.id('translation_choice')).sendKeys('None (English)');
  await driver.findElement(By.id('confirm')).click();
  });

test('This test will login and check if the select time button error occurs ', async () => {
  await driver.findElement(By.id('period_choice')).sendKeys('30/03/2000 - 05/04/2020');
  await driver.findElement(By.id('appointment_reason')).sendKeys('Im a very very ill person');
  await driver.findElement(By.id('translation_choice')).sendKeys('None (English)');
  await driver.findElement(By.id('staff_choice')).sendKeys('Dr Jin Xiao');
  await driver.findElement(By.id('confirm')).click();
  });

test('This test will login and check all the relevant inputs and book an appointment', async () => {
  await driver.findElement(By.id('period_choice')).sendKeys('30/03/2000 - 05/04/2020');
  await driver.findElement(By.id('appointment_reason')).sendKeys('Im a very very ill person');
  await driver.findElement(By.id('translation_choice')).sendKeys('None (English)');
  await driver.findElement(By.id('staff_choice')).sendKeys('Dr Jin Xiao');
  await driver.get(`${url}/front-end/request-appointment.php?slots[]=5e66129c4eac29.70227478&slots[]=5e66129c4eabf9.91464955&slots[]=5e66129c4ea760.40052205&slots[]=5e66129c4ea731.94488395&slots[]=5e66129c4eac54.45234853`);
  await driver.findElement(By.id('confirm')).click();
  });
  
