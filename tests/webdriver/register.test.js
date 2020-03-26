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

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Sorry, the email address you entered has already been taken. Please try again.\nPlease enter a valid password.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter a valid sex.\nPlease enter a valid date of birth.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid password.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter a valid sex.\nPlease enter a valid date of birth.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email and password', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter a valid sex.\nPlease enter a valid date of birth.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password and title', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid forename.\nPlease enter a valid surname.\nPlease enter a valid sex.\nPlease enter a valid date of birth.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title and forename', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid surname.\nPlease enter a valid sex.\nPlease enter a valid date of birth.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename and surname', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid sex.\nPlease enter a valid date of birth.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname and sex', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid date of birth.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex and date of birth', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth and house name', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name and house number', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number and street', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street and city', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city and postcode', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter either your mobile number or telephone number, or both.\nPlease enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode and telephone number', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county , postcode,telephone number and mobile number', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter either your NHS number or Health and Care number (Northern Ireland only).\nPlease enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number and hns number', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.id('Register')).click();

  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs and hc number', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid relationship.\nPlease enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number and nok relationship', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid title.\nPlease enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number, nok relationship and nok title', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid forename.\nPlease enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number, nok relationship, nok title, nok forename', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  await driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid surname.\nPlease enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number, nok relationship, nok title, nok forename and nok surname', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  await driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
  await driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter either a house name or house number, or both.\nPlease enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number, nok relationship, nok title, nok forename, nok surname and nok house name', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  await driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
  await driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
  await driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number, nok relationship, nok title, nok forename, nok surname, nok house name and nok house number', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  await driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
  await driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
  await driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
  await driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid street.\nPlease enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number, nok relationship, nok title, nok forename, nok surname, nok house name, nok house number and nok street', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  await driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
  await driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
  await driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
  await driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
  await driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid city.\nPlease enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number, nok relationship, nok title, nok forename, nok surname, nok house name, nok house number, nok street and nok city', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  await driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
  await driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
  await driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
  await driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
  await driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
  await driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid county.\nPlease enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number, nok relationship, nok title, nok forename, nok surname, nok house name, nok house number, nok street, nok city and nok county', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  await driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
  await driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
  await driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
  await driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
  await driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
  await driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
  await driver.findElement(By.name('next_of_kin[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter a valid postcode.\nPlease enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number, nok relationship, nok title, nok forename, nok surname, nok house name, nok house number, nok street, nok city, nok county and nok postcode', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  await driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
  await driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
  await driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
  await driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
  await driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
  await driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
  await driver.findElement(By.name('next_of_kin[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('next_of_kin[postcode]')).sendKeys('Example3TW');
  await driver.findElement(By.id('Register')).click();
  expect(await driver.findElement(By.css('.error-message > ul')).getText()).toBe('Please enter either your mobile number or telephone number, or both.\nPlease tick the consent box.');

  // Replace required attribute for further tests
  await trueRequired()
});

test('will try to register with just an email, password, title, forename, surname, sex, date of birth, house name, house number, street, city, county, postcode,telephone number mobile number, nhs, hc number, nok relationship, nok title, nok forename, nok surname, nok house name, nok house number, nok street, nok city, nok county, nok postcode and nok tel number', async () => {
    
  // Test HTML5 validation using the 'required' attribute
  expect(await driver.findElements(By.css('input:invalid'))).toHaveLength(18);
  
  // Remove required attribute to test custom validation   
  await removeRequired()

  await driver.findElement(By.name('email')).sendKeys('Example123@gmail.com');
  await driver.findElement(By.name('password')).sendKeys('Example123Password');
  await driver.findElement(By.name('patient[title]')).sendKeys('Mr');
  await driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
  await driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
  await driver.findElement(By.name('patient[sex]')).sendKeys('Male');
  await driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
  await driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
  await driver.findElement(By.name('patient[house_no]')).sendKeys('123');
  await driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
  await driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
  await driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
  await driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
  await driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
  await driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
  await driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
  await driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
  await driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
  await driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
  await driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
  await driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
  await driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
  await driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
  await driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
  await driver.findElement(By.name('next_of_kin[county]')).sendKeys('ExampleCounty');
  await driver.findElement(By.name('next_of_kin[postcode]')).sendKeys('Example3TW');
  await driver.findElement(By.name('next_of_kin[tel_no]')).sendKeys('000000000000003');
  await driver.findElement(By.id('Register')).click();

  // Replace required attribute for further tests
  await trueRequired()
});