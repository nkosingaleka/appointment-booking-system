-- Facility: Example facility
INSERT INTO `facility` (`id`, `name`, `building_name`, `building_no`, `street`, `city`, `county`, `postcode`, `tel_no`) 
  VALUES ('5e4a83211ffd59.63214101', 'Derby Road Group Practice', null, '27-29', 'Derby Rd', 'Portsmouth', 'Hampshire', 'PO2 8HW', '+442392009265');

-- Role: 3 Default roles
INSERT INTO `role` (`description`) VALUES ('administrative_staff');
INSERT INTO `role` (`description`) VALUES ('medical_staff');
INSERT INTO `role` (`description`) VALUES ('patient');

-- Account: Different accounts for each role (password = 'test123')
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('as-5e4685e3c899f1.04316598', 'as1@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 1, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('as-5e46873222d123.80231466', 'as2@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 1, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('ms-5e4685f6e57722.33264537', 'ms1@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 2, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('ms-5e46874b062833.95604018', 'ms2@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 2, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e4686095092e0.76300630', 'pa1@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e46875705e162.50418870', 'pa2@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, true);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e46876f3d9332.22430483', 'pa3@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, false);
INSERT INTO `account` (`id`, `email`, `password`, `role_id`, `verified`) 
  VALUES ('pa-5e468774d36a40.10626920', 'pa4@test.com', '$2y$10$vLmKOHyBeRKCaXap7Xt5nuxc5XoZ1hZjmlIMl/GwK2zL4D2MHpefK', 3, false);

-- Staff: Different accounts for both roles
INSERT INTO `staff` (`id`, `title`, `forename`, `surname`, `sex`, `job_title`, `facility_id`)
  VALUES ('as-5e4685e3c899f1.04316598', 'Mr', 'Matthew', 'Johnson', 'M', 'Receptionist', '5e4a83211ffd59.63214101');
INSERT INTO `staff` (`id`, `title`, `forename`, `surname`, `sex`, `job_title`, `facility_id`)
  VALUES ('as-5e46873222d123.80231466', 'Mrs', 'Stacey', 'Rhodes', 'F', 'Receptionist', '5e4a83211ffd59.63214101');
INSERT INTO `staff` (`id`, `title`, `forename`, `surname`, `sex`, `job_title`, `facility_id`)
  VALUES ('ms-5e4685f6e57722.33264537', 'Dr', 'Jin', 'Xiao', 'M', 'General Practitioner', '5e4a83211ffd59.63214101');
INSERT INTO `staff` (`id`, `title`, `forename`, `surname`, `sex`, `job_title`, `facility_id`)
  VALUES ('ms-5e46874b062833.95604018', 'Dr', 'Margaret', 'Christchurch', 'F', 'General Practitioner', '5e4a83211ffd59.63214101');

-- Next of Kin: Records for each patient record
INSERT INTO `next_of_kin` (`id`, `relationship`, `title`, `forename`, `surname`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`)
  VALUES ('nk-5e4693079a5e18.63580261', 'Father', 'Mr', 'Nerti', 'Philson', null, '7', 'London Road', 'Southampton', 'Hampshire', 'SO15 2AE', '+447691014037', '+448865738896');
INSERT INTO `next_of_kin` (`id`, `relationship`, `title`, `forename`, `surname`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`)
  VALUES ('nk-5e4693969040c3.17276446', 'Mother', 'Mrs', 'Consolata', 'Haverson', null, '6532', 'Ocean Way', 'Southampton', 'Hampshire', 'SO14 3JT', '+443147151972', '+441112173010');
INSERT INTO `next_of_kin` (`id`, `relationship`, `title`, `forename`, `surname`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`)
  VALUES ('nk-5e4694c3ad45f4.91981040', 'Daughter', 'Ms', 'Elvera', 'Zotto', null, '71', 'Willis Rd', 'Portsmouth', 'Hampshire', 'PO1 1AT', '+449404753184', '+445158412207');
INSERT INTO `next_of_kin` (`id`, `relationship`, `title`, `forename`, `surname`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`)
  VALUES ('nk-5e4694507dc976.27152557', 'Son', 'Dr', 'Kirby', 'Botler', 'The Willows', null, 'Wilson St', 'Gosport', 'Hampshire', 'PO12 4PQ', '+449685024267', '+448489534531');

-- Patient: Different records for each patient account
INSERT INTO `patient` (`id`, `title`, `forename`, `surname`, `sex`, `date_of_birth`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`, `next_of_kin`, `NHS_no`, `HC_no`)
  VALUES ('pa-5e4686095092e0.76300630', 'Mr', 'David', 'Bowden', 'M', '1990-01-26', null, '12', 'Meyrick Road', 'Portsmouth', 'Hampshire', 'PO2 RJF', '+447691014037', '+448865738896', 'nk-5e4693079a5e18.63580261', '4562594365', null);
INSERT INTO `patient` (`id`, `title`, `forename`, `surname`, `sex`, `date_of_birth`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`, `next_of_kin`, `NHS_no`, `HC_no`)
  VALUES ('pa-5e46875705e162.50418870', 'Mrs', 'Jeanette', 'Cowles', 'F', '1940-02-12', null, '14', 'Meyrick Road', 'Portsmouth', 'Hampshire', 'PO2 RJF', '+445611214623', '+449869745821', 'nk-5e4693969040c3.17276446', '8074819035', null);
INSERT INTO `patient` (`id`, `title`, `forename`, `surname`, `sex`, `date_of_birth`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`, `next_of_kin`, `NHS_no`, `HC_no`)
  VALUES ('pa-5e46876f3d9332.22430483', 'Mr', 'Bob', 'Zotto', 'M', '1960-08-18', null, '5888', 'Park Drive', 'Gosport', 'Hampshire', 'PO12 6DR', '+446893649145', '+445171936505', 'nk-5e4694c3ad45f4.91981040', '8586218634', null);
INSERT INTO `patient` (`id`, `title`, `forename`, `surname`, `sex`, `date_of_birth`, `house_name`, `house_no`, `street`, `city`, `county`, `postcode`, `tel_no`, `mob_no`, `next_of_kin`, `NHS_no`, `HC_no`)
  VALUES ('pa-5e468774d36a40.10626920', 'Ms', 'Shirley', 'Banks', 'F', '1978-12-05', null, '705', 'Cross St', 'Winchester', 'Hampshire', 'SO20 6Pj', '+447102306288', '+445841903874', 'nk-5e4694507dc976.27152557', '4456772352', null);
