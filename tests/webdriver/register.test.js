const core = require('./core');

const url = core.url;
const driver = core.driver;
const timeout = core.timeout;
const By = core.By;

beforeAll(async () => {
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

test('Test that the system rejects an empty password', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty email', async () => {
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty title', async () => {
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty Forename', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty surname', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty sex', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty Date of Birth', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty house name', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty house number', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty street name', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty city name', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty county', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty postcode', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty telephone number', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty mobile number', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty NHS number', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty health care number', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin relationship', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin title', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin forename ', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin surname', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplefornameKin');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin house name', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
    driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin house number', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
    driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
    driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin street', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
    driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
    driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
    driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin city', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
    driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
    driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
    driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
    driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin county', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
    driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
    driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
    driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
    driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
    driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin postcode', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
    driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
    driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
    driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
    driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
    driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
    driver.findElement(By.name('next_of_kin[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin telehone number', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
    driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
    driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
    driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
    driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
    driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
    driver.findElement(By.name('next_of_kin[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('next_of_kin[postcode]')).sendKeys('Example3TW');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty next of kin mobile number', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
    driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
    driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
    driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
    driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
    driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
    driver.findElement(By.name('next_of_kin[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('next_of_kin[postcode]')).sendKeys('Example3TW');
    driver.findElement(By.name('next_of_kin[tel_no]')).sendKeys('000000000000003');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system rejects an empty consent tick box', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
    driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
    driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
    driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
    driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
    driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
    driver.findElement(By.name('next_of_kin[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('next_of_kin[postcode]')).sendKeys('Example3TW');
    driver.findElement(By.name('next_of_kin[tel_no]')).sendKeys('000000000000003');
    driver.findElement(By.name('next_of_kin[mob_no]')).sendKeys('000000000000004');
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system enters all inputs fields with the correct data and register an account', async () => {
    driver.findElement(By.name('email')).sendKeys('Example123@mail.com');
    driver.findElement(By.name('password')).sendKeys('Example123Password');
    driver.findElement(By.name('patient[title]')).sendKeys('Mr');
    driver.findElement(By.name('patient[forename]')).sendKeys('ForenameExample');
    driver.findElement(By.name('patient[surname]')).sendKeys('SurenameExample');
    driver.findElement(By.name('patient[sex]')).sendKeys('Male');
    driver.findElement(By.name('patient[date_of_birth]')).sendKeys('01/01/2000');
    driver.findElement(By.name('patient[house_name]')).sendKeys('ExampleHouse');
    driver.findElement(By.name('patient[house_no]')).sendKeys('123');
    driver.findElement(By.name('patient[street]')).sendKeys('ExampleStreet');
    driver.findElement(By.name('patient[city]')).sendKeys('ExampleCity');
    driver.findElement(By.name('patient[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('patient[postcode]')).sendKeys('Example2TW');
    driver.findElement(By.name('patient[tel_no]')).sendKeys('000000000000001');
    driver.findElement(By.name('patient[mob_no]')).sendKeys('000000000000002');
    driver.findElement(By.name('patient[nhs_no]')).sendKeys('Example001');
    driver.findElement(By.name('patient[hc_no]')).sendKeys('Example002');
    driver.findElement(By.name('next_of_kin[relationship]')).sendKeys('ExampleKin');
    driver.findElement(By.name('next_of_kin[title]')).sendKeys('Mr');
    driver.findElement(By.name('next_of_kin[forename]')).sendKeys('ExamplForenameKin');
    driver.findElement(By.name('next_of_kin[surname]')).sendKeys('ExampleSurnameKin');
    driver.findElement(By.name('next_of_kin[house_name]')).sendKeys('ExampleHouseNameKin');
    driver.findElement(By.name('next_of_kin[house_no]')).sendKeys('124');
    driver.findElement(By.name('next_of_kin[street]')).sendKeys('ExampleStreetKin');
    driver.findElement(By.name('next_of_kin[city]')).sendKeys('ExampleCityKin');
    driver.findElement(By.name('next_of_kin[county]')).sendKeys('ExampleCounty');
    driver.findElement(By.name('next_of_kin[postcode]')).sendKeys('Example3TW');
    driver.findElement(By.name('next_of_kin[tel_no]')).sendKeys('000000000000003');
    driver.findElement(By.name('next_of_kin[mob_no]')).sendKeys('000000000000004');
    driver.findElement(By.name('consent_check')).checked = true;
    driver.findElement(By.id("Register")).click();
  });

  test('Test that the system can take the user to the login page', async () => {
    driver.findElement(By.id("login")).click();
  });

  test('Test that the system will reject an attempt to register and account with no details', async () => {
    driver.findElement(By.id("Register")).click();
  });

  //driver.findElement(By.name('next_of_kin[]')).sendKeys('');
  //driver.findElement(By.name('')).sendKeys('');
