const core = require('./core');

const url = core.url;
const driver = core.driver;
const timeout = core.timeout;
const By = core.By;

beforeEach(async () => {
  try {
    await driver.get(`${url}/front-end/register.php`);
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

async function removeRequired(){
  await driver.executeScript("document.querySelector('input[id=email]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=password]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_title]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_forename]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_surname]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('select[id=p_sex]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_date_of_birth]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_house_name]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_house_no]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_street]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_city]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_county]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_postcode]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_tel_no]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_mob_no]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_nhs_no]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=p_hc_no]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_relationship]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_title]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_forename]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_surname]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_house_name]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_house_no]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_street]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_city]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_county]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_postcode]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_tel_no]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=nok_mob_no]').removeAttribute('required')");
  await driver.executeScript("document.querySelector('input[id=consent_check]').removeAttribute('required')");

}

async function trueRequired(){
  await driver.executeScript("document.querySelector('input[id=email]').required = true");
  await driver.executeScript("document.querySelector('input[id=password]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_title]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_forename]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_surname]').required = true");
  await driver.executeScript("document.querySelector('select[id=p_sex]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_date_of_birth]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_house_name]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_house_no]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_street]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_city]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_county]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_postcode]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_tel_no]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_mob_no]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_nhs_no]').required = true");
  await driver.executeScript("document.querySelector('input[id=p_hc_no]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_relationship]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_title]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_forename]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_surname]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_house_name]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_house_no]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_street]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_city]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_county]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_postcode]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_tel_no]').required = true");
  await driver.executeScript("document.querySelector('input[id=nok_mob_no]').required = true");
  await driver.executeScript("document.querySelector('input[name=consent_check]').required = true");
}

test('will try to register without entering in any of the fields', async () => {
  //await driver.findElement(By.name('email')).sendKeys('as1@test.com');
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Sorry, the email address you entered has already been taken. Please try again.\nPlease enter a valid password.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter a valid sex.\nPlease enter a valid date of birth.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nSorry, the NHS number or Health and Care number you entered has already been taken. Please check your input.\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

  // driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
  // driver.findElement(By.name('password')).sendKeys('Example123Password');
  // driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  // driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  // driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  // driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  // driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  // driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  // driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  // driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  // driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  // driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  // driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  // driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  // driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  // driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  // driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  // driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  // driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  // driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
  // driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
  // driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
  // driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
  // driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
  // driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
  // driver.findElement(By.name('next_of_kin[county]')).sendKeys('ExampleCounty');
  // driver.findElement(By.name('next_of_kin[postcode]')).sendKeys('Example3TW');
  // driver.findElement(By.name('next_of_kin[tel_no]')).sendKeys('000000000000003');
  // driver.findElement(By.name('next_of_kin[mob_no]')).sendKeys('000000000000004');
  // driver.findElement(By.name('consent_check')).checked = true;
  // driver.findElement(By.id("Register")).click();